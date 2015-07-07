<?php

include_once "po-config.php";

class PoConnect {

	protected static $_connection;

	public static function getConnection(){
		if(!self::$_connection){
			$dbhost = DATABASE_HOST;
			$dbuser = DATABASE_USER;
			$dbpassword = DATABASE_PASS;
			$dbname = DATABASE_NAME;
			self::$_connection = @mysql_connect($dbhost, $dbuser, $dbpassword);
			if(!self::$_connection){
				throw new Exception('Gagal melalukan koneksi ke database. '.mysql_error());
			}
			$result = @mysql_select_db($dbname, self::$_connection);
			if(!$result){
				throw new Exception('Koneksi gagal: '.mysql_error());
			}
		}
		return self::$_connection;
	}

	public static function close(){
		if(self::$_connection){
			mysql_close(self::$_connection);
		}
	}
} 

?>