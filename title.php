<?php
if ($mod==""){
	header('location:404.php');
}else{
	error_reporting(0);
    if (isset($_GET['id'])){
		$idtitle = $val->validasi($_GET['id'],'xss');
		$title = new PoTable();
		$currentTitle = $title->findManualQuery($tabel = "post", $field = "", $condition = "WHERE seotitle='".$idtitle."'");
		$currentTitle = $currentTitle->current();
		if ($currentTitle){
			echo $currentTitle->title;
		}else{
			$idtitle = ucfirst($mod);
			echo $idtitle." - ".$website_name;
		}
    }elseif (isset($_GET['idp'])){
		$idtitle = $val->validasi($_GET['idp'],'xss');
		$title = new PoTable();
		$currentTitle = $title->findManualQuery($tabel = "pages", $field = "", $condition = "WHERE seotitle='".$idtitle."'");
		$currentTitle = $currentTitle->current();
		if ($currentTitle){
			echo $currentTitle->title;
		}else{
			$idtitle = ucfirst($mod);
			echo $idtitle." - ".$website_name;
		}
    }elseif (isset($_GET['idc'])){
		$idtitle = $val->validasi($_GET['idc'],'xss');
		$title = new PoTable();
		$currentTitle = $title->findManualQuery($tabel = "category", $field = "", $condition = "WHERE seotitle='".$idtitle."'");
		$currentTitle = $currentTitle->current();
		if ($currentTitle){
			echo $currentTitle->title;
		}else{
			$idtitle = ucfirst($mod);
			echo $idtitle." - ".$website_name;
		}
    }else{
		$idtitle = ucfirst($mod);
		if ($mod == "home") {
			echo $website_name;
		} else {
			echo $idtitle." - ".$website_name;
		}
    }
}
?>