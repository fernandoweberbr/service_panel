<?php
include_once("bean.config.php");

/**
 * Class BeanAtividade
 * Bean class for object oriented management of the MySQL table atividade
 *
 * Comment of the managed table atividade: Not specified.
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
 * @filesource BeanAtividade.php
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

class BeanAtividade extends MySqlRecord
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
     * Class attribute for mapping the primary key id of table atividade
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
     * Class attribute for mapping table field ordem
     *
     * Comment for field ordem: Not specified.<br>
     * Field information:
     *  - Data type: varchar(50)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $ordem
     */
    private $ordem;

    /**
     * Class attribute for mapping table field descricao
     *
     * Comment for field descricao: Not specified.<br>
     * Field information:
     *  - Data type: varchar(54)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $descricao
     */
    private $descricao;

    /**
     * Class attribute for mapping table field realizada
     *
     * Comment for field realizada: Not specified.<br>
     * Field information:
     *  - Data type: tinyint(1)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $realizada
     */
    private $realizada;

    /**
     * Class attribute for mapping table field finalizada
     *
     * Comment for field finalizada: Not specified.<br>
     * Field information:
     *  - Data type: tinyint(1)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var int $finalizada
     */
    private $finalizada;

    /**
     * Class attribute for mapping table field aviso
     *
     * Comment for field aviso: Not specified.<br>
     * Field information:
     *  - Data type: varchar(50)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $aviso
     */
    private $aviso;

    /**
     * Class attribute for mapping table field data_inicio
     *
     * Comment for field data_inicio: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $dataInicio
     */
    private $dataInicio;

    /**
     * Class attribute for mapping table field data_limite
     *
     * Comment for field data_limite: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $dataLimite
     */
    private $dataLimite;

    /**
     * Class attribute for mapping table field fk_setor
     *
     * Comment for field fk_setor: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $fkSetor
     */
    private $fkSetor;

    /**
     * Class attribute for mapping table field fk_usuario
     *
     * Comment for field fk_usuario: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $fkUsuario
     */
    private $fkUsuario;

    /**
     * Class attribute for mapping table field fk_importancia
     *
     * Comment for field fk_importancia: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : YES
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $fkImportancia
     */
    private $fkImportancia;

    /**
     * Class attribute for storing the SQL DDL of table atividade
     * @var string base64 encoded string for DDL
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBhdGl2aWRhZGVgICgKICBgaWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsCiAgYG9yZGVtYCB2YXJjaGFyKDUwKSBERUZBVUxUIE5VTEwsCiAgYGRlc2NyaWNhb2AgdmFyY2hhcig1NCkgREVGQVVMVCBOVUxMLAogIGByZWFsaXphZGFgIHRpbnlpbnQoMSkgREVGQVVMVCBOVUxMLAogIGBmaW5hbGl6YWRhYCB0aW55aW50KDEpIERFRkFVTFQgTlVMTCwKICBgYXZpc29gIHZhcmNoYXIoNTApIERFRkFVTFQgTlVMTCwKICBgZGF0YV9pbmljaW9gIGRhdGUgREVGQVVMVCBOVUxMLAogIGBkYXRhX2xpbWl0ZWAgZGF0ZSBERUZBVUxUIE5VTEwsCiAgYGZrX3NldG9yYCBpbnQoMTEpIERFRkFVTFQgTlVMTCwKICBgZmtfdXN1YXJpb2AgaW50KDExKSBERUZBVUxUIE5VTEwsCiAgYGZrX2ltcG9ydGFuY2lhYCBpbnQoMTEpIERFRkFVTFQgTlVMTCwKICBQUklNQVJZIEtFWSAoYGlkYCksCiAgVU5JUVVFIEtFWSBgaWRgIChgaWRgKSwKICBLRVkgYEZLX0F0aXZpZGFkZV8yYCAoYGZrX3NldG9yYCksCiAgS0VZIGBGS19BdGl2aWRhZGVfM2AgKGBma191c3VhcmlvYCksCiAgS0VZIGBGS19BdGl2aWRhZGVfNGAgKGBma19pbXBvcnRhbmNpYWApLAogIENPTlNUUkFJTlQgYEZLX0F0aXZpZGFkZV8yYCBGT1JFSUdOIEtFWSAoYGZrX3NldG9yYCkgUkVGRVJFTkNFUyBgc2V0b3JgIChgaWRgKSBPTiBERUxFVEUgU0VUIE5VTEwsCiAgQ09OU1RSQUlOVCBgRktfQXRpdmlkYWRlXzNgIEZPUkVJR04gS0VZIChgZmtfdXN1YXJpb2ApIFJFRkVSRU5DRVMgYHVzdWFyaW9gIChgaWRgKSBPTiBERUxFVEUgQ0FTQ0FERSwKICBDT05TVFJBSU5UIGBGS19BdGl2aWRhZGVfNGAgRk9SRUlHTiBLRVkgKGBma19pbXBvcnRhbmNpYWApIFJFRkVSRU5DRVMgYGltcG9ydGFuY2lhYCAoYGlkYCkgT04gREVMRVRFIENBU0NBREUKKSBFTkdJTkU9SW5ub0RCIEFVVE9fSU5DUkVNRU5UPTIwMzcgREVGQVVMVCBDSEFSU0VUPWxhdGluMQ==";

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
     * setOrdem Sets the class attribute ordem with a given value
     *
     * The attribute ordem maps the field ordem defined as varchar(50).<br>
     * Comment for field ordem: Not specified.<br>
     * @param string $ordem
     * @category Modifier
     */
    public function setOrdem($ordem)
    {
        $this->ordem = (string)$ordem;
    }

    /**
     * setDescricao Sets the class attribute descricao with a given value
     *
     * The attribute descricao maps the field descricao defined as varchar(54).<br>
     * Comment for field descricao: Not specified.<br>
     * @param string $descricao
     * @category Modifier
     */
    public function setDescricao($descricao)
    {
        $this->descricao = (string)$descricao;
    }

    /**
     * setRealizada Sets the class attribute realizada with a given value
     *
     * The attribute realizada maps the field realizada defined as tinyint(1).<br>
     * Comment for field realizada: Not specified.<br>
     * @param int $realizada
     * @category Modifier
     */
    public function setRealizada($realizada)
    {
        $this->realizada = (int)$realizada;
    }

    /**
     * setFinalizada Sets the class attribute finalizada with a given value
     *
     * The attribute finalizada maps the field finalizada defined as tinyint(1).<br>
     * Comment for field finalizada: Not specified.<br>
     * @param int $finalizada
     * @category Modifier
     */
    public function setFinalizada($finalizada)
    {
        $this->finalizada = (int)$finalizada;
    }

    /**
     * setAviso Sets the class attribute aviso with a given value
     *
     * The attribute aviso maps the field aviso defined as varchar(50).<br>
     * Comment for field aviso: Not specified.<br>
     * @param string $aviso
     * @category Modifier
     */
    public function setAviso($aviso)
    {
        $this->aviso = (string)$aviso;
    }

    /**
     * setDataInicio Sets the class attribute dataInicio with a given value
     *
     * The attribute dataInicio maps the field data_inicio defined as string|date.<br>
     * Comment for field data_inicio: Not specified.<br>
     * @param string $dataInicio
     * @category Modifier
     */
    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = (string)$dataInicio;
    }

    /**
     * setDataLimite Sets the class attribute dataLimite with a given value
     *
     * The attribute dataLimite maps the field data_limite defined as string|date.<br>
     * Comment for field data_limite: Not specified.<br>
     * @param string $dataLimite
     * @category Modifier
     */
    public function setDataLimite($dataLimite)
    {
        $this->dataLimite = (string)$dataLimite;
    }

    /**
     * setFkSetor Sets the class attribute fkSetor with a given value
     *
     * The attribute fkSetor maps the field fk_setor defined as int(11).<br>
     * Comment for field fk_setor: Not specified.<br>
     * @param int $fkSetor
     * @category Modifier
     */
    public function setFkSetor($fkSetor)
    {
        $this->fkSetor = (int)$fkSetor;
    }

    /**
     * setFkUsuario Sets the class attribute fkUsuario with a given value
     *
     * The attribute fkUsuario maps the field fk_usuario defined as int(11).<br>
     * Comment for field fk_usuario: Not specified.<br>
     * @param int $fkUsuario
     * @category Modifier
     */
    public function setFkUsuario($fkUsuario)
    {
        $this->fkUsuario = (int)$fkUsuario;
    }

    /**
     * setFkImportancia Sets the class attribute fkImportancia with a given value
     *
     * The attribute fkImportancia maps the field fk_importancia defined as int(11).<br>
     * Comment for field fk_importancia: Not specified.<br>
     * @param int $fkImportancia
     * @category Modifier
     */
    public function setFkImportancia($fkImportancia)
    {
        $this->fkImportancia = (int)$fkImportancia;
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
     * getOrdem gets the class attribute ordem value
     *
     * The attribute ordem maps the field ordem defined as varchar(50).<br>
     * Comment for field ordem: Not specified.
     * @return string $ordem
     * @category Accessor of $ordem
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * getDescricao gets the class attribute descricao value
     *
     * The attribute descricao maps the field descricao defined as varchar(54).<br>
     * Comment for field descricao: Not specified.
     * @return string $descricao
     * @category Accessor of $descricao
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * getRealizada gets the class attribute realizada value
     *
     * The attribute realizada maps the field realizada defined as tinyint(1).<br>
     * Comment for field realizada: Not specified.
     * @return int $realizada
     * @category Accessor of $realizada
     */
    public function getRealizada()
    {
        return $this->realizada;
    }

    /**
     * getFinalizada gets the class attribute finalizada value
     *
     * The attribute finalizada maps the field finalizada defined as tinyint(1).<br>
     * Comment for field finalizada: Not specified.
     * @return int $finalizada
     * @category Accessor of $finalizada
     */
    public function getFinalizada()
    {
        return $this->finalizada;
    }

    /**
     * getAviso gets the class attribute aviso value
     *
     * The attribute aviso maps the field aviso defined as varchar(50).<br>
     * Comment for field aviso: Not specified.
     * @return string $aviso
     * @category Accessor of $aviso
     */
    public function getAviso()
    {
        return $this->aviso;
    }

    /**
     * getDataInicio gets the class attribute dataInicio value
     *
     * The attribute dataInicio maps the field data_inicio defined as string|date.<br>
     * Comment for field data_inicio: Not specified.
     * @return string $dataInicio
     * @category Accessor of $dataInicio
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * getDataLimite gets the class attribute dataLimite value
     *
     * The attribute dataLimite maps the field data_limite defined as string|date.<br>
     * Comment for field data_limite: Not specified.
     * @return string $dataLimite
     * @category Accessor of $dataLimite
     */
    public function getDataLimite()
    {
        return $this->dataLimite;
    }

    /**
     * getFkSetor gets the class attribute fkSetor value
     *
     * The attribute fkSetor maps the field fk_setor defined as int(11).<br>
     * Comment for field fk_setor: Not specified.
     * @return int $fkSetor
     * @category Accessor of $fkSetor
     */
    public function getFkSetor()
    {
        return $this->fkSetor;
    }

    /**
     * getFkUsuario gets the class attribute fkUsuario value
     *
     * The attribute fkUsuario maps the field fk_usuario defined as int(11).<br>
     * Comment for field fk_usuario: Not specified.
     * @return int $fkUsuario
     * @category Accessor of $fkUsuario
     */
    public function getFkUsuario()
    {
        return $this->fkUsuario;
    }

    /**
     * getFkImportancia gets the class attribute fkImportancia value
     *
     * The attribute fkImportancia maps the field fk_importancia defined as int(11).<br>
     * Comment for field fk_importancia: Not specified.
     * @return int $fkImportancia
     * @category Accessor of $fkImportancia
     */
    public function getFkImportancia()
    {
        return $this->fkImportancia;
    }

    /**
     * Gets DDL SQL code of the table atividade
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
        return "atividade";
    }

    /**
     * The BeanAtividade constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $id is given.
     *  - with a fetched data row from the table atividade having id=$id
     * @param int $id. If omitted an empty (not fetched) instance is created.
     * @return BeanAtividade Object
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
     * Fetchs a table row of atividade into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $id the primary key id value of table atividade which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($id)
    {
        $sql =  "SELECT * FROM atividade WHERE id={$this->parseValue($id,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->id = (integer)$rowObject->id;
            @$this->ordem = $this->replaceAposBackSlash($rowObject->ordem);
            @$this->descricao = $this->replaceAposBackSlash($rowObject->descricao);
            @$this->realizada = (integer)$rowObject->realizada;
            @$this->finalizada = (integer)$rowObject->finalizada;
            @$this->aviso = $this->replaceAposBackSlash($rowObject->aviso);
            @$this->dataInicio = empty($rowObject->data_inicio) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->data_inicio));
            @$this->dataLimite = empty($rowObject->data_limite) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->data_limite));
            @$this->fkSetor = (integer)$rowObject->fk_setor;
            @$this->fkUsuario = (integer)$rowObject->fk_usuario;
            @$this->fkImportancia = (integer)$rowObject->fk_importancia;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table atividade
     * @param int $id the primary key id value of table atividade which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($id)
    {
        $sql = "DELETE FROM atividade WHERE id={$this->parseValue($id,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of atividade
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
            INSERT INTO atividade
            (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia)
            VALUES(
			{$this->parseValue($this->ordem,'notNumber')},
			{$this->parseValue($this->descricao,'notNumber')},
			{$this->parseValue($this->realizada)},
			{$this->parseValue($this->finalizada)},
			{$this->parseValue($this->aviso,'notNumber')},
			{$this->parseValue($this->dataInicio,'date')},
			{$this->parseValue($this->dataLimite,'date')},
			{$this->parseValue($this->fkSetor)},
			{$this->parseValue($this->fkUsuario)},
			{$this->parseValue($this->fkImportancia)})
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
     * Updates a specific row from the table atividade with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $id the primary key id value of table atividade which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($id)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                atividade
            SET 
				ordem={$this->parseValue($this->ordem,'notNumber')},
				descricao={$this->parseValue($this->descricao,'notNumber')},
				realizada={$this->parseValue($this->realizada)},
				finalizada={$this->parseValue($this->finalizada)},
				aviso={$this->parseValue($this->aviso,'notNumber')},
				data_inicio={$this->parseValue($this->dataInicio,'date')},
				data_limite={$this->parseValue($this->dataLimite,'date')},
				fk_setor={$this->parseValue($this->fkSetor)},
				fk_usuario={$this->parseValue($this->fkUsuario)},
				fk_importancia={$this->parseValue($this->fkImportancia)}
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
     * Facility for updating a row of atividade previously loaded.
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
