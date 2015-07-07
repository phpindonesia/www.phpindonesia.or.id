<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

$val = new Povalidasi;
$mod = $_POST['mod'];
$act = $_POST['act'];

$tableroleaccess = new PoTable('user_role');
$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, $mod);
$currentRoleAccess = $currentRoleAccess->current();

// Delete Comment
if ($mod=='comment' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('comment');
		$tabledel->deleteBy('id_comment', $id);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Multi Delete Comment
elseif ($mod=='comment' AND $act=='multidelete'){
	if($currentRoleAccess->delete_access == "Y"){
		$totaldata = $val->validasi($_POST['totaldata'],'xss');
		if ($totaldata != "0"){
			$itemdel = $_POST['item'];
			$tabledel = new PoTable('comment');
			foreach ($itemdel as $item){
				$id = $val->validasi($item['deldata'],'xss');
				$tabledel->deleteBy('id_comment', $id);
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// Approve Comment
elseif ($mod=='comment' AND $act=='approve'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$active = $val->validasi($_POST['active'],'xss');
			$data = array(
				'active' => $active
			);
			$table = new PoTable('comment');
			$table->updateBy('id_comment', $id, $data);
			echo "$active";
	}else{
		echo "404 Not Found Access";
	}
}

// View Data Comment
elseif ($mod=='comment' AND $act=='viewdata'){
	if($currentRoleAccess->read_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tablecomment = new PoTable('comment');
		$currentComment = $tablecomment->findBy('id_comment', $id);
		$currentComment = $currentComment->current();
		echo "$currentComment->comment";
	}else{
		echo "404 Not Found Access";
	}
}

// Read Comment
elseif ($mod=='comment' AND $act=='readdata'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$status = "Y";
			$data = array(
				'status' => $status
			);
			$table = new PoTable('comment');
			$table->updateBy('id_comment', $id, $data);
	}else{
		echo "404 Not Found Access";
	}
}

// Setting Comment Without Approved
elseif ($mod=='comment' AND $act=='setting1'){
	if($currentRoleAccess->modify_access == "Y"){
		$dbhostsql = DATABASE_HOST;
		$dbusersql = DATABASE_USER;
		$dbpasswordsql = DATABASE_PASS;
		$dbnamesql = DATABASE_NAME;
		$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
		mysql_select_db($dbnamesql, $connection) or die(mysql_error());
		mysql_query("ALTER TABLE comment ALTER COLUMN active SET DEFAULT 'Y'");
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Setting Comment Must Be Approved
elseif ($mod=='comment' AND $act=='setting2'){
	if($currentRoleAccess->modify_access == "Y"){
		$dbhostsql = DATABASE_HOST;
		$dbusersql = DATABASE_USER;
		$dbpasswordsql = DATABASE_PASS;
		$dbnamesql = DATABASE_NAME;
		$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
		mysql_select_db($dbnamesql, $connection) or die(mysql_error());
		mysql_query("ALTER TABLE comment ALTER COLUMN active SET DEFAULT 'N'");
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
}
?>