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

// Hapus Category
if ($mod=='category' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('category');
		$tabledel->deleteBy('id_category', $id);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Multi Delete Category
elseif ($mod=='category' AND $act=='multidelete'){
	if($currentRoleAccess->delete_access == "Y"){
		$totaldata = $val->validasi($_POST['totaldata'],'xss');
		if ($totaldata != "0"){
			$itemdel = $_POST['item'];
			$tabledel = new PoTable('category');
			foreach ($itemdel as $item){
				$id = $val->validasi($item['deldata'],'xss');
				$tabledel->deleteBy('id_category', $id);
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// Input Category
elseif ($mod=='category' AND $act=='input'){
	if($currentRoleAccess->write_access == "Y"){
		$title = $val->validasi($_POST['title'],'xss');
		$seotitle = seo_title($title);
			$table = new PoTable('category');
			$table->save(array(
				'title' => $title,
				'seotitle' => $seotitle
			));
			header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Edit Category
elseif ($mod=='category' AND $act=='update'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$title = $val->validasi($_POST['title'],'xss');
		$seotitle = seo_title($title);
		$active = $val->validasi($_POST['active'],'xss');
			$data = array(
				'title' => $title,
				'seotitle' => $seotitle,
				'active' => $active
			);
			$table = new PoTable('category');
			$table->updateBy('id_category', $id, $data);
			header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
}
?>