<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';
include_once '../../../po-library/po-pclzip.lib.php';

$val = new Povalidasi;
$mod = $_POST['mod'];
$act = $_POST['act'];

$tableroleaccess = new PoTable('user_role');
$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, $mod);
$currentRoleAccess = $currentRoleAccess->current();

// Hapus Component
if ($mod=='component' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('component');
		$currentSearch = $tabledel->findBy(id_component, $id);
		$currentSearch = $currentSearch->current();
		$component = $currentSearch->component;
		$table_name = $currentSearch->table_name;
			$dbhostsql = DATABASE_HOST;
			$dbusersql = DATABASE_USER;
			$dbpasswordsql = DATABASE_PASS;
			$dbnamesql = DATABASE_NAME;
			$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
			mysql_select_db($dbnamesql, $connection) or die(mysql_error());
			$dirPath = "../../po-component/$component";
			$deletef = deleteDir($dirPath);
			$queryf = "DROP TABLE IF EXISTS `$dbnamesql`.`$table_name`";
			$resultf = mysql_query($queryf);
			$tabledel->deleteBy('id_component', $id);
			header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Input Component
elseif ($mod=='component' AND $act=='input'){
	if($currentRoleAccess->write_access == "Y"){
		$extensionList = array("zip");
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
		$component = $val->validasi($_POST['component'],'xss');
		$table_name = $val->validasi($_POST['table_name'],'xss');
		if (!empty($tmpName)){
			if (in_array($ekstensi, $extensionList)){
				move_uploaded_file($tmpName, $pathFile);
				$destination_dir = "../../po-component/$component";
				if (file_exists($destination_dir)){ 
					unlink("../../../po-content/po-upload/$nama_file_unik");
					header('location:../../404.php');
				}else{
					$file = "../../../po-content/po-upload/$nama_file_unik";
					$archive = new PclZip($file);
					if ($archive->extract(PCLZIP_OPT_PATH, $destination_dir) == 0){
						unlink("../../../po-content/po-upload/$nama_file_unik");
						header('location:../../404.php');
					}
					$table = new PoTable('component');
					$table->save(array(
						'component' => $component,
						'table_name' => $table_name,
						'date' => $tgl_sekarang
					));
					unlink("../../../po-content/po-upload/$nama_file_unik");
					header('location:../../admin.php?mod='.$mod);
				}
			}else{
				header('location:../../404.php');
			}
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// Import Table Component
elseif ($mod=='component' AND $act=='importtable'){
	if($currentRoleAccess->modify_access == "Y"){
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
	}else{
		header('location:../../404.php');
	}
}
}
?>