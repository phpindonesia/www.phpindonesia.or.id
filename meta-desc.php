<?php
if ($mod==""){
	header('location:404.php');
}else{
	error_reporting(0);
    if (isset($_GET['id'])){
		$idmetadesc = $val->validasi($_GET['id'],'xss');
		$metadesc = new PoTable();
		$currentMetaDesc = $metadesc->findManualQuery($tabel = "post", $field = "", $condition = "WHERE seotitle='".$idmetadesc."'");
		$currentMetaDesc = $currentMetaDesc->current();
		if ($currentMetaDesc){
			echo cuthighlight('post', $currentMetaDesc->content, '200');
		}else{
			$idmetadesc = ucfirst($mod);
			echo $idmetadesc." - ".$meta_description;
		}
    }elseif (isset($_GET['idp'])){
		$idmetadesc = $val->validasi($_GET['idp'],'xss');
		$metadesc = new PoTable();
		$currentMetaDesc = $metadesc->findManualQuery($tabel = "pages", $field = "", $condition = "WHERE seotitle='".$idmetadesc."'");
		$currentMetaDesc = $currentMetaDesc->current();
		if ($currentMetaDesc){
			echo cuthighlight('post', $currentMetaDesc->content, '200');
		}else{
			$idmetadesc = ucfirst($mod);
			echo $idmetadesc." - ".$meta_description;
		}
    }else{
		$idmetadesc = ucfirst($mod);
		echo $idmetadesc." - ".$meta_description;
    }
}
?>