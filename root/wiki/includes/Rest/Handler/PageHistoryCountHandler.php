<?php

namespace MediaWiki\Rest\Handler;

use MediaWiki\Permissions\PermissionManager;
use MediaWiki\Rest\LocalizedHttpException;
use MediaWiki\Rest\SimpleHandler;
use MediaWiki\Rest\Response;
use MediaWiki\Revision\RevisionRecord;
use MediaWiki\Revision\RevisionStore;
use MediaWiki\Storage\NameTableAccessException;
use MediaWiki\Storage\NameTableStore;
use MediaWiki\Storage\NameTableStoreFactory;
use RequestContext;
use User;
use WANObjectCache;
use Wikimedia\Message\MessageValue;
use Wikimedia\Message\ParamType;
use Wikimedia\Message\ScalarParam;
use Wikimedia\ParamValidator\ParamValidator;
use Title;
use Wikimedia\Rdbms\ILoadBalancer;

/**
 * Handler class for Core REST API endpoints that perform operations on revisions
 */
class PageHistoryCountHandler extends SimpleHandler {
	/** The maximum number of counts to return per type of revision */
	private const COUNT_LIMITS = [
		'anonymous' => 10000,
		'bot' => 10000,
		'editors' => 25000,
		'edits' => 30000,
		'minor' => 1000,
		'reverted' => 30000
	];

	private const DEPRECATED_COUNT_TYPES = [
		'anonedits' => 'anonymous',
		'botedits' => 'bot',
		'revertededits' => 'reverted'
	];

	private const REVERTED_TAG_NAMES = [ 'mw-undo', 'mw-rollback' ];

	/** @var RevisionStore */
	private $revisionStore;

	/** @var NameTableStore */
	private $changeTagDefStore;

	/** @var PermissionManager */
	private $permissionManager;

	/** @var ILoadBalancer */
	private $loadBalancer;

	/** @var WANObjectCache */
	private $cache;

	/** @var User */
	private $user;

	/**
	 * @param RevisionStore $revisionStore
	 * @param NameTableStoreFactory $nameTableStoreFactory
	 * @param PermissionManager $permissionManager
	 * @param ILoadBalancer $loadBalancer
	 * @param WANObjectCache $cache
	 */
	public function __construct(
		RevisionStore $revisionStore,
		NameTableStoreFactory $nameTableStoreFactory,
		PermissionManager $permissionManager,
		ILoadBalancer $loadBalancer,
		WANObjectCache $cache
	) {
		$this->revisionStore = $revisionStore;
		$this->changeTagDefStore = $nameTableStoreFactory->getChangeTagDef();
		$this->permissionManager = $permissionManager;
		$this->loadBalancer = $loadBalancer;
		$this->cache = $cache;

		// @todo Inject this, when there is a good way to do that
		$this->user = RequestContext::getMain()->getUser();
	}

	private function normalizeType( $type ) {
		return self::DEPRECATED_COUNT_TYPES[$type] ?? $type;
	}

	/**
	 * Validates that the provided parameter combination is supported.
	 *
	 * @param string $type
	 * @throws LocalizedHttpException
	 */
	private function validateParameterCombination( $type ) {
		$params = $this->getValidatedParams();
		if ( !$params ) {
			return;
		}

		if ( $params['from'] || $params['to'] ) {
			if ( $type === 'edits' || $type === 'editors' ) {
				if ( !$params['from'] || !$params['to'] ) {
					throw new LocalizedHttpException(
						new MessageValue( 'rest-pagehistorycount-parameters-invalid' ),
						400
					);
				}
			} else {
				throw new LocalizedHttpException(
					new MessageValue( 'rest-pagehistorycount-parameters-invalid' ),
					400
				);
			}
		}
	}

	/**
	 * @param string $title
	 * @param string $type
	 * @return Response
	 * @throws LocalizedHttpException
	 */
	public function run( $title, $type ) {
		$normalizedType = $this->normalizeType( $type );
		$this->validateParameterCombination( $normalizedType );
		$titleObj = Title::newFromText( $title );
		if ( !$titleObj || !$titleObj->getArticleID() ) {
			throw new LocalizedHttpException(
				new MessageValue( 'rest-nonexistent-title',
					[ new ScalarParam( ParamType::PLAINTEXT, $title ) ]
				),
				404
			);
		}

		if ( !$this->permissionManager->userCan( 'read', $this->user, $titleObj ) ) {
			throw new LocalizedHttpException(
				new MessageValue( 'rest-permission-denied-title',
					[ new ScalarParam( ParamType::PLAINTEXT, $title ) ]
				),
				403
			);
		}

		$count = $this->getCount( $titleObj, $normalizedType );
		$countLimit = self::COUNT_LIMITS[$normalizedType];
		$response = $this->getResponseFactory()->createJson( [
				'count' => $count > $countLimit ? $countLimit : $count,
				'limit' => $count > $countLimit
		] );

		// Inform clients who use a deprecated "type" value, so they can adjust
		if ( isset( self::DEPRECATED_COUNT_TYPES[$type] ) ) {
			$docs = '<https://www.mediawiki.org/wiki/API:REST/History_API' .
				'#Get_page_history_counts>; rel="deprecation"';
			$response->setHeader( 'Deprecation', 'version="v1"' );
			$response->setHeader( 'Link', $docs );
		}

		return $response;
	}

	/**
	 * @param Title $title the title of the page to load history for
	 * @param string $type the validated count type
	 * @return int the article count
	 * @throws LocalizedHttpException
	 */
	private function getCount( $title, $type ) {
		switch ( $type ) {
			case 'anonymous':
				return $this->getCachedCount( $title, $type,
					function ( RevisionRecord $fromRev = null ) use ( $title ) {
						return $this->getAnonCount( $title->getArticleID(), $fromRev );
					}
				);

			case 'bot':
				return $this->getCachedCount( $title, $type,
					function ( RevisionRecord $fromRev = null ) use ( $title ) {
						return $this->getBotCount( $title->getArticleID(), $fromRev );
					}
				);

			case 'editors':
				$from = $this->getValidatedParams()['from'] ?? null;
				$to = $this->getValidatedParams()['to'] ?? null;
				if ( $from || $to ) {
					return $this->getEditorsCount(
						$title->getArticleID(),
						$from ? $this->getRevisionOrThrow( $from ) : null,
						$to ? $this->getRevisionOrThrow( $to ) : null
					);
				} else {
					return $this->getCachedCount( $title, $type,
						function ( RevisionRecord $fromRev = null ) use ( $title ) {
							return $this->getEditorsCount( $title->getArticleID(), $fromRev );
						}, false
					);
				}

			case 'edits':
				$from = $this->getValidatedParams()['from'] ?? null;
				$to = $this->getValidatedParams()['to'] ?? null;
				if ( $from || $to ) {
					return $this->getEditsCount(
						$title->getArticleID(),
						$from ? $this->getRevisionOrThrow( $from ) : null,
						$to ? $this->getRevisionOrThrow( $to ) : null
					);
				} else {
					return $this->getCachedCount( $title, $type,
						function ( RevisionRecord $fromRev = null ) use ( $title ) {
							return $this->getEditsCount( $title->getArticleID(), $fromRev );
						}
					);
				}

			case 'reverted':
				return $this->getCachedCount( $title, $type,
					function ( RevisionRecord $fromRev = null ) use ( $title ) {
						return $this->getRevertedCount( $title->getArticleID(), $fromRev );
					}
				);

			case 'minor':
				// The query for minor counts is inefficient for the database for pages with many revisions.
				// If the specified title contains more revisions than allowed, we will return an error.
				$editsCount = $this->getCachedCount( $title, 'edits',
					function ( RevisionRecord $fromRev = null ) use ( $title ) {
						return $this->getEditsCount( $title->getArticleID(), $fromRev );
					}
				);
				if ( $editsCount > self::COUNT_LIMITS[$type] * 2 ) {
					throw new LocalizedHttpException(
						new MessageValue( 'rest-pagehistorycount-too-many-revisions' ),
						500
					);
				}
				return $this->getCachedCount( $title, $type,
					function ( RevisionRecord $fromRev = null ) use ( $title ) {
						return $this->getMinorCount( $title->getArticleID(), $fromRev );
					}
				);

			// Sanity check
			default:
				throw new LocalizedHttpException(
					new MessageValue( 'rest-pagehistorycount-type-unrecognized',
						[ new ScalarParam( ParamType::PLAINTEXT, $type ) ]
					),
					500
				);
		}
	}

	/**
	 * @param Title $title
	 * @param string $type
	 * @param callable $fetchCount
	 * @param bool $incrementalUpdate
	 * @return int
	 */
	private function getCachedCount( $title, $type,
		callable $fetchCount, $incrementalUpdate = true
	) {
		$pageId = $title->getArticleID();
		return $this->cache->getWithSetCallback(
			$this->cache->makeKey( 'rest', 'pagehistorycount', $pageId, $type ),
			WANObjectCache::TTL_WEEK,
			function ( $oldValue ) use ( $title, $fetchCount, $incrementalUpdate ) {
				$currentRev = $this->revisionStore->getKnownCurrentRevision( $title );
				if ( $oldValue && $incrementalUpdate ) {
					if ( $oldValue['revision'] === $currentRev->getId() ) {
						// Should never happen, but just in case
						return $oldValue;
					}
					$rev = $this->revisionStore->getRevisionById( $oldValue['revision'] );
					if ( $rev ) {
						$additionalCount = $fetchCount( $rev );
						return [
							'revision' => $currentRev->getId(),
							'count' => $oldValue['count'] + $additionalCount
						];
					}
				}
				// Nothing was previously stored, or incremental update was done for too long,
				// recalculate from scratch.
				return [
					'revision' => $currentRev->getId(),
					'count' => $fetchCount()
				];
			},
			[
				'touchedCallback' => function () use ( $title ) {
					return wfTimestampOrNull(
						TS_UNIX,
						$this->revisionStore->getKnownCurrentRevision( $title )->getTimestamp()
					);
				},
				'checkKeys' => [
					"RevDelRevisionList:page:$pageId",
					"DerivedPageDataUpdater:restore:page:$pageId"
				],
				'version' => 1,
				'lockTSE' => WANObjectCache::TTL_MINUTE * 5
			]
		)['count'];
	}

	/**
	 * @param int $pageId the id of the page to load history for
	 * @param RevisionRecord|null $fromRev
	 * @return int the count
	 */
	protected function getAnonCount( $pageId, RevisionRecord $fromRev = null ) {
		$dbr = $this->loadBalancer->getConnectionRef( DB_REPLICA );

		$cond = [
			'rev_page' => $pageId,
			'actor_user IS NULL',
			$dbr->bitAnd( 'rev_deleted',
				RevisionRecord::DELETED_TEXT | RevisionRecord::DELETED_USER ) . " = 0"
		];

		if ( $fromRev ) {
			$oldTs = $dbr->addQuotes( $dbr->timestamp( $fromRev->getTimestamp() ) );
			$cond[] = "(rev_timestamp = {$oldTs} AND rev_id > {$fromRev->getId()}) " .
				"OR rev_timestamp > {$oldTs}";
		}

		$edits = $dbr->selectRowCount(
			[
				'revision_actor_temp',
				'revision',
				'actor'
			],
			'1',
			$cond,
			__METHOD__,
			[ 'LIMIT' => self::COUNT_LIMITS['anonymous'] + 1 ], // extra to detect truncation
			[
				'revision' => [
					'JOIN',
					'revactor_rev = rev_id AND revactor_page = rev_page'
				],
				'actor' => [
					'JOIN',
					'revactor_actor = actor_id'
				]
			]
		);
		return $edits;
	}

	/**
	 * @param int $pageId the id of the page to load history for
	 * @param RevisionRecord|null $fromRev
	 * @return int the count
	 */
	protected function getBotCount( $pageId, RevisionRecord $fromRev = null ) {
		$dbr = $this->loadBalancer->getConnectionRef( DB_REPLICA );

		$cond = [
			'rev_page=' . intval( $pageId ),
			$dbr->bitAnd( 'rev_deleted',
				RevisionRecord::DELETED_TEXT | RevisionRecord::DELETED_USER ) . " = 0",
			'EXISTS(' .
				$dbr->selectSQLText(
					'user_groups',
					1,
					[
						'actor.actor_user = ug_user',
						'ug_group' => $this->permissionManager->getGroupsWithPermission( 'bot' ),
						'ug_expiry IS NULL OR ug_expiry >= ' . $dbr->addQuotes( $dbr->timestamp() )
					],
					__METHOD__
				) .
			')'
		];
		if ( $fromRev ) {
			$oldTs = $dbr->addQuotes( $dbr->timestamp( $fromRev->getTimestamp() ) );
			$cond[] = "(rev_timestamp = {$oldTs} AND rev_id > {$fromRev->getId()}) " .
				"OR rev_timestamp > {$oldTs}";
		}

		$edits = $dbr->selectRowCount(
			[
				'revision_actor_temp',
				'revision',
				'actor',
			],
			'1',
			$cond,
			__METHOD__,
			[ 'LIMIT' => self::COUNT_LIMITS['bot'] + 1 ], // extra to detect truncation
			[
				'revision' => [
					'JOIN',
					'revactor_rev = rev_id AND revactor_page = rev_page'
				],
				'actor' => [
					'JOIN',
					'revactor_actor = actor_id'
				],
			]
		);
		return $edits;
	}

	/**
	 * @param int $pageId the id of the page to load history for
	 * @param RevisionRecord|null $fromRev
	 * @param RevisionRecord|null $toRev
	 * @return int the count
	 */
	protected function getEditorsCount( $pageId,
		RevisionRecord $fromRev = null,
		RevisionRecord $toRev = null
	) {
		list( $fromRev, $toRev ) = $this->orderRevisions( $fromRev, $toRev );
		return $this->revisionStore->countAuthorsBetween( $pageId, $fromRev,
			$toRev, $this->user, self::COUNT_LIMITS['editors'] );
	}

	/**
	 * @param int $pageId the id of the page to load history for
	 * @param RevisionRecord|null $fromRev
	 * @return int the count
	 */
	protected function getRevertedCount( $pageId, RevisionRecord $fromRev = null ) {
		$tagIds = [];

		foreach ( self::REVERTED_TAG_NAMES as $tagName ) {
			try {
				$tagIds[] = $this->changeTagDefStore->getId( $tagName );
			} catch ( NameTableAccessException $e ) {
				// If no revisions are tagged with a name, no tag id will be present
			}
		}
		if ( !$tagIds ) {
			return 0;
		}

		$dbr = $this->loadBalancer->getConnectionRef( DB_REPLICA );

		$cond = [
			'rev_page' => $pageId,
			$dbr->bitAnd( 'rev_deleted', RevisionRecord::DELETED_TEXT ) . " = 0"
		];
		if ( $fromRev ) {
			$oldTs = $dbr->addQuotes( $dbr->timestamp( $fromRev->getTimestamp() ) );
			$cond[] = "(rev_timestamp = {$oldTs} AND rev_id > {$fromRev->getId()}) " .
				"OR rev_timestamp > {$oldTs}";
		}
		$edits = $dbr->selectRowCount(
			[
				'revision',
				'change_tag'
			],
			'1',
			[ 'rev_page' => $pageId ],
			__METHOD__,
			[
				'LIMIT' => self::COUNT_LIMITS['reverted'] + 1, // extra to detect truncation
				'GROUP BY' => 'rev_id'
			],
			[
				'change_tag' => [
					'JOIN',
					[
						'ct_rev_id = rev_id',
						'ct_tag_id' => $tagIds,
					]
				],
			]
		);
		return $edits;
	}

	/**
	 * @param int $pageId the id of the page to load history for
	 * @param RevisionRecord|null $fromRev
	 * @return int the count
	 */
	protected function getMinorCount( $pageId, RevisionRecord $fromRev = null ) {
		$dbr = $this->loadBalancer->getConnectionRef( DB_REPLICA );
		$cond = [
			'rev_page' => $pageId,
			'rev_minor_edit != 0',
			$dbr->bitAnd( 'rev_deleted', RevisionRecord::DELETED_TEXT ) . " = 0"
		];
		if ( $fromRev ) {
			$oldTs = $dbr->addQuotes( $dbr->timestamp( $fromRev->getTimestamp() ) );
			$cond[] = "(rev_timestamp = {$oldTs} AND rev_id > {$fromRev->getId()}) " .
				"OR rev_timestamp > {$oldTs}";
		}
		$edits = $dbr->selectRowCount( 'revision', '1',
			$cond,
			__METHOD__,
			[ 'LIMIT' => self::COUNT_LIMITS['minor'] + 1 ] // extra to detect truncation
		);

		return $edits;
	}

	/**
	 * @param int $pageId the id of the page to load history for
	 * @param RevisionRecord|null $fromRev
	 * @param RevisionRecord|null $toRev
	 * @return int the count
	 */
	protected function getEditsCount(
		$pageId,
		RevisionRecord $fromRev = null,
		RevisionRecord $toRev = null
	) {
		list( $fromRev, $toRev ) = $this->orderRevisions( $fromRev, $toRev );
		return $this->revisionStore->countRevisionsBetween(
			$pageId,
			$fromRev,
			$toRev,
			self::COUNT_LIMITS['edits'] // Will be increased by 1 to detect truncation
		);
	}

	/**
	 * @param int $revId
	 * @return RevisionRecord
	 * @throws LocalizedHttpException
	 */
	private function getRevisionOrThrow( $revId ) {
		$rev = $this->revisionStore->getRevisionById( $revId );
		if ( !$rev ) {
			throw new LocalizedHttpException(
				new MessageValue( 'rest-nonexistent-revision', [ $revId ] ),
				404
			);
		}
		return $rev;
	}

	/**
	 * Reorders revisions if they are present
	 * @param RevisionRecord|null $fromRev
	 * @param RevisionRecord|null $toRev
	 * @return array
	 * @phan-return array{0:RevisionRecord|null,1:RevisionRecord|null}
	 */
	private function orderRevisions(
		RevisionRecord $fromRev = null,
		RevisionRecord $toRev = null
	) {
		if ( $fromRev && $toRev && ( $fromRev->getTimestamp() > $toRev->getTimestamp() ||
				( $fromRev->getTimestamp() === $toRev->getTimestamp()
					&& $fromRev->getId() > $toRev->getId() ) )
		) {
			return [ $toRev, $fromRev ];
		}
		return [ $fromRev, $toRev ];
	}

	public function needsWriteAccess() {
		return false;
	}

	public function getParamSettings() {
		return [
			'title' => [
				self::PARAM_SOURCE => 'path',
				ParamValidator::PARAM_TYPE => 'string',
				ParamValidator::PARAM_REQUIRED => true,
			],
			'type' => [
				self::PARAM_SOURCE => 'path',
				ParamValidator::PARAM_TYPE => array_merge(
					array_keys( self::COUNT_LIMITS ),
					array_keys( self::DEPRECATED_COUNT_TYPES )
				),
				ParamValidator::PARAM_REQUIRED => true,
			],
			'from' => [
				self::PARAM_SOURCE => 'query',
				ParamValidator::PARAM_TYPE => 'integer',
				ParamValidator::PARAM_REQUIRED => false
			],
			'to' => [
				self::PARAM_SOURCE => 'query',
				ParamValidator::PARAM_TYPE => 'integer',
				ParamValidator::PARAM_REQUIRED => false
			]
		];
	}
}
