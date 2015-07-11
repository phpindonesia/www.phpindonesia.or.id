<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';
include_once '../../../po-library/pgBackupRestore.class.php';

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
		$dbportsql = DATABASE_PORT;
		function timer(){
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			return($time);
		}
		$filename = "database-backup-".date("Y-m-d").".sql";
		$s = timer();
		$pgBackup = new pgBackupRestore($dbhostsql, $dbusersql, $dbpasswordsql, $dbnamesql);
		$pgBackup->UseDropTable = false;
		$pgBackup->Backup($filename);
		$e = timer();
		header('location:'.$filename);
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
				$dbportsql = DATABASE_PORT;
				$connection = pg_connect("host=".$dbhostsql." port=".$dbportsql." dbname=".$dbnamesql." user=".$dbusersql." password=".$dbpasswordsql);
				foreach($sql_contents as $query){
					pg_query($connection, $query);
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