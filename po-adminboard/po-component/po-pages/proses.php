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

// Delete Pages
if ($mod=='pages' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('pages');
		$tabledel->deleteBy('id_pages', $id);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Multi Delete Pages
elseif ($mod=='pages' AND $act=='multidelete'){
	if($currentRoleAccess->delete_access == "Y"){
		$totaldata = $val->validasi($_POST['totaldata'],'xss');
		if ($totaldata != "0"){
			$itemdel = $_POST['item'];
			$tabledel = new PoTable('pages');
			foreach ($itemdel as $item){
				$id = $val->validasi($item['deldata'],'xss');
				$tabledel->deleteBy('id_pages', $id);
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// Delete Image Update
elseif ($mod=='pages' AND $act=='delimage'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$picture = '';
		$data = array(
			'picture' => $picture
		);
		$table = new PoTable('pages');
		$table->updateBy('id_pages', $id, $data);
	}else{
		echo "404 Not Found Access";
	}
}

// Input Pages
elseif ($mod=='pages' AND $act=='input'){
	if($currentRoleAccess->write_access == "Y"){
		$title = $val->validasi($_POST['title'],'xss');
		if ($_POST['seotitle'] != "") {
			$seotitle = $_POST['seotitle'];
		} else {
			$seotitle = seo_title($title);
		}
		$data = $_POST['content'];
		$data = stripslashes($data);
		$eutf = htmlspecialchars($data,ENT_QUOTES);
		if(!empty($_POST['picture'])){
			$picture = $_POST['picture'];
			$table = new PoTable('pages');
			$table->save(array(
				'title' => $title,
				'content' => $eutf,
				'seotitle' => $seotitle,
				'picture' => $picture
			));
			header('location:../../admin.php?mod='.$mod);
		}else{
			$table = new PoTable('pages');
			$table->save(array(
				'title' => $title,
				'content' => $eutf,
				'seotitle' => $seotitle
			));
			header('location:../../admin.php?mod='.$mod);
		}
	}else{
		header('location:../../404.php');
	}
}

// Edit Pages
elseif ($mod=='pages' AND $act=='update'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$title = $val->validasi($_POST['title'],'xss');
		if ($_POST['seotitle'] != "") {
			$seotitle = $_POST['seotitle'];
		} else {
			$seotitle = seo_title($title);
		}
		$data = $_POST['content'];
		$data = stripslashes($data);
		$eutf = htmlspecialchars($data,ENT_QUOTES);
		$active = $val->validasi($_POST['active'],'xss');
		if(!empty($_POST['picture'])){
			$picture = $_POST['picture'];
			$data = array(
				'title' => $title,
				'content' => $eutf,
				'seotitle' => $seotitle,
				'picture' => $picture,
				'active' => $active
			);
			$table = new PoTable('pages');
			$table->updateBy('id_pages', $id, $data);
			header('location:../../admin.php?mod='.$mod);
		}else{
			$data = array(
				'title' => $title,
				'content' => $eutf,
				'seotitle' => $seotitle,
				'active' => $active
			);
			$table = new PoTable('pages');
			$table->updateBy('id_pages', $id, $data);
			header('location:../../admin.php?mod='.$mod);
		}
	}else{
		header('location:../../404.php');
	}
}
}
?>