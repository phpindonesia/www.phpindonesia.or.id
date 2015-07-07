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
			$metasocial_mod = ucfirst($mod);
			$metasocial_name = $website_name;
			$metasocial_url = $website_url.'/detailpost/'.$currentMetaDesc->seotitle;
			$metasocial_title = $currentMetaDesc->title;
			$metasocial_desc = cuthighlight('post', $currentMetaDesc->content, '200');
			$metasocial_img = $website_url.'/po-content/po-upload/'.$currentMetaDesc->picture;
		}else{
			$metasocial_mod = ucfirst($mod);
			$metasocial_name = $website_name;
			$metasocial_url = $website_url;
			$metasocial_title = $website_name;
			$metasocial_desc = $meta_description;
			$metasocial_img = $website_url.'/favicon.png';
		}
    }elseif (isset($_GET['idp'])){
		$idmetadesc = $val->validasi($_GET['idp'],'xss');
		$metadesc = new PoTable();
		$currentMetaDesc = $metadesc->findManualQuery($tabel = "pages", $field = "", $condition = "WHERE seotitle='".$idmetadesc."'");
		$currentMetaDesc = $currentMetaDesc->current();
		if ($currentMetaDesc){
			$metasocial_mod = ucfirst($mod);
			$metasocial_name = $website_name;
			$metasocial_url = $website_url.'/pages/'.$currentMetaDesc->seotitle;
			$metasocial_title = $currentMetaDesc->title;
			$metasocial_desc = cuthighlight('post', $currentMetaDesc->content, '200');
			$metasocial_img = $website_url.'/po-content/po-upload/'.$currentMetaDesc->picture;
		}else{
			$metasocial_mod = ucfirst($mod);
			$metasocial_name = $website_name;
			$metasocial_url = $website_url;
			$metasocial_title = $website_name;
			$metasocial_desc = $meta_description;
			$metasocial_img = $website_url.'/favicon.png';
		}
    }else{
		$metasocial_mod = ucfirst($mod);
		$metasocial_name = $website_name;
		$metasocial_url = $website_url;
		$metasocial_title = $website_name;
		$metasocial_desc = $meta_description;
		$metasocial_img = $website_url.'/favicon.png';
    }
    include "po-adminboardboard/po-component/po-setting/meta-social.txt";
}
?>