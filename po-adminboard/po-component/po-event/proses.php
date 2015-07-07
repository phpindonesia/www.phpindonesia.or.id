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

// Delete Event
if ($mod=='event' AND $act=='delete'){
	$id = $val->validasi($_POST['id'],'sql');
	$tabledel = new PoTable('event');
	$tabledel->deleteBy('id_event', $id);
	header('location:../../admin.php?mod='.$mod);
}

// Input Event
elseif ($mod=='event' AND $act=='input'){
$title = $val->validasi($_POST['title'],'xss');
$seotitle = seo_title($title);
$start = $val->validasi($_POST['start'],'xss');
$end = $val->validasi($_POST['end'],'xss');
$allday = $val->validasi($_POST['allday'],'xss');
$data = $_POST['content'];
$data = stripslashes($data);
$eutf = htmlspecialchars($data,ENT_QUOTES);
$color = $val->validasi($_POST['color'],'xss');
	$table = new PoTable('event');
	$table->save(array(
		'title' => $title,
		'start' => $start,
		'end' => $end,
		'allday' => $allday,
		'content' => $eutf,
		'seotitle' => $seotitle,
		'color' => $color
	));
	header('location:../../admin.php?mod='.$mod);
}

// Edit Event
elseif ($mod=='event' AND $act=='update'){
$id = $val->validasi($_POST['id'],'sql');
$title = $val->validasi($_POST['title'],'xss');
$seotitle = seo_title($title);
$data = $_POST['content'];
$data = stripslashes($data);
$eutf = htmlspecialchars($data,ENT_QUOTES);
$color = $val->validasi($_POST['color'],'xss');
$active = $val->validasi($_POST['active'],'xss');
	$data = array(
		'title' => $title,
		'content' => $eutf,
		'seotitle' => $seotitle,
		'color' => $color,
		'active' => $active
	);
	$table = new PoTable('event');
	$table->updateBy('id_event', $id, $data);
	header('location:../../admin.php?mod='.$mod);
}

// Edit Event Drag
elseif ($mod=='event' AND $act=='updatedrag'){
$id = $val->validasi($_POST['id'],'sql');
$start = $val->validasi($_POST['start'],'xss');
$end = $val->validasi($_POST['end'],'xss');
$allday = 'true';
	$data = array(
		'start' => $start,
		'end' => $end,
		'allday' => $allday
	);
	$table = new PoTable('event');
	$table->updateBy('id_event', $id, $data);
	header('location:../../admin.php?mod='.$mod);
}
}
?>