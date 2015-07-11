<?php

include "po-dbconfig.php";

class PoSelect implements Iterator{

	protected $_query;
	protected $_sql;
	protected $_pointer = 0;
	protected $_numResult = 0;
	protected $_results = array();

	function __construct($sql){
		$this->_sql = $sql;
	}

	function rewind(){
		$this->_pointer = 0;
	}

	function key(){
		return $this->_pointer;
	}

	protected function _getQuery(){
		if(!$this->_query){
			$connection = PoConnect::getConnection();
			$this->_query = pg_query($connection, $this->_sql);
			if(!$this->_query){
				throw new Exception('Gagal membaca data dari database:'.pg_last_error($this->_query));
			}
		}
		return $this->_query;
	}

	protected function _getNumResult(){
		if(!$this->_numResult){
			$this->_numResult = pg_num_rows($this->_getQuery());
		}
		return $this->_numResult;
	}

	function valid(){
		if($this->_pointer >= 0 && $this->_pointer < $this->_getNumResult()){
			return true;
		}
		return false;
	}

	protected function _getRow($pointer){
		if(isset($this->_results[$pointer])){
			return $this->_results[$pointer];
		}
		$row = pg_fetch_object($this->_getQuery());
		if($row){
			$this->_results[$pointer] = $row;
		}
		return $row;
	}

	function next(){
		$row = $this->_getRow($this->_pointer);
		if($row){
			$this->_pointer ++;
		}
		return $row;
	}

	function current(){
		return $this->_getRow($this->_pointer);
	}

	function close(){
		pg_free_result($this->_getQuery());
		PoConnect::close();
	}

}

class PoTable {

	protected $_tableName;

	function __construct($tableName){
		$this->_tableName = $tableName;
	}

	public function connect(){
		return PoConnect::getConnection();
	}

	public function close(){
		PoConnect::close();
	}

	function save(array $data){
		$sql = "INSERT INTO ".$this->_tableName." (";
		foreach($data as $field => $value){
			$sql .= " ".$field.",";
		}
		$sql = rtrim($sql, ',');
		$sql .= " ) VALUES (";
		foreach($data as $field => $value){
			$sql .= " '".pg_escape_string($value)."',";
		}
		$sql = rtrim($sql, ',');
		$sql .= " )";
		$result = pg_query(PoConnect::getConnection(), $sql);
		if(!$result){
			throw new Exception('Gagal menyimpan data ke table '.$this->_tableName.': '.pg_last_error($result));
		}
	}

	function update(array $data, $where = ''){
		$sql = "UPDATE ".$this->_tableName." SET";
		foreach($data as $field => $value){
			$sql .= " ".$field."='".pg_escape_string($value)."',";
		}
		$sql = rtrim($sql, ',');
		if($where){
			$sql .= " WHERE ".$where;
		}
		$result = pg_query(PoConnect::getConnection(), $sql);
		if(!$result){
			throw new Exception('Gagal mengupdate data table '.$this->_tableName.': '.pg_last_error($result));
		}
	}

	function updateBy($field, $value, array $data){
		$where = "".$field."='".pg_escape_string($value)."'";
		$this->update($data, $where);
	}

	function updateByAnd($field, $value, $field2, $value2, array $data){
		$where = "".$field."='".pg_escape_string($value)."'";
		$where .= " AND ".$field2."='".pg_escape_string($value2)."'";
		$this->update($data, $where);
	}

	function delete($where = ''){
		$sql = "DELETE FROM ".$this->_tableName."";
		if($where){
			$sql .= " WHERE ".$where;
		}
		$result = pg_query(PoConnect::getConnection(), $sql);
		if(!$result){
			throw new Exception('Gagal menghapus data dari table '.$this->_tableName.': '.pg_last_error($result));
		}
	}

	function deleteBy($field, $value){
		$where = "".$field."='".$value."'";
		$this->delete($where);
	}

	function findManualQuery($tabel = '', $field = '', $condition = ''){
		if($field){
			$sql = "SELECT ".$field." FROM ".$tabel."";
		}else{
			$sql = "SELECT * FROM ".$tabel."";
		}
		if($condition){
			$sql .= " ".$condition;
		}
		return new PoSelect($sql);
	}

	function findAll($field, $value){
		if (empty($field) || empty($value)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			return new PoSelect($sql);		
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " ORDER BY ".$field." ".$value."";
			return new PoSelect($sql);
		}
	}

	function findAllLimit($field, $value, $value2){
		if (empty($field) || empty($value)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$value2 = explode(',',$value2);
			if ($value2[1] == '' || $value2[1] == 0 || empty($value2[1])) {
				$sql .= " LIMIT ".$value2[0]."";
			} else {
				$sql .= " LIMIT ".$value2[1]."";
				$sql .= " OFFSET ".$value2[0]."";
			}
			return new PoSelect($sql);		
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " ORDER BY ".$field." ".$value."";
			$value2 = explode(',',$value2);
			if ($value2[1] == '' || $value2[1] == 0 || empty($value2[1])) {
				$sql .= " LIMIT ".$value2[0]."";
			} else {
				$sql .= " LIMIT ".$value2[1]."";
				$sql .= " OFFSET ".$value2[0]."";
			}
			return new PoSelect($sql);
		}
	}

	function findAllLimitBy($field, $field2, $value, $value2, $value3){
		if (empty($field) || empty($value2)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field2."='".$value."'";
			$value3 = explode(',',$value3);
			if ($value3[1] == '' || $value3[1] == 0 || empty($value3[1])) {
				$sql .= " LIMIT ".$value3[0]."";
			} else {
				$sql .= " LIMIT ".$value3[1]."";
				$sql .= " OFFSET ".$value3[0]."";
			}
			return new PoSelect($sql);		
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field2."='".$value."'";
			$sql .= " ORDER BY ".$field." ".$value2."";
			$value3 = explode(',',$value3);
			if ($value3[1] == '' || $value3[1] == 0 || empty($value3[1])) {
				$sql .= " LIMIT ".$value3[0]."";
			} else {
				$sql .= " LIMIT ".$value3[1]."";
				$sql .= " OFFSET ".$value3[0]."";
			}
			return new PoSelect($sql);
		}
	}

	function findAllLimitByAnd($field, $field2, $field3, $value, $value2, $value3, $value4){
		if (empty($field) || empty($value2)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field2."='".$value."'";
			$value4 = explode(',',$value4);
			if ($value4[1] == '' || $value4[1] == 0 || empty($value4[1])) {
				$sql .= " LIMIT ".$value4[0]."";
			} else {
				$sql .= " LIMIT ".$value4[1]."";
				$sql .= " OFFSET ".$value4[0]."";
			}
			return new PoSelect($sql);		
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field2."='".$value."'";
			$sql .= " AND ".$field3."='".$value2."'";
			$sql .= " ORDER BY ".$field." ".$value3."";
			$value4 = explode(',',$value4);
			if ($value4[1] == '' || $value4[1] == 0 || empty($value4[1])) {
				$sql .= " LIMIT ".$value4[0]."";
			} else {
				$sql .= " LIMIT ".$value4[1]."";
				$sql .= " OFFSET ".$value4[0]."";
			}
			return new PoSelect($sql);
		}
	}

	function findAllLimitByRand($field, $value, $value2){
		if (empty($field) || empty($value)){
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field."='".$value."'";
			$value2 = explode(',',$value2);
			if ($value2[1] == '' || $value2[1] == 0 || empty($value2[1])) {
				$sql .= " LIMIT ".$value2[0]."";
			} else {
				$sql .= " LIMIT ".$value2[1]."";
				$sql .= " OFFSET ".$value2[0]."";
			}
			return new PoSelect($sql);		
		}else{
			$sql = "SELECT * FROM ".$this->_tableName."";
			$sql .= " WHERE ".$field."='".$value."'";
			$sql .= " ORDER BY RAND()";
			$value2 = explode(',',$value2);
			if ($value2[1] == '' || $value2[1] == 0 || empty($value2[1])) {
				$sql .= " LIMIT ".$value2[0]."";
			} else {
				$sql .= " LIMIT ".$value2[1]."";
				$sql .= " OFFSET ".$value2[0]."";
			}
			return new PoSelect($sql);
		}
	}

	function findNotAll($field, $value){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."!='".$value."'";
		return new PoSelect($sql);
	}

	function findAllRand(){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " ORDER BY RAND()";
		return new PoSelect($sql);
	}

	function findBy($field, $value){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		return new PoSelect($sql);
	}

	function findByDESC($field, $value, $field2){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		$sql .= " ORDER BY ".$field2." DESC ";
		return new PoSelect($sql);
	}

	function findByASC($field, $value, $field2){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		$sql .= " ORDER BY ".$field2." ASC ";
		return new PoSelect($sql);
	}

	function findByAnd($field, $value, $field2, $value2){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		$sql .= " AND ".$field2."='".$value2."'";
		return new PoSelect($sql);
	}

	function findByAndDESC($field, $value, $field2, $value2, $value3){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		$sql .= " AND ".$field2."='".$value2."'";
		$sql .= " ORDER BY ".$value3." DESC ";
		return new PoSelect($sql);
	}

	function findByAndASC($field, $value, $field2, $value2, $value3){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		$sql .= " AND ".$field2."='".$value2."'";
		$sql .= " ORDER BY ".$value3." ASC ";
		return new PoSelect($sql);
	}

	function findByLogin($field1, $value1, $field2, $value2, $field3, $value3){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field1."='".$value1."'";
		$sql .= " AND ".$field2."='".$value2."'";
		$sql .= " AND ".$field3."='".$value3."'";
		return new PoSelect($sql);
	}

	function findStat($field1, $value1, $field2){
		$sql = "SELECT ip FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field1."='".$value1."'";
		$sql .= " GROUP BY ".$field2."";
		$result = pg_query(PoConnect::getConnection(), $sql);
		$result = pg_num_rows($result);
		return $result;
	}

	function findStatd($field1, $field2, $field3, $value1, $field4){
		$sql = "SELECT SUM(".$field1.") as ".$field2." FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field3."='".$value1."'";
		$sql .= " GROUP BY ".$field4."";
		$result = pg_fetch_assoc(pg_query(PoConnect::getConnection(), $sql));
		$result = $result[$field2];
		return $result;
	}

	function findByPost($field, $value){
		$sql = "SELECT title, seotitle FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		return new PoSelect($sql);
	}

	function findSearchPost($value, $value2){
		$pisah_kata = explode(" ",$value);
		$jml_katakan = (integer)count($pisah_kata);
		$jml_kata = $jml_katakan-1;
		$sql = "SELECT * FROM ".$this->_tableName." WHERE ";
		for ($i=0; $i<=$jml_kata; $i++){
			$sql .= "title OR content ILIKE '%$pisah_kata[$i]%'";
			if ($i < $jml_kata ){
				$sql .= " OR ";
			}
		}
		$sql .= " AND active='Y' ORDER BY id_post DESC";
		$value2 = explode(',',$value2);
		if ($value2[1] == '' || $value2[1] == 0 || empty($value2[1])) {
			$sql .= " LIMIT ".$value2[0]."";
		} else {
			$sql .= " LIMIT ".$value2[1]."";
			$sql .= " OFFSET ".$value2[0]."";
		}
		return new PoSelect($sql);
	}

	function findRelatedPost($value, $value2, $value3, $value4, $value5){
		$pisah_kata  = explode(",",$value);
		$jml_katakan = (integer)count($pisah_kata);
		$jml_kata = $jml_katakan-1; 
		$sql = "SELECT * FROM ".$this->_tableName." WHERE (id_post < ".$value2.") AND (id_post != ".$value2.") AND (" ;
			for ($i=0; $i<=$jml_kata; $i++){
				$sql .= "tag ILIKE '%$pisah_kata[$i]%'";
				if ($i < $jml_kata ){
					$sql .= " OR ";
				}
			}
		$sql .= ") AND active='Y'";
		$sql .= " ORDER BY ".$value3." ".$value4."";
		$value5 = explode(',',$value5);
		if ($value5[1] == '' || $value5[1] == 0 || empty($value5[1])) {
			$sql .= " LIMIT ".$value5[0]."";
		} else {
			$sql .= " LIMIT ".$value5[1]."";
			$sql .= " OFFSET ".$value5[0]."";
		}
		return new PoSelect($sql);
	}

	function numRow(){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$result = pg_query(PoConnect::getConnection(), $sql);
		$result = pg_num_rows($result);
		return $result;
	}

	function numRowBy($field, $value){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		$result = pg_query(PoConnect::getConnection(), $sql);
		$result = pg_num_rows($result);
		return $result;
	}
	
	function numRowByAnd($field, $value, $field2, $value2){
		$sql = "SELECT * FROM ".$this->_tableName."";
		$sql .= " WHERE ".$field."='".$value."'";
		$sql .= " AND ".$field2."='".$value2."'";
		$result = pg_query(PoConnect::getConnection(), $sql);
		$result = pg_num_rows($result);
		return $result;
	}

	function numRowSearchPost($value){
		$pisah_kata = explode(" ",$value);
		$jml_katakan = (integer)count($pisah_kata);
		$jml_kata = $jml_katakan-1;
		$sql = "SELECT * FROM ".$this->_tableName." WHERE ";
		for ($i=0; $i<=$jml_kata; $i++){
			$sql .= "title OR content ILIKE '%$pisah_kata[$i]%'";
			if ($i < $jml_kata ){
				$sql .= " OR ";
			}
		}
		$sql .= " AND active='Y' ORDER BY id_post DESC";
		$result = pg_query(PoConnect::getConnection(), $sql);
		$result = pg_num_rows($result);
		return $result;
	}
}

?>