<?php
if ($mod==""){
	header('location:404.php');
}else{
	error_reporting(0);
    if (isset($_GET['id'])){
		$idmetakey = $val->validasi($_GET['id'],'xss');
		$metekey = new PoTable();
		$currentMetaKey = $metekey->findManualQuery($tabel = "post", $field = "", $condition = "WHERE seotitle='".$idmetakey."'");
		$currentMetaKey = $currentMetaKey->current();
		if ($currentMetaKey){
			echo $currentMetaKey->tag;
		}else{
			echo $meta_keyword;
		}
    }
    else{
		echo $meta_keyword;
    }
}
?>