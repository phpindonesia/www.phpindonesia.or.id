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

// Hapus Tag
if ($mod=='tag' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('tag');
		$tabledel->deleteBy('id_tag', $id);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Multi Delete Tag
elseif ($mod=='tag' AND $act=='multidelete'){
	if($currentRoleAccess->delete_access == "Y"){
		$totaldata = $val->validasi($_POST['totaldata'],'xss');
		if ($totaldata != "0"){
			$itemdel = $_POST['item'];
			$tabledel = new PoTable('tag');
			foreach ($itemdel as $item){
				$id = $val->validasi($item['deldata'],'xss');
				$tabledel->deleteBy('id_tag', $id);
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// Input Tag
elseif ($mod=='tag' AND $act=='input'){
	if($currentRoleAccess->write_access == "Y"){
		if (empty($_POST['tag'])){
			header('location:../../404.php');
		}else{
			$post = $val->validasi($_POST['tag'],'xss');
			$pecah = explode(",", $post);
			$total = count($pecah);
			$table = new PoTable('tag');
			for ($i=0; $i<$total; $i++) {
				$tag_title = $pecah[$i];
				$tag_seo = seo_title($tag_title);
				$table->save(array(
					'tag_title' => $tag_title,  
					'tag_seo' => $tag_seo
				));
			}
			header('location:../../admin.php?mod='.$mod);
		}
	}else{
		header('location:../../404.php');
	}
}
}
?>