<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

$mod = $_POST['mod'];
$act = $_POST['act'];

$mod2 = $_GET['mod'];
$act2 = $_GET['act'];

// Backup DB
if ($mod2=='home' AND $act2=='backup'){
	if ($_SESSION[leveluser]=='1'){
		$dbhostsql = DATABASE_HOST;
		$dbusersql = DATABASE_USER;
		$dbpasswordsql = DATABASE_PASS;
		$dbnamesql = DATABASE_NAME;
		$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
		mysql_select_db($dbnamesql, $connection) or die(mysql_error());

		$tables = '*';

			//get all of the tables
			if($tables == '*'){
				$tables = array();
				$result = mysql_query('SHOW TABLES');
				while($row = mysql_fetch_row($result))
				{
					$tables[] = $row[0];
				}
			}else{
				$tables = is_array($tables) ? $tables : explode(',',$tables);
			}
			
			//cycle through
			foreach($tables as $table){
				$result = mysql_query('SELECT * FROM '.$table);
				$num_fields = mysql_num_fields($result);
				
				$return.= 'DROP TABLE IF EXISTS '.'`'.$table.'`'.';';
				$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE `'.$table.'`'));
				$return.= "\n\n".$row2[1].";\n\n";
				
				for ($i = 0; $i < $num_fields; $i++) {
					while($row = mysql_fetch_row($result)){
						$return.= 'INSERT INTO `'.$table.'` VALUES(';
						for($j=0; $j<$num_fields; $j++) {
							$row[$j] = addslashes($row[$j]);
							$row[$j] = preg_replace("/\r\n/","\\r\\n",$row[$j]);
							if (isset($row[$j])) { $return.= '\''.$row[$j].'\'' ; } else { $return.= '\'\''; }
							if ($j<($num_fields-1)) { $return.= ','; }
						}
						$return.= ");\n";
					}
				}
				$return.="\n\n\n";
			}
			
			//save file
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=database-backup-".date("Y-m-d").".sql");
			header("Pragma: no-cache");
			header("Expires: 0");
			print "$return";
	}else{
		header('location:../../404.php');
	}
}

// Restore DB
elseif ($mod=='home' AND $act=='restore'){
	if ($_SESSION[leveluser]=='1'){
		$extensionList = array("sql");
		$fileName = $_FILES['fupload']['name'];
		$tmpName = $_FILES['fupload']['tmp_name'];
		$fileType = $_FILES['fupload']['type'];
		$fileSize = $_FILES['fupload']['size'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[1];
		$title = $pecah[0];
		$seotitle = seo_title($title);
		$acak = rand(000000,999999);
		$nama_file = "-popoji.";
		$nama_file_unik = $seotitle.'-'.$acak.$nama_file.$ekstensi;
		$namaDir = '../../../po-content/po-upload/';
		$pathFile = $namaDir.$nama_file_unik;
		if (!empty($tmpName)){
			if (in_array($ekstensi, $extensionList)){
				move_uploaded_file($tmpName, $pathFile);
				$path = "../../../po-content/po-upload/";
				$sql_filename = "$nama_file_unik";
				$sql_contents = file_get_contents($path.$sql_filename);
				$sql_contents = explode(";", $sql_contents);

				$dbhostsql = DATABASE_HOST;
				$dbusersql = DATABASE_USER;
				$dbpasswordsql = DATABASE_PASS;
				$dbnamesql = DATABASE_NAME;
				$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
				mysql_select_db($dbnamesql, $connection) or die(mysql_error());

				foreach($sql_contents as $query){
					$result = mysql_query($query);
					if (!$result){
						unlink("../../../po-content/po-upload/$nama_file_unik");
						header('location:../../admin.php?mod='.$mod);
					}else{
						header('location:../../404.php');
					}
				}
			}else{
				header('location:../../404.php');
			}
		}else{
			header('location:../../404.php');
		}
	}
}
}
?>