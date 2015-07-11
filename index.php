<?php
if (!file_exists("po-library/po-config.php")){
	$now = gmdate('D, d M Y H:i:s') . ' GMT';
	header("Expires: $now");
	header("Last-Modified: $now");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	echo "Maaf, PopojiCMS anda <b>belum terinstall</b>\n";
	if (file_exists("po-install/index.php")){
		echo "Mohon tunggu kami akan mendirect ke halaman installasi<br />\n";
		echo "<script language=\"Javascript\">location.href = 'po-install/index.php';</script>\n";
	}
	exit;
}else{
	ob_start();
	session_start();
	include_once 'po-library/po-database.php';
	include_once 'po-library/po-function.php';
	include_once 'po-adminboard/po-component/po-menumanager/includes/config.php';
	include_once 'po-library/po-classmenu.php';

	$val = new Povalidasi;

	$dbhostsql = DATABASE_HOST;
	$dbusersql = DATABASE_USER;
	$dbpasswordsql = DATABASE_PASS;
	$dbnamesql = DATABASE_NAME;
	$dbportsql = DATABASE_PORT;
	$connection = pg_connect("host=".$dbhostsql." port=".$dbportsql." dbname=".$dbnamesql." user=".$dbusersql." password=".$dbpasswordsql) or die(pg_last_error());

	$table = new PoTable('theme');
	$current = $table->findBy(active, 'Y');
	$current = $current->current();
	$folder = $current->folder;
	
	$tableset = new PoTable('setting');
	$currentSet = $tableset->findBy(id_setting, '1');
	$currentSet = $currentSet->current();
	$website_name = $currentSet->website_name;
	$website_url = $currentSet->website_url;
	$meta_description = $currentSet->meta_description;
	$meta_keyword = $currentSet->meta_keyword;
	$favicon = $currentSet->favicon;
	$mode_maintenance = $currentSet->website_maintenance;
	$website_cache = $currentSet->website_cache;
	$website_cache_time = $currentSet->website_cache_time;
	$member_register = $currentSet->member_register;

	$ipstat = $_SERVER['REMOTE_ADDR'];
	$tanggalstat = date("Ymd");
	$waktustat = time();

	$tablestat = new PoTable('traffic');
	$totalstat = $tablestat->numRowByAnd(ip, $ipstat, tanggal, $tanggalstat);

	if($totalstat == 0){
		$tablestatp = new PoTable('traffic');
		$tablestatp->save(array(
			'ip' => $ipstat,
			'tanggal' => $tanggalstat,
			'hits' => 1,
			'online' => $waktustat
		));
	}else{
		$tablestatp2 = new PoTable('traffic');
		$statpro = $tablestatp2->findByAnd(ip, $ipstat, tanggal, $tanggalstat);
		$statpro = $statpro->current();
		$hitspro = $statpro->hits;
		$hitspro = $hitspro+1;
		$datastat = array(
			'hits' => $hitspro,
			'online' => $waktustat
		);
		$tablestat2 = new PoTable('traffic');
		$tablestat2->updateByAnd('ip', $ipstat, 'tanggal', $tanggalstat, $datastat);
	}

	/*--- hapus baris ini dan ubah urlnya jika web Anda sudah di hosting
	function facebook_shares($url){
		$fql  = "SELECT url, normalized_url, share_count, like_count, comment_count, ";  
		$fql .= "total_count, commentsbox_count, comments_fbid, click_count FROM ";
		$fql .= "link_stat WHERE url = '".$url."'";
		$apifql="https://api.facebook.com/method/fql.query?format=json&query=".urlencode($fql);  
		$fb_json=file_get_contents($apifql);
		return json_decode($fb_json);
	}

	$fb = facebook_shares('http://www.popojicms.org');
	$sharefb = $fb[0]->share_count;

	function twitter_shares($url) {
		$json_string = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url);
		$json = json_decode($json_string, true);
		return intval($json['count']);
	}

	$twit = twitter_shares('http://www.popojicms.org');
	$sharetw = $twit;
	hapus baris ini dan ubah urlnya jika web Anda sudah di hosting ---*/

	if ($mode_maintenance == "Y"){
		header('location:maintenance');
	}else{
		if (!isset($_SESSION['submit'])) {
			$_SESSION['submit'] = true;
		}
		$mod = $_GET['mod'];
		if (file_exists("po-content/$folder/$mod.php")){
			if ($website_cache == "Y"){
				$cacheuri = $_SERVER['REQUEST_URI'];
				$cachename = md5(seo_title($cacheuri));
				$cachefile = 'po-cache/'.$cachename.'.tmp';
				$cachetime = $website_cache_time * 60;
				if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
					include_once($cachefile);
				}else{
					ob_start();
					include_once "po-content/$folder/$mod.php";
					$fp = fopen($cachefile, 'w');
					fwrite($fp, ob_get_contents());
					fclose($fp);
					ob_end_flush();
				}
			}else{
				include_once "po-content/$folder/$mod.php";
			}
		}else{
			header('location:404.php');
		}
	}
}
?>