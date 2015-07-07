<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

	$table = new PoTable('event');
	$data = $table->findAll(id_event, "ASC");
	$json = array();
	foreach($data as $datas){
		$row = array();
		$row['id'] = $datas->id_event;
		$row['title'] = $datas->title;
		$row['start'] = $datas->start;
		$row['end'] = $datas->end;
		$row['allDay'] = $datas->allday;
		$row['color'] = "#".$datas->color;
		$json[] = $row;
	}
    echo json_encode($json);
}
?>