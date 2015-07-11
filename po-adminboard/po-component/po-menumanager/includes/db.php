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
	 * Connect to postgresql server
	 *
	 * @param string $host
	 * @param string $user
	 * @param string $pass
	 * @param string $db_name
	 */
	function Connect($host, $user, $pass, $db_name, $port) {
		$this->link = pg_connect("host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$pass);
		if (!$this->link) {
			die('Could not connect: ' . pg_last_error($this->link));
		}
		return $this->link;
	}

	/**
	 * Execute an sql
	 *
	 * @param string $sql
	 */
	function Execute($sql) {
		$this->result = pg_query($this->link, $sql);
		if (!$this->result) {
			die('Invalid query: ' . pg_last_error($this->result));
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
			while ($row = pg_fetch_assoc($this->result)) {
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
			$data = pg_fetch_result($this->result, 0);
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
			$data = pg_fetch_assoc($this->result);
		}
		return $data;
	}

	function NumRow($sql) {
		$this->Execute($sql);
		$data = pg_num_rows($this->result);
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
			while ($row = pg_fetch_row($this->result)) {
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
			$num_fields = pg_num_fields($this->result);
			if ($num_fields == 2) {
				while ($row = pg_fetch_row($this->result)) {
					$data[$row[0]] = $row[1];
				}
			} elseif ($num_fields > 2) {
				while ($row = pg_fetch_row($this->result)) {
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
		if ($action == 'UPDATE') {
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
		} else {
			$sql .= ' ( ';
			foreach ($data as $key => $value) {
				$d[] = $key;
			}
			$sql .= implode(', ', $d);
			$sql .= " ) VALUES ( ";
			foreach ($data as $key => $value) {
				$value = "'".pg_escape_string($value)."'";
				$d2[] = $value;
			}
			$sql .= implode(', ', $d2);
			$sql .= ' )';
		}
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
	 * Get postgresql last insert ID
	 *
	 */
	function Insert_ID() {
		$insert_query = pg_query("SELECT lastval();");
		$insert_row = pg_fetch_row($insert_query);
		$insert_id = $insert_row[0];
		return $insert_id;
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
			$value = "'" . pg_escape_string($value) . "'";
		}
		return $value;
	}

	/**
	 * Close postgresql connection
	 *
	 */
	function Close() {
		@pg_close($this->link);
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