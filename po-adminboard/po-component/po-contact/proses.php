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

// Delete Contact
if ($mod=='contact' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('contact');
		$tabledel->deleteBy('id_contact', $id);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Multi Delete Contact
elseif ($mod=='contact' AND $act=='multidelete'){
	if($currentRoleAccess->delete_access == "Y"){
		$totaldata = $val->validasi($_POST['totaldata'],'xss');
		if ($totaldata != "0"){
			$itemdel = $_POST['item'];
			$tabledel = new PoTable('contact');
			foreach ($itemdel as $item){
				$id = $val->validasi($item['deldata'],'xss');
				$tabledel->deleteBy('id_contact', $id);
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// View Data Contact
elseif ($mod=='contact' AND $act=='viewdata'){
	if($currentRoleAccess->read_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tablecontact = new PoTable('contact');
		$currentContact = $tablecontact->findBy('id_contact', $id);
		$currentContact = $currentContact->current();
		echo "$currentContact->message_contact";
	}else{
		echo "404 Not Found Access";
	}
}

// Read Contact
elseif ($mod=='contact' AND $act=='readdata'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$status = "Y";
			$data = array(
				'status' => $status
			);
			$table = new PoTable('contact');
			$table->updateBy('id_contact', $id, $data);
	}else{
		echo "404 Not Found Access";
	}
}

// Reply Contact
elseif ($mod=='contact' AND $act=='reply'){
	if($currentRoleAccess->write_access == "Y"){
		$name_contact = $val->validasi($_POST['name_contact'],'xss');
		$email_contact = $val->validasi($_POST['email_contact'],'xss');
		$subject_contact = $val->validasi($_POST['subjek_contact'],'xss');
		$message_contact = $val->validasi($_POST['message_contact'],'xss');
			$tableset = new PoTable('setting');
			$currentSet = $tableset->findBy(id_setting, '1');
			$currentSet = $currentSet->current();
			$website_name = $currentSet->website_name;
			$website_url = $currentSet->website_url;
			$website_email = $currentSet->website_email;
				$to = "$email_contact";
				$from = "$website_name <$website_email>";
				$subject = "$subject_contact";
				$message = "<html><body>$message_contact</body></html>"; 
				$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				$headers .= "From: " . $from . "\r\n";
				mail($to, $subject, $message, $headers);
			header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
}
?>