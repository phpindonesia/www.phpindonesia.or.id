<?php
/**
 * Class for database operations
 *
 * example:
 * $db = new DB;
 * $db->Connect('localhost', 'root', 'pass', 'dbname');
 *
 * $db->Execute("DELETE FROM account WHERE id = 1");
 *
 * $data = $db->GetAll("SELECT * FROM account");
 * print_r($data);
 *
 * @author gawibowo
 */
class DB {
	var $link;
	var $result;

	/**
	 * Connect to mysql server
	 *
	 * @param string $host
	 * @param string $user
	 * @param string $pass
	 * @param string $db_name
	 */
	function Connect($host, $user, $pass, $db_name) {
		$this->link = mysql_connect($host, $user, $pass);
		if (!$this->link) {
			die('Could not connect: ' . mysql_error());
		}
		$db_selected = mysql_select_db($db_name, $this->link);
		if (!$db_selected) {
			die ("Can't use $db_name : " . mysql_error());
		}
		return $this->link;
	}

	/**
	 * Execute an sql
	 *
	 * @param string $sql
	 */
	function Execute($sql) {
		$this->result = mysql_query($sql, $this->link);
		if (!$this->result) {
			die('Invalid query: ' . mysql_error());
		}
		return $this->result;
	}

	/**
	 * Get multi rows result from a SELECT query
	 *
	 * @param string $sql
	 * @return array
	 */
	function GetAll($sql) {
		$this->Execute($sql);
		$data = array();
		if ($this->result) {
			while ($row = mysql_fetch_assoc($this->result)) {
				$data[] = $row;
			}
		}
		return $data;
	}

	/**
	 * Get one result from a SELECT query
	 *
	 * @param string $sql
	 * @return string
	 */
	function GetOne($sql) {
		$this->Execute($sql);
		$data = '';
		if ($this->result) {
			$data = mysql_result($this->result, 0);
		}
		return $data;
	}

	/**
	 * Get one row result from a SELECT query
	 *
	 * @param string $sql
	 * @return array
	 */
	function GetRow($sql) {
		$this->Execute($sql);
		$data = array();
		if ($this->result) {
			$data = mysql_fetch_assoc($this->result);
		}
		return $data;
	}

	function NumRow($sql) {
		$this->Execute($sql);
		$data = mysql_num_rows($this->result);
		return $data;
	}

	/**
	 * Get one column from a SELECT query
	 *
	 * @param string $sql
	 * @return array
	 */
	function GetCol($sql) {
		$this->Execute($sql);
		$data = array();
		if ($this->result) {
			while ($row = mysql_fetch_row($this->result)) {
				$data[] = $row[0];
			}
		}
		return $data;
	}

	/**
	 * Get associative array from a SELECT query
	 *
	 * @param string $sql
	 * @return array
	 */
	function GetAssoc($sql) {
		$this->Execute($sql);
		$data = array();
		if ($this->result) {
			$num_fields = mysql_num_fields($this->result);
			if ($num_fields == 2) {
				while ($row = mysql_fetch_row($this->result)) {
					$data[$row[0]] = $row[1];
				}
			} elseif ($num_fields > 2) {
				while ($row = mysql_fetch_row($this->result)) {
					$k = $row[0];
					$v = array_slice($row, 1);
					$data[$k] = $v;
				}
			}
		}
		return $data;
	}

	/**
	 * INSERT or UPDATE from an array data
	 *
	 * @param string $table_name
	 * @param array $data
	 * @param string $action
	 * @param string $where
	 */
	function AutoExecute($table_name, $data, $action='INSERT', $where='') {
		switch ($action) {
			case 'INSERT': $sql = 'INSERT INTO '; break;
			case 'UPDATE': $sql = 'UPDATE '; break;
		}
		$sql .= $table_name;
		$sql .= ' SET ';
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$value = $value[0];
			} else {
				$value = $this->quote_smart($value);
			}
			$d[] = "$key = $value";
		}
		$sql .= implode(', ', $d);
		if ($action == 'UPDATE') {
			$sql .= " WHERE $where";
		}

		$this->Execute($sql);
		return $this->result;
	}

	/**
	 * A shortcut for AutoExecute for INSERT
	 *
	 * @param string $table_name
	 * @param data $data
	 */
	function insert($table_name, $data) {
		return $this->AutoExecute($table_name, $data, 'INSERT');
	}

	/**
	 * A shortcut for AutoExecute for UPDATE
	 *
	 * @param string $table_name
	 * @param data $data
	 */
	function update($table_name, $data, $where) {
		return $this->AutoExecute($table_name, $data, 'UPDATE', $where);
	}

	/**
	 * Get MySQL last insert ID
	 *
	 */
	function Insert_ID() {
		return mysql_insert_id();
	}

	/**
	 * add backslash to a value, prevent sql injection
	 *
	 * @param unknown_type $value
	 * @return unknown
	 */
	function quote_smart($value) {
		// Stripslashes
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		// Quote if not a number or a numeric string
		if (!is_numeric($value)) {
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
		return $value;
	}

	/**
	 * Close mysql connection
	 *
	 */
	function Close() {
		@mysql_close($this->link);
	}
}

/**
 * print_r() with <pre> for easier read
 */
if (!function_exists('adodb_pr')) {
	function adodb_pr($array, $return = false) {
		if ($return) {
			return '<pre>' . print_r($array, true) . '</pre>';
		} else {
			echo '<pre>';
			print_r($array, $return);
			echo '</pre>';
		}
	}
}

/* End of DB.php */
?>