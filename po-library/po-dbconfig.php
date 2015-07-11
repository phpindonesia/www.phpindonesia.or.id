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
			$dbport = DATABASE_PORT;
			self::$_connection = @pg_connect("host=".$dbhost." port=".$dbport." dbname=".$dbname." user=".$dbuser." password=".$dbpassword);
			if(!self::$_connection){
				throw new Exception('Gagal melalukan koneksi ke database. '.pg_last_error(self::$_connection));
			}
		}
		return self::$_connection;
	}

	public static function close(){
		if(self::$_connection){
			pg_close(self::$_connection);
		}
	}
} 

?>