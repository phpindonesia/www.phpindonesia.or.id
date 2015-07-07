<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
	include '../../../po-library/po-config.php';
	include '../../po-component/po-menumanager/includes/config.php';
	include '../../po-component/po-menumanager/includes/class.php';

	$mod=$_GET[mod];
	$act=$_GET[act];

	if ($mod=='menu' AND $act=='add'){
		$instance = new Menu;
		$instance->add();
	}elseif ($mod=='menu' AND $act=='edit'){
		$instance = new Menu;
		$instance->edit();
	}elseif ($mod=='menu' AND $act=='save'){
		$instance = new Menu;
		$instance->save();
	}elseif ($mod=='menu' AND $act=='save_position'){
		$instance = new Menu;
		$instance->save_position();
	}elseif ($mod=='menu' AND $act=='delete'){
		$instance = new Menu;
		$instance->delete();
	}elseif ($mod=='menu_group' AND $act=='add'){
		$instance = new Menu_group;
		$instance->add();
	}elseif ($mod=='menu_group' AND $act=='edit'){
		$instance = new Menu_group;
		$instance->edit();
	}elseif ($mod=='menu_group' AND $act=='delete'){
		$instance = new Menu_group;
		$instance->delete();
	}
}
?>