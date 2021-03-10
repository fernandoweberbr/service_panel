<?php
include_once("bean.config.php");

/**
 * Class BeanUsuario
 * Bean class for object oriented management of the MySQL table usuario
 *
 * Comment of the managed table usuario: Not specified.
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
 * @filesource BeanUsuario.php
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

class BeanUsuario extends MySqlRecord
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
     * Class attribute for mapping the primary key id of table usuario
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
     * Class attribute for mapping table field usuario_alias
     *
     * Comment for field usuario_alias: Not specified.<br>
     * Field information:
     *  - Data type: varchar(50)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $usuarioAlias
     */
    private $usuarioAlias;

    /**
     * Class attribute for mapping table field nivel_usuario
     *
     * Comment for field nivel_usuario: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $nivelUsuario
     */
    private $nivelUsuario;

    /**
     * Class attribute for mapping table field data_nascimento
     *
     * Comment for field data_nascimento: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $dataNascimento
     */
    private $dataNascimento;

    /**
     * Class attribute for mapping table field senha
     *
     * Comment for field senha: Not specified.<br>
     * Field information:
     *  - Data type: varchar(50)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $senha
     */
    private $senha;

    /**
     * Class attribute for mapping table field data_ultimo_login
     *
     * Comment for field data_ultimo_login: Not specified.<br>
     * Field information:
     *  - Data type: timestamp
     *  - Null : NO
     *  - DB Index: 
     *  - Default: CURRENT_TIMESTAMP
     *  - Extra:  on update CURRENT_TIMESTAMP
     * @var string $dataUltimoLogin
     */
    private $dataUltimoLogin;

    /**
     * Class attribute for mapping table field data_cadastro
     *
     * Comment for field data_cadastro: Not specified.<br>
     * Field information:
     *  - Data type: datetime
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $dataCadastro
     */
    private $dataCadastro;

    /**
     * Class attribute for mapping table field email
     *
     * Comment for field email: Not specified.<br>
     * Field information:
     *  - Data type: varchar(100)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $email
     */
    private $email;

    /**
     * Class attribute for mapping table field ativado
     *
     * Comment for field ativado: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $ativado
     */
    private $ativado;

    /**
     * Class attribute for storing the SQL DDL of table usuario
     * @var string base64 encoded string for DDL
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGB1c3VhcmlvYCAoCiAgYGlkYCBpbnQoMTEpIE5PVCBOVUxMIEFVVE9fSU5DUkVNRU5ULAogIGBub21lYCB2YXJjaGFyKDUwKSBERUZBVUxUIE5VTEwsCiAgYHVzdWFyaW9fYWxpYXNgIHZhcmNoYXIoNTApIERFRkFVTFQgTlVMTCwKICBgbml2ZWxfdXN1YXJpb2AgaW50KDExKSBERUZBVUxUIE5VTEwsCiAgYGRhdGFfbmFzY2ltZW50b2AgZGF0ZSBERUZBVUxUIE5VTEwsCiAgYHNlbmhhYCB2YXJjaGFyKDUwKSBERUZBVUxUIE5VTEwsCiAgYGRhdGFfdWx0aW1vX2xvZ2luYCB0aW1lc3RhbXAgTk9UIE5VTEwgREVGQVVMVCBDVVJSRU5UX1RJTUVTVEFNUCBPTiBVUERBVEUgQ1VSUkVOVF9USU1FU1RBTVAsCiAgYGRhdGFfY2FkYXN0cm9gIGRhdGV0aW1lIE5PVCBOVUxMLAogIGBlbWFpbGAgdmFyY2hhcigxMDApIE5PVCBOVUxMLAogIGBhdGl2YWRvYCBpbnQoMTEpIE5PVCBOVUxMLAogIFBSSU1BUlkgS0VZIChgaWRgKSwKICBVTklRVUUgS0VZIGBpZGAgKGBpZGApCikgRU5HSU5FPUlubm9EQiBBVVRPX0lOQ1JFTUVOVD0xNiBERUZBVUxUIENIQVJTRVQ9bGF0aW4x";

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
     * setUsuarioAlias Sets the class attribute usuarioAlias with a given value
     *
     * The attribute usuarioAlias maps the field usuario_alias defined as varchar(50).<br>
     * Comment for field usuario_alias: Not specified.<br>
     * @param string $usuarioAlias
     * @category Modifier
     */
    public function setUsuarioAlias($usuarioAlias)
    {
        $this->usuarioAlias = (string)$usuarioAlias;
    }

    /**
     * setNivelUsuario Sets the class attribute nivelUsuario with a given value
     *
     * The attribute nivelUsuario maps the field nivel_usuario defined as int(11).<br>
     * Comment for field nivel_usuario: Not specified.<br>
     * @param int $nivelUsuario
     * @category Modifier
     */
    public function setNivelUsuario($nivelUsuario)
    {
        $this->nivelUsuario = (int)$nivelUsuario;
    }

    /**
     * setDataNascimento Sets the class attribute dataNascimento with a given value
     *
     * The attribute dataNascimento maps the field data_nascimento defined as string|date.<br>
     * Comment for field data_nascimento: Not specified.<br>
     * @param string $dataNascimento
     * @category Modifier
     */
    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = (string)$dataNascimento;
    }

    /**
     * setSenha Sets the class attribute senha with a given value
     *
     * The attribute senha maps the field senha defined as varchar(50).<br>
     * Comment for field senha: Not specified.<br>
     * @param string $senha
     * @category Modifier
     */
    public function setSenha($senha)
    {
        $this->senha = (string)$senha;
    }

    /**
     * setDataUltimoLogin Sets the class attribute dataUltimoLogin with a given value
     *
     * The attribute dataUltimoLogin maps the field data_ultimo_login defined as timestamp.<br>
     * Comment for field data_ultimo_login: Not specified.<br>
     * @param string $dataUltimoLogin
     * @category Modifier
     */
    public function setDataUltimoLogin($dataUltimoLogin)
    {
        $this->dataUltimoLogin = (string)$dataUltimoLogin;
    }

    /**
     * setDataCadastro Sets the class attribute dataCadastro with a given value
     *
     * The attribute dataCadastro maps the field data_cadastro defined as datetime.<br>
     * Comment for field data_cadastro: Not specified.<br>
     * @param string $dataCadastro
     * @category Modifier
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = (string)$dataCadastro;
    }

    /**
     * setEmail Sets the class attribute email with a given value
     *
     * The attribute email maps the field email defined as varchar(100).<br>
     * Comment for field email: Not specified.<br>
     * @param string $email
     * @category Modifier
     */
    public function setEmail($email)
    {
        $this->email = (string)$email;
    }

    /**
     * setAtivado Sets the class attribute ativado with a given value
     *
     * The attribute ativado maps the field ativado defined as int(11).<br>
     * Comment for field ativado: Not specified.<br>
     * @param int $ativado
     * @category Modifier
     */
    public function setAtivado($ativado)
    {
        $this->ativado = (int)$ativado;
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
     * getUsuarioAlias gets the class attribute usuarioAlias value
     *
     * The attribute usuarioAlias maps the field usuario_alias defined as varchar(50).<br>
     * Comment for field usuario_alias: Not specified.
     * @return string $usuarioAlias
     * @category Accessor of $usuarioAlias
     */
    public function getUsuarioAlias()
    {
        return $this->usuarioAlias;
    }

    /**
     * getNivelUsuario gets the class attribute nivelUsuario value
     *
     * The attribute nivelUsuario maps the field nivel_usuario defined as int(11).<br>
     * Comment for field nivel_usuario: Not specified.
     * @return int $nivelUsuario
     * @category Accessor of $nivelUsuario
     */
    public function getNivelUsuario()
    {
        return $this->nivelUsuario;
    }

    /**
     * getDataNascimento gets the class attribute dataNascimento value
     *
     * The attribute dataNascimento maps the field data_nascimento defined as string|date.<br>
     * Comment for field data_nascimento: Not specified.
     * @return string $dataNascimento
     * @category Accessor of $dataNascimento
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * getSenha gets the class attribute senha value
     *
     * The attribute senha maps the field senha defined as varchar(50).<br>
     * Comment for field senha: Not specified.
     * @return string $senha
     * @category Accessor of $senha
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * getDataUltimoLogin gets the class attribute dataUltimoLogin value
     *
     * The attribute dataUltimoLogin maps the field data_ultimo_login defined as timestamp.<br>
     * Comment for field data_ultimo_login: Not specified.
     * @return string $dataUltimoLogin
     * @category Accessor of $dataUltimoLogin
     */
    public function getDataUltimoLogin()
    {
        return $this->dataUltimoLogin;
    }

    /**
     * getDataCadastro gets the class attribute dataCadastro value
     *
     * The attribute dataCadastro maps the field data_cadastro defined as datetime.<br>
     * Comment for field data_cadastro: Not specified.
     * @return string $dataCadastro
     * @category Accessor of $dataCadastro
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * getEmail gets the class attribute email value
     *
     * The attribute email maps the field email defined as varchar(100).<br>
     * Comment for field email: Not specified.
     * @return string $email
     * @category Accessor of $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * getAtivado gets the class attribute ativado value
     *
     * The attribute ativado maps the field ativado defined as int(11).<br>
     * Comment for field ativado: Not specified.
     * @return int $ativado
     * @category Accessor of $ativado
     */
    public function getAtivado()
    {
        return $this->ativado;
    }

    /**
     * Gets DDL SQL code of the table usuario
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
        return "usuario";
    }

    /**
     * The BeanUsuario constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $id is given.
     *  - with a fetched data row from the table usuario having id=$id
     * @param int $id. If omitted an empty (not fetched) instance is created.
     * @return BeanUsuario Object
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
     * Fetchs a table row of usuario into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $id the primary key id value of table usuario which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($id)
    {
        $sql =  "SELECT * FROM usuario WHERE id={$this->parseValue($id,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->id = (integer)$rowObject->id;
            @$this->nome = $this->replaceAposBackSlash($rowObject->nome);
            @$this->usuarioAlias = $this->replaceAposBackSlash($rowObject->usuario_alias);
            @$this->nivelUsuario = (integer)$rowObject->nivel_usuario;
            @$this->dataNascimento = empty($rowObject->data_nascimento) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->data_nascimento));
            @$this->senha = $this->replaceAposBackSlash($rowObject->senha);
            @$this->dataUltimoLogin = $rowObject->data_ultimo_login;
            @$this->dataCadastro = empty($rowObject->data_cadastro) ? null : date(FETCHED_DATETIME_FORMAT,strtotime($rowObject->data_cadastro));
            @$this->email = $this->replaceAposBackSlash($rowObject->email);
            @$this->ativado = (integer)$rowObject->ativado;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table usuario
     * @param int $id the primary key id value of table usuario which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($id)
    {
        $sql = "DELETE FROM usuario WHERE id={$this->parseValue($id,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of usuario
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
            INSERT INTO usuario
            (nome,usuario_alias,nivel_usuario,data_nascimento,senha,data_ultimo_login,data_cadastro,email,ativado)
            VALUES(
			{$this->parseValue($this->nome,'notNumber')},
			{$this->parseValue($this->usuarioAlias,'notNumber')},
			{$this->parseValue($this->nivelUsuario)},
			{$this->parseValue($this->dataNascimento,'date')},
			{$this->parseValue($this->senha,'notNumber')},
			{$this->parseValue($this->dataUltimoLogin,'notNumber')},
			{$this->parseValue($this->dataCadastro,'datetime')},
			{$this->parseValue($this->email,'notNumber')},
			{$this->parseValue($this->ativado)})
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
     * Updates a specific row from the table usuario with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $id the primary key id value of table usuario which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($id)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                usuario
            SET 
				nome={$this->parseValue($this->nome,'notNumber')},
				usuario_alias={$this->parseValue($this->usuarioAlias,'notNumber')},
				nivel_usuario={$this->parseValue($this->nivelUsuario)},
				data_nascimento={$this->parseValue($this->dataNascimento,'date')},
				senha={$this->parseValue($this->senha,'notNumber')},
				data_ultimo_login={$this->parseValue($this->dataUltimoLogin,'notNumber')},
				data_cadastro={$this->parseValue($this->dataCadastro,'datetime')},
				email={$this->parseValue($this->email,'notNumber')},
				ativado={$this->parseValue($this->ativado)}
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
     * Facility for updating a row of usuario previously loaded.
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
