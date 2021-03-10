<?php
include_once("bean.config.php");

/**
 * Class BeanSetor
 * Bean class for object oriented management of the MySQL table setor
 *
 * Comment of the managed table setor: Not specified.
 *
 * Responsibility:
 *
 *  - provides instance constructors for both managing of a fetched table or for a new row
 *  - provides destructor to automatically close database connection
 *  - defines a set of attributes corresponding to the table fields
 *  - provides setter and getter methods for each attribute
 *  - provides OO methods for simplify DML select, insert, update and delete operations.
 *  - provides a facility for quickly updating a previously fetched row
 *  - provides useful methods to obtain table DDL and the last executed SQL statement
 *  - provides error handling of SQL statement
 *  - uses Camel/Pascal case naming convention for Attributes/Class used for mapping of Fields/Table
 *  - provides useful PHPDOC information about the table, fields, class, attributes and methods.
 *
 * @extends MySqlRecord
 * @filesource BeanSetor.php
 * @category MySql Database Bean Class
 * @package beans
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @note  This is an auto generated PHP class builded with MVCMySqlReflection, a small code generation engine extracted from the author's personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
*/

// namespace beans;

class BeanSetor extends MySqlRecord
{
    /**
     * A control attribute for the update operation.
     * @note An instance fetched from db is allowed to run the update operation.
     *       A new instance (not fetched from db) is allowed only to run the insert operation but,
     *       after running insertion, the instance is automatically allowed to run update operation.
     * @var bool
     */
    private $allowUpdate = false;

    /**
     * Class attribute for mapping the primary key id of table setor
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    private $id;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field nome
     *
     * Comment for field nome: Not specified.<br>
     * Field information:
     *  - Data type: varchar(50)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $nome
     */
    private $nome;

    /**
     * Class attribute for mapping table field setor_alias
     *
     * Comment for field setor_alias: Not specified.<br>
     * Field information:
     *  - Data type: varchar(50)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $setorAlias
     */
    private $setorAlias;

    /**
     * Class attribute for mapping table field style
     *
     * Comment for field style: Not specified.<br>
     * Field information:
     *  - Data type: varchar(50)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $style
     */
    private $style;

    /**
     * Class attribute for mapping table field cor
     *
     * Comment for field cor: Not specified.<br>
     * Field information:
     *  - Data type: varchar(50)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $cor
     */
    private $cor;

    /**
     * Class attribute for mapping table field tempo
     *
     * Comment for field tempo: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $tempo
     */
    private $tempo;

    /**
     * Class attribute for mapping table field habilita
     *
     * Comment for field habilita: Not specified.<br>
     * Field information:
     *  - Data type: tinyint(1)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $habilita
     */
    private $habilita;

    /**
     * Class attribute for storing the SQL DDL of table setor
     * @var string base64 encoded string for DDL
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBzZXRvcmAgKAogIGBpZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwKICBgbm9tZWAgdmFyY2hhcig1MCkgREVGQVVMVCBOVUxMLAogIGBzZXRvcl9hbGlhc2AgdmFyY2hhcig1MCkgREVGQVVMVCBOVUxMLAogIGBzdHlsZWAgdmFyY2hhcig1MCkgREVGQVVMVCBOVUxMLAogIGBjb3JgIHZhcmNoYXIoNTApIERFRkFVTFQgTlVMTCwKICBgdGVtcG9gIGludCgxMSkgREVGQVVMVCBOVUxMLAogIGBoYWJpbGl0YWAgdGlueWludCgxKSBERUZBVUxUIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGBpZGApLAogIFVOSVFVRSBLRVkgYGlkYCAoYGlkYCkKKSBFTkdJTkU9SW5ub0RCIEFVVE9fSU5DUkVNRU5UPTkgREVGQVVMVCBDSEFSU0VUPWxhdGluMQ==";

    /**
     * setId Sets the class attribute id with a given value
     *
     * The attribute id maps the field id defined as int(11).<br>
     * Comment for field id: Not specified.<br>
     * @param int $id
     * @category Modifier
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * setNome Sets the class attribute nome with a given value
     *
     * The attribute nome maps the field nome defined as varchar(50).<br>
     * Comment for field nome: Not specified.<br>
     * @param string $nome
     * @category Modifier
     */
    public function setNome($nome)
    {
        $this->nome = (string)$nome;
    }

    /**
     * setSetorAlias Sets the class attribute setorAlias with a given value
     *
     * The attribute setorAlias maps the field setor_alias defined as varchar(50).<br>
     * Comment for field setor_alias: Not specified.<br>
     * @param string $setorAlias
     * @category Modifier
     */
    public function setSetorAlias($setorAlias)
    {
        $this->setorAlias = (string)$setorAlias;
    }

    /**
     * setStyle Sets the class attribute style with a given value
     *
     * The attribute style maps the field style defined as varchar(50).<br>
     * Comment for field style: Not specified.<br>
     * @param string $style
     * @category Modifier
     */
    public function setStyle($style)
    {
        $this->style = (string)$style;
    }

    /**
     * setCor Sets the class attribute cor with a given value
     *
     * The attribute cor maps the field cor defined as varchar(50).<br>
     * Comment for field cor: Not specified.<br>
     * @param string $cor
     * @category Modifier
     */
    public function setCor($cor)
    {
        $this->cor = (string)$cor;
    }

    /**
     * setTempo Sets the class attribute tempo with a given value
     *
     * The attribute tempo maps the field tempo defined as int(11).<br>
     * Comment for field tempo: Not specified.<br>
     * @param int $tempo
     * @category Modifier
     */
    public function setTempo($tempo)
    {
        $this->tempo = (int)$tempo;
    }

    /**
     * setHabilita Sets the class attribute habilita with a given value
     *
     * The attribute habilita maps the field habilita defined as tinyint(1).<br>
     * Comment for field habilita: Not specified.<br>
     * @param int $habilita
     * @category Modifier
     */
    public function setHabilita($habilita)
    {
        $this->habilita = (int)$habilita;
    }

    /**
     * getId gets the class attribute id value
     *
     * The attribute id maps the field id defined as int(11).<br>
     * Comment for field id: Not specified.
     * @return int $id
     * @category Accessor of $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * getNome gets the class attribute nome value
     *
     * The attribute nome maps the field nome defined as varchar(50).<br>
     * Comment for field nome: Not specified.
     * @return string $nome
     * @category Accessor of $nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * getSetorAlias gets the class attribute setorAlias value
     *
     * The attribute setorAlias maps the field setor_alias defined as varchar(50).<br>
     * Comment for field setor_alias: Not specified.
     * @return string $setorAlias
     * @category Accessor of $setorAlias
     */
    public function getSetorAlias()
    {
        return $this->setorAlias;
    }

    /**
     * getStyle gets the class attribute style value
     *
     * The attribute style maps the field style defined as varchar(50).<br>
     * Comment for field style: Not specified.
     * @return string $style
     * @category Accessor of $style
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * getCor gets the class attribute cor value
     *
     * The attribute cor maps the field cor defined as varchar(50).<br>
     * Comment for field cor: Not specified.
     * @return string $cor
     * @category Accessor of $cor
     */
    public function getCor()
    {
        return $this->cor;
    }

    /**
     * getTempo gets the class attribute tempo value
     *
     * The attribute tempo maps the field tempo defined as int(11).<br>
     * Comment for field tempo: Not specified.
     * @return int $tempo
     * @category Accessor of $tempo
     */
    public function getTempo()
    {
        return $this->tempo;
    }

    /**
     * getHabilita gets the class attribute habilita value
     *
     * The attribute habilita maps the field habilita defined as tinyint(1).<br>
     * Comment for field habilita: Not specified.
     * @return int $habilita
     * @category Accessor of $habilita
     */
    public function getHabilita()
    {
        return $this->habilita;
    }

    /**
     * Gets DDL SQL code of the table setor
     * @return string
     * @category Accessor
     */
    public function getDdl()
    {
        return base64_decode($this->ddl);
    }

    /**
    * Gets the name of the managed table
    * @return string
    * @category Accessor
    */
    public function getTableName()
    {
        return "setor";
    }

    /**
     * The BeanSetor constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $id is given.
     *  - with a fetched data row from the table setor having id=$id
     * @param int $id. If omitted an empty (not fetched) instance is created.
     * @return BeanSetor Object
     */
    public function __construct($id = null)
    {
        parent::__construct();
        if (!empty($id)) {
            $this->select($id);
        }
    }

    /**
     * The implicit destructor
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Explicit destructor. It calls the implicit destructor automatically.
     */
    public function close()
    {
        unset($this);
    }

    /**
     * Fetchs a table row of setor into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $id the primary key id value of table setor which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($id)
    {
        $sql =  "SELECT * FROM setor WHERE id={$this->parseValue($id,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->id = (integer)$rowObject->id;
            @$this->nome = $this->replaceAposBackSlash($rowObject->nome);
            @$this->setorAlias = $this->replaceAposBackSlash($rowObject->setor_alias);
            @$this->style = $this->replaceAposBackSlash($rowObject->style);
            @$this->cor = $this->replaceAposBackSlash($rowObject->cor);
            @$this->tempo = (integer)$rowObject->tempo;
            @$this->habilita = (integer)$rowObject->habilita;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table setor
     * @param int $id the primary key id value of table setor which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($id)
    {
        $sql = "DELETE FROM setor WHERE id={$this->parseValue($id,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of setor
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->id = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO setor
            (nome,setor_alias,style,cor,tempo,habilita)
            VALUES(
			{$this->parseValue($this->nome,'notNumber')},
			{$this->parseValue($this->setorAlias,'notNumber')},
			{$this->parseValue($this->style,'notNumber')},
			{$this->parseValue($this->cor,'notNumber')},
			{$this->parseValue($this->tempo)},
			{$this->parseValue($this->habilita)})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->id = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table setor with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $id the primary key id value of table setor which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($id)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                setor
            SET 
				nome={$this->parseValue($this->nome,'notNumber')},
				setor_alias={$this->parseValue($this->setorAlias,'notNumber')},
				style={$this->parseValue($this->style,'notNumber')},
				cor={$this->parseValue($this->cor,'notNumber')},
				tempo={$this->parseValue($this->tempo)},
				habilita={$this->parseValue($this->habilita)}
            WHERE
                id={$this->parseValue($id,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($id);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of setor previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->id != "") {
            return $this->update($this->id);
        } else {
            return false;
        }
    }

}
?>
