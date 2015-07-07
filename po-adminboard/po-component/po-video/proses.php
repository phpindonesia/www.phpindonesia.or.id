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

// Delete Video
if ($mod=='video' AND $act=='deletevideo'){
	$id = $val->validasi($_POST['id'],'sql');
	$tabledel = new PoTable('video');
	$tabledel->deleteBy('id_video', $id);
	header('location:../../admin.php?mod='.$mod);
}

// Multi Delete Video
elseif ($mod=='video' AND $act=='multidelete'){
	$totaldata = $val->validasi($_POST['totaldata'],'xss');
	if ($totaldata != "0"){
		$itemdel = $_POST['item'];
		$tabledel = new PoTable('video');
		foreach ($itemdel as $item){
			$id = $val->validasi($item['deldata'],'xss');
			$tabledel->deleteBy('id_video', $id);
		}
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Delete Album
if ($mod=='video' AND $act=='deletealbum'){
	$id = $val->validasi($_POST['id'],'sql');
	$tabledel = new PoTable('valbum');
	$tabledel->deleteBy('id_album', $id);
	header('location:../../admin.php?mod='.$mod.'&act=album');
}

// Input Video
elseif ($mod=='video' AND $act=='inputvideo'){
	$id_album = $val->validasi($_POST['id_album'],'xss');
	$title = $val->validasi($_POST['title'],'xss');
	if(!empty($_POST['picture'])){
		$picture = $_POST['picture'];
		$table = new PoTable('video');
		$table->save(array(
			'id_album' => $id_album,
			'title' => $title,
			'url' => $_POST['url'],
			'picture' => $picture
		));
		header('location:../../admin.php?mod='.$mod);
	}else{
		$table = new PoTable('video');
		$table->save(array(
			'id_album' => $id_album,
			'title' => $title,
			'url' => $_POST['url']
		));
		header('location:../../admin.php?mod='.$mod);
	}
}

// Input Album
elseif ($mod=='video' AND $act=='inputalbum'){
	$id = $val->validasi($_POST['id'],'sql');
	$title = $val->validasi($_POST['title'],'xss');
	$addalb = $val->validasi($_POST['addalb'],'xss');
	$seotitle = seo_title($title);
		$table = new PoTable('valbum');
		$table->save(array(
			'title' => $title,
			'seotitle' => $seotitle
		));
		if ($id == ''){
			header('location:../../admin.php?mod='.$mod.'&act='.$addalb);
		}else{
			header('location:../../admin.php?mod='.$mod.'&act=edit&id='.$id);
		}
}

// Update Video
elseif ($mod=='video' AND $act=='editvideo'){
	$id = $val->validasi($_POST['id'],'sql');
	$id_album = $val->validasi($_POST['id_album'],'sql');
	$title = $val->validasi($_POST['title'],'xss');
	if(!empty($_POST['picture'])){
		$picture = $_POST['picture'];
		$data = array(
			'id_album' => $id_album,
			'title' => $title,
			'url' => $_POST['url'],
			'picture' => $picture
		);
		$table = new PoTable('video');
		$table->updateBy('id_video', $id, $data);
		header('location:../../admin.php?mod='.$mod);
	}else{
		$data = array(
			'id_album' => $id_album,
			'title' => $title,
			'url' => $_POST['url']
		);
		$table = new PoTable('video');
		$table->updateBy('id_video', $id, $data);
		header('location:../../admin.php?mod='.$mod);
	}
}

// Update Album
elseif ($mod=='video' AND $act=='editalbum'){
	$id = $val->validasi($_POST['id'],'sql');
	$title = $val->validasi($_POST['title'],'xss');
	$seotitle = seo_title($title);
		$data = array(
			'title' => $title,
			'seotitle' => $seotitle
		);
		$table = new PoTable('valbum');
		$table->updateBy('id_album', $id, $data);
		header('location:../../admin.php?mod='.$mod.'&act=album');
}

// Active Album
elseif ($mod=='video' AND $act=='activealbum'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$active =  $val->validasi($_POST['active'],'xss');
			$data = array(
				'active' => $active
			);
			$table = new PoTable('valbum');
			$table->updateBy('id_album', $id, $data);
			echo "$active";
	}else{
		echo "404 Not Found Access";
	}
}
}
?>