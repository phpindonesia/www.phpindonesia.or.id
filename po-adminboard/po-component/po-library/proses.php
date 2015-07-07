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

// Hapus Media
if ($mod=='library' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('media');
		$currentSearch = $tabledel->findBy(id_media, $id);
		$currentSearch = $currentSearch->current();
		$picture = $currentSearch->file_name;
		$pecah = explode(".", $picture);
		$ekstensi = $pecah[1];
		if ($ekstensi=='jpg'){
			unlink("../../../po-content/po-upload/$picture");
			unlink("../../../po-content/po-upload/medium-$picture");
			$tabledel->deleteBy('id_media', $id);
		}else{
			unlink("../../../po-content/po-upload/$picture");
			$tabledel->deleteBy('id_media', $id);
		}
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Multi Delete Media
elseif ($mod=='library' AND $act=='multidelete'){
	if($currentRoleAccess->delete_access == "Y"){
		$totaldata = $val->validasi($_POST['totaldata'],'xss');
		if ($totaldata != "0"){
			$itemdel = $_POST['item'];
			$tabledel = new PoTable('media');
			foreach ($itemdel as $item){
				$id = $val->validasi($item['deldata'],'xss');
				$tabledel = new PoTable('media');
				$currentSearch = $tabledel->findBy(id_media, $id);
				$currentSearch = $currentSearch->current();
				$picture = $currentSearch->file_name;
				$pecah = explode(".", $picture);
				$ekstensi = $pecah[1];
				if ($ekstensi=='jpg'){
					unlink("../../../po-content/po-upload/$picture");
					unlink("../../../po-content/po-upload/medium-$picture");
					$tabledel->deleteBy('id_media', $id);
				}else{
					unlink("../../../po-content/po-upload/$picture");
					$tabledel->deleteBy('id_media', $id);
				}
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// Input Media
elseif ($mod=='library' AND $act=='input'){
	if($currentRoleAccess->write_access == "Y"){
		$extensionList = array("jpg", "png", "xls", "xlsx", "ppt", "pptx", "txt", "doc", "docx", "pdf", "psd");
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
				if ($ekstensi=='jpg'){
					UploadImage($nama_file_unik);
					$table = new PoTable('media');
					$table->save(array(
						'file_name' => $nama_file_unik,
						'file_type' => $fileType,
						'file_size' => $fileSize,  
						'date' => $tgl_sekarang
					));
					header('location:../../admin.php?mod='.$mod);
				}else{
					move_uploaded_file($tmpName, $pathFile);
					$table = new PoTable('media');
					$table->save(array(
						'file_name' => $nama_file_unik,
						'file_type' => $fileType,
						'file_size' => $fileSize,  
						'date' => $tgl_sekarang
					));
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
}
?>