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

// Delete Gallery
if ($mod=='gallery' AND $act=='deletegallery'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('gallery');
		$tabledel->deleteBy('id_gallery', $id);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Multi Delete Gallery
elseif ($mod=='gallery' AND $act=='multidelete'){
	if($currentRoleAccess->delete_access == "Y"){
		$totaldata = $val->validasi($_POST['totaldata'],'xss');
		if ($totaldata != "0"){
			$itemdel = $_POST['item'];
			$tabledel = new PoTable('gallery');
			foreach ($itemdel as $item){
				$id = $val->validasi($item['deldata'],'xss');
				$tabledel->deleteBy('id_gallery', $id);
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// Delete Album
if ($mod=='gallery' AND $act=='deletealbum'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('album');
		$tabledel->deleteBy('id_album', $id);
		header('location:../../admin.php?mod='.$mod.'&act=album');
	}else{
		header('location:../../404.php');
	}
}

// Input Gallery
elseif ($mod=='gallery' AND $act=='inputgallery'){
	if($currentRoleAccess->write_access == "Y"){
		$id_album = $val->validasi($_POST['id_album'],'xss');
		$title = $val->validasi($_POST['title'],'xss');
		if(!empty($_POST['picture'])){
			$picture = $_POST['picture'];
			$table = new PoTable('gallery');
			$table->save(array(
				'id_album' => $id_album,
				'title' => $title,
				'picture' => $picture
			));
			header('location:../../admin.php?mod='.$mod);
		}else{
			$table = new PoTable('gallery');
			$table->save(array(
				'id_album' => $id_album,
				'title' => $title
			));
			header('location:../../admin.php?mod='.$mod);
		}
	}else{
		header('location:../../404.php');
	}
}

// Input Album
elseif ($mod=='gallery' AND $act=='inputalbum'){
	if($currentRoleAccess->write_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$title = $val->validasi($_POST['title'],'xss');
		$addalb = $val->validasi($_POST['addalb'],'xss');
		$seotitle = seo_title($title);
			$table = new PoTable('album');
			$table->save(array(
				'title' => $title,
				'seotitle' => $seotitle
			));
			if ($id == ''){
				header('location:../../admin.php?mod='.$mod.'&act='.$addalb);
			}else{
				header('location:../../admin.php?mod='.$mod.'&act=edit&id='.$id);
			}
	}else{
		header('location:../../404.php');
	}
}

// Update Gallery
elseif ($mod=='gallery' AND $act=='editgallery'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$id_album = $val->validasi($_POST['id_album'],'sql');
		$title = $val->validasi($_POST['title'],'xss');
		if(!empty($_POST['picture'])){
			$picture = $_POST['picture'];
			$data = array(
				'id_album' => $id_album,
				'title' => $title,
				'picture' => $picture
			);
			$table = new PoTable('gallery');
			$table->updateBy('id_gallery', $id, $data);
			header('location:../../admin.php?mod='.$mod);
		}else{
			$data = array(
				'id_album' => $id_album,
				'title' => $title
			);
			$table = new PoTable('gallery');
			$table->updateBy('id_gallery', $id, $data);
			header('location:../../admin.php?mod='.$mod);
		}
	}else{
		header('location:../../404.php');
	}
}

// Update Album
elseif ($mod=='gallery' AND $act=='editalbum'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$title = $val->validasi($_POST['title'],'xss');
		$seotitle = seo_title($title);
			$data = array(
				'title' => $title,
				'seotitle' => $seotitle
			);
			$table = new PoTable('album');
			$table->updateBy('id_album', $id, $data);
			header('location:../../admin.php?mod='.$mod.'&act=album');
	}else{
		header('location:../../404.php');
	}
}

// Active Album
elseif ($mod=='gallery' AND $act=='activealbum'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$active =  $val->validasi($_POST['active'],'xss');
			$data = array(
				'active' => $active
			);
			$table = new PoTable('album');
			$table->updateBy('id_album', $id, $data);
			echo "$active";
	}else{
		echo "404 Not Found Access";
	}
}
}
?>