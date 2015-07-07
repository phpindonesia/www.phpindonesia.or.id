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

if ($mod=='setting' AND $act=='website_name'){
	if($currentRoleAccess->modify_access == "Y"){
		$post = $val->validasi($_POST['post'],'xss');
		$data = array(
			'website_name' => $post
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
		echo "$post";
	}else{
		echo "404 Not Found Access";
	}
}
elseif ($mod=='setting' AND $act=='website_url'){
	if($currentRoleAccess->modify_access == "Y"){
		$post = $val->validasi($_POST['post'],'xss');
		$data = array(
			'website_url' => $post
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
		echo "$post";
	}else{
		echo "404 Not Found Access";
	}
}
elseif ($mod=='setting' AND $act=='meta_description'){
	if($currentRoleAccess->modify_access == "Y"){
		$post = $val->validasi($_POST['post'],'xss');
		$data = array(
			'meta_description' => $post
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
		echo "$post";
	}else{
		echo "404 Not Found Access";
	}
}
elseif ($mod=='setting' AND $act=='meta_keyword'){
	if($currentRoleAccess->modify_access == "Y"){
		$post = $val->validasi($_POST['post'],'xss');
		$data = array(
			'meta_keyword' => $post
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
		echo "$post";
	}else{
		echo "404 Not Found Access";
	}
}
elseif ($mod=='setting' AND $act=='favicon'){
	if($currentRoleAccess->modify_access == "Y"){
		$extensionList = array("jpg", "png", "ico");
		$fileName = $_FILES['fupload']['name'];
		$tmpName = $_FILES['fupload']['tmp_name'];
		$fileType = $_FILES['fupload']['type'];
		$fileSize = $_FILES['fupload']['size'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[1];
		$nama_file = "favicon.";
		$nama_file_unik = $nama_file.$ekstensi;
		$namaDir = '../../../';
		$pathFile = $namaDir.$nama_file_unik;
		if (!empty($tmpName)){
			if (in_array($ekstensi, $extensionList)){
				$table = new PoTable('setting');
				$currentSearch = $table->findBy(id_setting, '1');
				$currentSearch = $currentSearch->current();
				$favicon = $currentSearch->favicon;
				unlink("../../../$favicon");
				move_uploaded_file($tmpName, $pathFile);
				$data = array(
					'favicon' => $nama_file_unik
				);
				$table->updateBy('id_setting', '1', $data);
				header('location:../../admin.php?mod='.$mod);
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
elseif ($mod=='setting' AND $act=='email'){
	if($currentRoleAccess->modify_access == "Y"){
		$post = $val->validasi($_POST['post'],'xss');
		$data = array(
			'website_email' => $post
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
		echo "$post";
	}else{
		echo "404 Not Found Access";
	}
}
elseif ($mod=='setting' AND $act=='adtheme'){
	if($currentRoleAccess->modify_access == "Y"){
		$localAdTheme = $_POST['adtheme'];
		setcookie('Popoji_CMS_AdTheme',$_POST['adtheme'],1719241200,'/');
		$_COOKIE['Popoji_CMS_AdTheme'] = $_POST['adtheme'];
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
elseif ($mod=='setting' AND $act=='timezone'){
	if($currentRoleAccess->modify_access == "Y"){
		$post = $val->validasi($_POST['timezone'],'xss');
		$data = array(
			'timezone' => $post
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
elseif ($mod=='setting' AND $act=='maintenance'){
	if($currentRoleAccess->modify_access == "Y"){
		$post = $val->validasi($_POST['post'],'xss');
		$status = $val->validasi($_POST['status'],'xss');
		$data = array(
			'website_maintenance' => $status,
			'website_maintenance_tgl' => $post
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
		echo "$post";
	}else{
		echo "404 Not Found Access";
	}
}
elseif ($mod=='setting' AND $act=='cache'){
	if($currentRoleAccess->modify_access == "Y"){
		$post = $val->validasi($_POST['post'],'xss');
		$status = $val->validasi($_POST['status'],'xss');
		$data = array(
			'website_cache' => $status,
			'website_cache_time' => $post
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
	}else{
		echo "404 Not Found Access";
	}
}
elseif ($mod=='setting' AND $act=='delcache'){
	if($currentRoleAccess->modify_access == "Y"){
		$files = glob('../../../po-cache/*.tmp*');
		foreach($files as $file){
			if(is_file($file))
			unlink($file);
		}
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
elseif ($mod=='setting' AND $act=='memberregister'){
	if($currentRoleAccess->modify_access == "Y"){
		$status = $val->validasi($_POST['status'],'xss');
		$data = array(
			'member_register' => $status
		);
		$table = new PoTable('setting');
		$table->updateBy('id_setting', '1', $data);
	}else{
		echo "404 Not Found Access";
	}
}
elseif ($mod=='setting' AND $act=='editoauthfb'){
	if($currentRoleAccess->modify_access == "Y"){
		$oauth_key = $_POST['oauth_key'];
		$oauth_secret = $_POST['oauth_secret'];
		$data = array(
			'oauth_key' => $oauth_key,
			'oauth_secret' => $oauth_secret
		);
		$table = new PoTable('oauth');
		$table->updateBy('id_oauth', '1', $data);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
elseif ($mod=='setting' AND $act=='editoauthtw'){
	if($currentRoleAccess->modify_access == "Y"){
		$oauth_key = $_POST['oauth_key'];
		$oauth_secret = $_POST['oauth_secret'];
		$data = array(
			'oauth_key' => $oauth_key,
			'oauth_secret' => $oauth_secret
		);
		$table = new PoTable('oauth');
		$table->updateBy('id_oauth', '2', $data);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
elseif ($mod=='setting' AND $act=='deloauthfb'){
	if($currentRoleAccess->modify_access == "Y"){
		$data = array(
			'oauth_key' => '',
			'oauth_secret' => '',
			'oauth_id' => '',
			'oauth_user' => '',
			'oauth_token1' => '',
			'oauth_token2' => '',
			'oauth_fbtype' => ''
		);
		$table = new PoTable('oauth');
		$table->updateBy('id_oauth', '1', $data);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
elseif ($mod=='setting' AND $act=='deloauthtw'){
	if($currentRoleAccess->modify_access == "Y"){
		$data = array(
			'oauth_key' => '',
			'oauth_secret' => '',
			'oauth_id' => '',
			'oauth_user' => '',
			'oauth_token1' => '',
			'oauth_token2' => ''
		);
		$table = new PoTable('oauth');
		$table->updateBy('id_oauth', '2', $data);
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
elseif ($mod=='setting' AND $act=='metasocial'){
	if($currentRoleAccess->modify_access == "Y"){
		$filename = "meta-social.txt";
		if (file_exists("$filename")){
			$data = $_POST['meta_content'];
			$newdata = stripslashes($data);
			if ($newdata != ''){
				$fw = fopen($filename, 'w') or die('Could not open file!');
				$fb = fwrite($fw,$newdata) or die('Could not write to file');
				fclose($fw);
			}
		}
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}
elseif ($mod=='setting' AND $act=='sitemap'){
	if($currentRoleAccess->modify_access == "Y"){
		include_once 'sitemap.php';
		$changefreq = $val->validasi($_POST['changefreq'],'xss');
		$priority = $val->validasi($_POST['priority'],'xss');
			$tableset = new PoTable('setting');
			$currentSet = $tableset->findBy(id_setting, '1');
			$currentSet = $currentSet->current();
			$website_url = $currentSet->website_url;
				$sitemap = new Sitemap($website_url);
				$sitemap->setPath('../../../');
					$sitemap->addItem('/', $priority, $changefreq, $tgl_sekarang);
						$tablepages = new PoTable('pages');
						$datapagess = $tablepages->findByDESC('active', 'Y', 'id_pages');
						foreach($datapagess as $datapages){
							$sitemap->addItem('/pages/'.$datapages->seotitle, $priority, $changefreq, $datapages->date);
						}
							$tablecat = new PoTable('category');
							$datacats = $tablecat->findByDESC('active', 'Y', 'id_category');
							foreach($datacats as $datacat){
								$sitemap->addItem('/category/'.$datacat->seotitle, $priority, $changefreq, $tgl_sekarang);
							}
								$tablepost = new PoTable('post');
								$dataposts = $tablepost->findByDESC('active', 'Y', 'id_post');
								foreach($dataposts as $dataposts){
									$sitemap->addItem('/detailpost/'.$dataposts->seotitle, $priority, $changefreq, $dataposts->date);
								}
		$sitemap->createSitemapIndex($website_url, 'Today');
		header('location:../../../sitemap.xml');
	}else{
		header('location:../../404.php');
	}
}
}
?>