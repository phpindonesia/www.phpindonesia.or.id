<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';
include_once '../../../po-library/po-pclzip.lib.php';

$val = new Povalidasi;
$mod = $_POST['mod'];
$act = $_POST['act'];

$tableroleaccess = new PoTable('user_role');
$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, $mod);
$currentRoleAccess = $currentRoleAccess->current();

// Hapus Theme
if ($mod=='theme' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('theme');
		$currentSearch = $tabledel->findBy(id_theme, $id);
		$currentSearch = $currentSearch->current();
		$folder = $currentSearch->folder;
			$dirPath = "../../../po-content/$folder";
			$deletef = deleteDir($dirPath);
			if($deletef){
				$tabledel->deleteBy('id_theme', $id);
				header('location:../../admin.php?mod='.$mod);
			}else{
				header('location:../../404.php');
			}
	}else{
		header('location:../../404.php');
	}
}

// Input Theme
elseif ($mod=='theme' AND $act=='input'){
	if($currentRoleAccess->write_access == "Y"){
		$extensionList = array("zip");
		$fileName = $_FILES['fupload']['name'];
		$tmpName = $_FILES['fupload']['tmp_name'];
		$fileType = $_FILES['fupload']['type'];
		$fileSize = $_FILES['fupload']['size'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[1];
		$titlefile = $pecah[0];
		$seotitlefile = seo_title($titlefile);
		$acak = rand(000000,999999);
		$nama_file = "-popoji.";
		$nama_file_unik = $seotitlefile.'-'.$acak.$nama_file.$ekstensi;
		$namaDir = '../../../po-content/po-upload/';
		$pathFile = $namaDir.$nama_file_unik;
		$title = $val->validasi($_POST['title'],'xss');
		$author = $val->validasi($_POST['author'],'xss');
		$folder = $val->validasi($_POST['folder'],'xss');
		if (!empty($tmpName)){
			if (in_array($ekstensi, $extensionList)){
				move_uploaded_file($tmpName, $pathFile);
				$destination_dir = "../../../po-content/$folder";
				if (file_exists($destination_dir)){
					unlink("../../../po-content/po-upload/$nama_file_unik");
					header('location:../../404.php');
				}else{
					$file = "../../../po-content/po-upload/$nama_file_unik";
					$archive = new PclZip($file);
					if ($archive->extract(PCLZIP_OPT_PATH, $destination_dir) == 0){
						unlink("../../../po-content/po-upload/$nama_file_unik");
						header('location:../../404.php');
					}
					$table = new PoTable('theme');
					$table->save(array(
						'title' => $title,
						'author' => $author,
						'folder' => $folder
					));
					unlink("../../../po-content/po-upload/$nama_file_unik");
					header('location:../../admin.php?mod='.$mod);
				}
			}else{
				header('location:../../404.php');
			}
		}else{
			$destination_dir = "../../../po-content/$folder";
			if (file_exists($destination_dir)){
				header('location:../../404.php');
			}else{
				$file = "po-blank-theme.zip";
				$archive = new PclZip($file);
				if ($archive->extract(PCLZIP_OPT_PATH, $destination_dir) == 0){
					header('location:../../404.php');
				}
				$table = new PoTable('theme');
				$table->save(array(
					'title' => $title,
					'author' => $author,
					'folder' => $folder
				));
				header('location:../../admin.php?mod='.$mod);
			}
		}
	}else{
		header('location:../../404.php');
	}
}

// Active Theme
elseif ($mod=='theme' AND $act=='active'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$active = $val->validasi($_POST['active'],'xss');
			$tableS = new PoTable('theme');
			$currentSearch = $tableS->findBy(active, 'Y');
			$currentSearch = $currentSearch->current();
			$id_theme = $currentSearch->id_theme;
			$actives = 'N';
			$datas = array(
				'active' => $actives
			);
			$table = new PoTable('theme');
			$table->updateBy('id_theme', $id_theme, $datas);

			$data = array(
				'active' => $active
			);
			$table = new PoTable('theme');
			$table->updateBy('id_theme', $id, $data);
			header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Edit Theme
elseif ($mod=='theme' AND $act=='edit'){
	if($currentRoleAccess->modify_access == "Y"){
		$folder = $val->validasi($_POST['folder'],'xss');
		$valid = $val->validasi($_POST['file'],'xss');
		$filename = "../../../po-content/$folder/$valid";
		if (file_exists("$filename")){
			$data = $_POST['code_content'];
			$data = str_replace("textareapopojicms", "textarea", $data);
			$newdata = stripslashes($data);
			if ($newdata != ''){
				$fw = fopen($filename, 'w') or die('Could not open file!');
				$fb = fwrite($fw,$newdata) or die('Could not write to file');
				fclose($fw);
			}
		}
		header('location:../../admin.php?mod='.$mod.'&act='.$act.'&id='.$valid);
	}else{
		header('location:../../404.php');
	}
}

// Helper Theme
elseif ($mod=='theme' AND $act=='helper'){
if($currentRoleAccess->read_access == "Y"){
	$post = $val->validasi($_POST['post'],'xss');
	if($post == "headerhelper"){
//-----------------------------------------------------
echo '<p>Untuk pemanggilan css adalah sebagai berikut, silahkan melengkapi target cssnya saja.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:70px; background-color:#f0f0f0;">
<link rel="stylesheet" href="<?=$website_url;?>/po-content/<?=$folder;?>/..." type="text/css" media="all" />
</textarea></p>';
echo '<p>Untuk cara pemanggilan favicon adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:70px; background-color:#f0f0f0;">
<link rel="shortcut icon" href="<?=$website_url;?>/<?=$favicon;?>" />
</textarea></p>';
echo '<p>Code ini berfungsi untuk memanggil recaptcha milik google.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:70px; background-color:#f0f0f0;">
<script src="https://www.google.com/recaptcha/api.js"></script>
</textarea></p>';
echo '<p>Berikut adalah variabel yang sering dipakai untuk identitas website.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:110px; background-color:#f0f0f0;">
<?=$website_url;?>
<?=$website_name;?>
<?=$meta_description;?>
<?=$folder;?>
</textarea></p>';
echo '<p>Code berikut digunakan untuk pemanggilan menu dinamis PopojiCMS.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:130px; background-color:#f0f0f0;">
<?php 
	$instance = new PoController;
	$menu = $instance->popoji_menu(1, \'class="..."\', \'class="..."\');
?>
<?php echo $menu; ?>
</textarea></p>';
echo '<p>Penulisan default form pencarian contohnya adalah seperti berikut ini, yang paling penting adalah kotak pencariannya harus diberikan name="search".';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:120px; background-color:#f0f0f0;">
<form method="post" action="<?=$website_url;?>/search-result/">
	<input type="text" value="Pencarian" name="search" />
	<input type="submit" name="submit" value="Search" />
</form>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "footerhelper"){
//-----------------------------------------------------

echo '<p>Pemanggilan data post teratas pada bagian footer.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:230px; background-color:#f0f0f0;">
<?php
	$tablepopfoot = new PoTable(\'post\');
	$popfoots = $tablepopfoot->findAllLimitBy(hits, active, \'Y\', DESC, \'3\');
	foreach($popfoots as $popfoot){
?>
		Url a href : <?php echo "$website_url/detailpost/$popfoot->seotitle"; ?>
		Url img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$popfoot->picture;?>
		Title dan alt: <?=$popfoot->title;?>
		Tanggal : <?=tgl_indo($popfoot->date);?>
<?php } ?>
</textarea></p>';
echo '<p>Pemanggilan data tag teratas pada bagian footer.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:200px; background-color:#f0f0f0;">
<?php
	$tabletag = new PoTable(\'tag\');
	$tags = $tabletag->findAllLimit(id_tag, DESC, \'10\');
	foreach($tags as $tag){
?>
		Url a href : <?=$website_url;?>/search-result/<?=$tag->tag_title;?>
		Title dan alt : <?=$tag->tag_title;?>
<?php } ?>
</textarea></p>';
echo '<p>Code untuk menampilkan total subscribe, facebook share dan twitter share.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:200px; background-color:#f0f0f0;">
<?php
	$tablesubs = new PoTable(\'subscribe\');
	$totalsubs = $tablesubs->numRow();
?>
Total Subscribe : <?=$totalsubs;?>

Total Facebook share : <?php if ($sharefb==\'\'){ echo "0"; }else{ echo $sharefb; } ?>

Total Twitter share : <?php if ($sharetw==\'\'){ echo "0"; }else{ echo $sharetw; } ?>
</textarea></p>';
echo '<p>Untuk pemanggilan javascript adalah sebagai berikut, silahkan melengkapi target jsnya saja.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:70px; background-color:#f0f0f0;">
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/..."></script>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "sidebarhelper"){
//-----------------------------------------------------

echo '<p>Pemanggilan form login member pada bagian sidebar.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:250px; background-color:#f0f0f0;">
<?php if ($member_register == "Y"){ if ($mod=="home"){ ?>
	<h3>Login Member</h3>
	<p>Login ke profilmu dan share segala sesuatu tentangmu sekarang.</p>
	<form name="login-form" method="post" action="<?=$website_url;?>/po-adminboard/login.php" autocomplete="off">
		<input type="text" name="username" id="username" placeholder="Username" />
		<input type="password" name="password" id="password" placeholder="Password" />
		Belum punya akun ? Klik <a href="<?=$website_url;?>/register" title="Register Member">di sini!</a>
		Lupa password ? Klik <a href="<?=$website_url;?>/po-adminboard" title="Lupa password">di sini!</a>
		<input type="submit" name="submit" value="Login" />
	</form>
<?php }} ?>
</textarea></p>';
echo '<p>Pemanggilan data post teratas pada bagian sidebar.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:260px; background-color:#f0f0f0;">
<?php
	$tablepop = new PoTable(\'post\');
	$pops = $tablepop->findAllLimitBy(hits, active, \'Y\', DESC, \'15\');
	foreach($pops as $pop){
		$tablepopc = new PoTable(\'comment\');
		$totalpop = $tablepopc->numRowByAnd(id_post, $pop->id_post, active, \'Y\');
?>
		Url a href : <?php echo "$website_url/detailpost/$pop->seotitle"; ?>
		Img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$pop->picture;?>
		Title dan alt : <?=$pop->title;?>
		Tanggal : <?=tgl_indo($pop->date);?>
<?php } ?>
</textarea></p>';
echo '<p>Pemanggilan data post terbaru pada bagian sidebar.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:340px; background-color:#f0f0f0;">
<?php
	$tablerec = new PoTable(\'post\');
	$recs = $tablerec->findAllLimitBy(id_post, active, \'Y\', DESC, \'5\');
	foreach($recs as $rec){
		$validrec = $rec->id_category;
		$tablecatrec = new PoTable(\'category\');
		$currentCatrec = $tablecatrec->findBy(id_category, $validrec);
		$currentCatrec = $currentCatrec->current();
?>
		Url a href post : <?php echo "$website_url/detailpost/$rec->seotitle"; ?>
		Img src post : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$rec->picture;?>
		Title dan alt post : <?=$rec->title;?>
		Url a href category : <?php echo "$website_url/category/$currentCatrec->seotitle"; ?>
		Title dan alt category : <?=$currentCatrec->title;?>
		Tanggal post : <?=tgl_indo($rec->date);?>
<?php } ?>
</textarea></p>';
echo '<p>Pemanggilan data komentar pada bagian sidebar.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:320px; background-color:#f0f0f0;">
<?php
	$tablecom = new PoTable(\'comment\');
	$coms = $tablecom->findAllLimitBy(id_comment, active, \'Y\', DESC, \'5\');
	foreach($coms as $com){
		$validcom = $com->id_post;
		$tablecompo = new PoTable(\'post\');
		$currentCompo = $tablecompo->findBy(id_post, $validcom);
		$currentCompo = $currentCompo->current();
?>
		Tanggal : <?=tgl_indo($currentCompo->date);?>
		Nama : <?=$com->name;?>
		Url a href : <?php echo "$website_url/detailpost/$currentCompo->seotitle"; ?>
		Title dan alt : <?=$currentCompo->title;?>
		Komentar : <?=cuthighlight(\'post\', $com->comment, \'80\');?>
<?php } ?>
</textarea></p>';
echo '<p>Pemanggilan form berlangganan atau subscribe pada bagian sidebar, yang terpenting adalah pada bagian kotak email harus diberikan name="email_address".';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:150px; background-color:#f0f0f0;">
<h3>Berlangganan RSS</h3>
<p>Ayo berlangganan! Anda bisa mendapatkan update dari kami setiap ada postingan terbaru.</p>
<form name="subscribe-form" method="post" action="<?=$website_url;?>/subscribe.php">
	<input type="text" name="email_address" placeholder="Contoh: email_kamu@domain.com" />
	<input type="submit" name="submit" value="Berlangganan" />
</form>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "homehelper"){
//-----------------------------------------------------

echo '<p>Pemanggilan content slider di file home adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:220px; background-color:#f0f0f0;">
<?php
	$tableslider = new PoTable(\'post\');
	$sliders = $tableslider->findAllLimitByAnd(id_post, active, headline, \'Y\', \'Y\', DESC, \'5\');
	foreach($sliders as $slider){
?>
		Url a href : <?php echo "$website_url/detailpost/$slider->seotitle"; ?>
		Title dan alt : <?=$slider->title;?>
		Img src : <?=$website_url;?>/po-content/po-upload/<?=$slider->picture;?>
		Isi highlight post : <?=cuthighlight(\'post\', $slider->content, \'100\');?>
<?php } ?>
</textarea></p>';
echo '<p>Pemanggilan 1 content post terbaru di file home adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:270px; background-color:#f0f0f0;">
<?php
	$tablecona = new PoTable(\'post\');
	$conas = $tablecona->findAllLimitByAnd(id_post, id_category, active, \'4\', \'Y\', DESC, \'1\');
	foreach($conas as $cona){
?>
		Url a href : <?php echo "$website_url/detailpost/$cona->seotitle"; ?>
		Title dan alt : <?=$cona->title;?>
		Img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$cona->picture;?>
		Title post highlight : <?=cuthighlight(\'title\', $cona->title, \'30\');?>
		Tanggal : <?=tgl_indo($cona->date);?>
		Isi highlight post : <?=cuthighlight(\'post\', $cona->content, \'50\');?>
<?php } ?>
</textarea></p>';
echo '<p>Pemanggilan list content post terbaru di file home adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:270px; background-color:#f0f0f0;">
<?php
	$tableconb = new PoTable(\'post\');
	$conbs = $tableconb->findAllLimitByAnd(id_post, id_category, active, \'4\', \'Y\', DESC, \'1,2\');
	foreach($conbs as $conb){
?>
		Url a href : <?php echo "$website_url/detailpost/$conb->seotitle"; ?>
		Title dan alt : <?=$conb->title;?>
		Img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$conb->picture;?>
		Title post highlight : <?=cuthighlight(\'title\', $conb->title, \'30\');?>
		Tanggal : <?=tgl_indo($conb->date);?>
		Isi highlight post : <?=cuthighlight(\'post\', $conb->content, \'50\');?>
<?php } ?>
</textarea></p>';
echo '<p>Cara memanggil file sidebar.php ke theme.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:70px; background-color:#f0f0f0;">
<?php include_once "po-content/$folder/sidebar.php"; ?>
</textarea></p>';
echo '<p>Pemanggilan content gallery di file home adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:370px; background-color:#f0f0f0;">
<?php
	$tablegallery = new PoTable(\'gallery\');
	$gallerys = $tablegallery->findAllLimit(id_gallery, DESC, \'20\');
	foreach($gallerys as $gallery){
		$idalb = $gallery->id_album;
		$tablecalb = new PoTable(\'album\');
		$currentCalb = $tablecalb->findBy(id_album, $idalb);
		$currentCalb = $currentCalb->current();
		if ($currentCalb->active == \'Y\'){
?>
			Url a href : <?=$website_url;?>/po-content/po-upload/<?=$gallery->picture;?>
			Title dan alt gallery : <?=$gallery->title;?>
			Img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$gallery->picture;?>
			Title dan alt album : <?=$currentCalb->title;?>
<?php
		}
	} 
?>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "pageshelper"){
//-----------------------------------------------------

echo '<p>Struktur code file pages adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:350px; background-color:#f0f0f0;">
<?php
	$title = $val->validasi($_GET[\'idp\'],\'xss\');
	$tablepag = new PoTable(\'pages\');
	$currentPag = $tablepag->findByAnd(seotitle, $title, active, \'Y\');
	$currentPag = $currentPag->current();
	$idpag = $currentPag->id_pages;
	$content = $currentPag->content;
	$content = html_entity_decode($content);
?>
<?php if ($currentPag != "0"){ ?>
	Img src : <?=$website_url;?>/po-content/po-upload/<?=$currentPag->picture;?>
	Title dan alt : <?=$currentPag->title;?>
	Isi content : <?=$content;?>
	<?php include_once "po-content/$folder/sidebar.php"; ?>
<?php }else{ ?>
	Pesan error jika pages tidak ditemukan.
<?php } ?>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "categoryhelper"){
//-----------------------------------------------------

echo '<p>Struktur code file category adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:850px; background-color:#f0f0f0;">
<?php
	$title = $val->validasi($_GET[\'idc\'],\'xss\');
	$tabledcat = new PoTable(\'category\');
	$currentDcat = $tabledcat->findByAnd(seotitle, $title, active, \'Y\');
	$currentDcat = $currentDcat->current();
	$iddcat = $currentDcat->id_category;
?>
<?php if ($currentDcat != "0"){ ?>
	<?php
		$p = new Paging;
		$batas = 5;
		$posisi = $p->cariPosisi($batas);
		$tabledcpost = new PoTable(\'post\');
		$dcposts = $tabledcpost->findAllLimitByAnd(id_post, id_category, active, "$iddcat", "Y", "DESC", "$posisi,$batas");
		foreach($dcposts as $dcpost){
			$tabledccom = new PoTable(\'comment\');
			$totaldccom = $tabledccom->numRowByAnd(id_post, $dcpost->id_post, active, \'Y\');
			$tableuser = new PoTable(\'users\');
			$currentUser = $tableuser->findBy(id_user, $dcpost->editor);
			$currentUser = $currentUser->current();
	?>
			Url a href post : <?php echo "$website_url/detailpost/$dcpost->seotitle"; ?>
			Title dan alt post : <?=$dcpost->title;?>
			Url a href category  : <?php echo "$website_url/category/$currentDcat->seotitle"; ?>
			Title dan alt category : <?=$currentDcat->title;?>
			Author post : <?=$currentUser->nama_lengkap;?>
			Tanggal post : <?=tgl_indo($dcpost->date);?>
			Total komentar : <?=$totaldccom;?>
			Img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$dcpost->picture;?>
			Isi highlight post : <?=cuthighlight(\'post\', $dcpost->content, \'500\');?>
		<?php } ?>
	<ul>
		<?php
			$getpage = $val->validasi($_GET[\'page\'],\'sql\');
			$jmldata = $tabledcpost->numRowByAnd(id_category, "$iddcat", active, "Y");
			$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
			$linkHalaman = $p->navHalaman($getpage, $jmlhalaman, $website_url, "category", $currentDcat->seotitle);
			echo "$linkHalaman";
		?>
	</ul>
	<?php include_once "po-content/$folder/sidebar.php"; ?>
<?php }else{ ?>
	Pesan error jika category tidak ditemukan.
<?php } ?>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "detailposthelper"){
//-----------------------------------------------------

echo '<p>Struktur code pada file detailpost adalah sebagai berikut secara berurutan. Pertama adalah pemanggilan datanya.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:600px; background-color:#f0f0f0;">
<?php
	$title = $val->validasi($_GET[\'id\'],\'xss\');
	$detail = new PoTable();
	$currentDetail = $detail->findManualQuery($tabel = "post,users,category", $field = "", $condition = "WHERE users.id_user = post.editor AND category.id_category = post.id_category AND category.active = \'Y\' AND post.active = \'Y\' AND post.seotitle = \'".$title."\'");
	$currentDetail = $currentDetail->current();
	$idpost = $currentDetail->id_post;

	if ($currentDetail > 0){
	$tabledpost = new PoTable(\'post\');
	$currentDpost = $tabledpost->findByPost(id_post, $idpost);
	$currentDpost = $currentDpost->current();
	
	$contentdet = html_entity_decode($currentDetail->content);
	$biodet = html_entity_decode($currentDetail->bio);

	$tabledcat = new PoTable(\'category\');
	$currentDcat = $tabledcat->findBy(id_category, $currentDetail->id_category);
	$currentDcat = $currentDcat->current();

	$p = new Paging;
	$batas = 5;
	$posisi = $p->cariPosisi($batas);
	$tabledcom = new PoTable(\'comment\');
	$composts = $tabledcom->findAllLimitByAnd(id_comment, id_post, active, "$idpost", "Y", "ASC", "$posisi,$batas");
	$totaldcom = $tabledcom->numRowByAnd(id_post, $idpost, active, \'Y\');

	mysql_query($connection, "UPDATE post SET hits = $currentDetail->hits+1 WHERE id_post = \'".$idpost."\'");
?>
...bersambung ke code di bawah ini...
</textarea></p>';
echo '<p>Code untuk menampilkan isi post.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:430px; background-color:#f0f0f0;">
...bersambung dari code di atas...
Url a href post : <?php echo "$website_url/detailpost/$currentDpost->seotitle"; ?>
Title dan alt post : <?=$currentDpost->title;?>
Url a href category : <?php echo "$website_url/category/$currentDcat->seotitle"; ?>
Title dan alt category : <?=$currentDcat->title;?>
Author : <?=$currentDetail->nama_lengkap;?>
Tanggal : <?=tgl_indo($currentDetail->date);?>
Total komentar : <?=$totaldcom;?> Komentar
Img src : <?=$website_url;?>/po-content/po-upload/<?=$currentDetail->picture;?>
Isi post : <?=$contentdet;?>
List tag terkait :
	<?php
		$tabletag = new PoTable(\'tag\');
		$tags = $tabletag->findAll(id_tag, DESC);
		$arrtags = explode(\',\', $currentDetail->tag);
		foreach($tags as $tag){
		$cek = (array_search($tag->tag_seo, $arrtags) != false)? \'\' : \'display:none;\';
			echo "<a href=\'$website_url/search-result/$tag->tag_title\' title=\'$tag->tag_title\' style=\'$cek\'>$tag->tag_title</a>";
		}
	?>
...bersambung ke code di bawah ini...
</textarea></p>';
echo '<p>Code untuk menampilkan profil author atau penulis.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:280px; background-color:#f0f0f0;">
...bersambung dari code di atas...
Profil Penulis
<?php
	$filename = "po-content/po-upload/user-$currentDetail->id_user.jpg";
	if (file_exists($filename)){
		echo "<img src=\'$website_url/po-content/po-upload/user-$currentDetail->id_user.jpg\' alt=\'$currentDetail->nama_lengkap\' />";
	}else{
		echo "<img src=\'$website_url/po-content/po-upload/user-editor.jpg\' alt=\'$currentDetail->nama_lengkap\' />";
	}
?>
Nama : <?=$currentDetail->nama_lengkap;?>
Biografi : <?=$biodet;?>
...bersambung ke code di bawah ini...
</textarea></p>';
echo '<p>Code untuk menampilkan post terkait dari post yang dibuka.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:280px; background-color:#f0f0f0;">
...bersambung dari code di atas...
Artikel Terkait
<?php
	$tablerelated = new PoTable(\'post\');
	$tablerelateds = $tablerelated->findRelatedPost($currentDetail->tag, $idpost, id_post, "DESC", "5");
	foreach($tablerelateds as $tablerelated){
?>
		Url a href : <?php echo "$website_url/detailpost/$tablerelated->seotitle"; ?>
		Title dan alt : <?=$tablerelated->title;?>
		Img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$tablerelated->picture;?>
		Isi highlight post : <?=cuthighlight(\'title\', $tablerelated->title, \'20\');?>
<?php } ?>
...bersambung ke code di bawah ini...
</textarea></p>';
echo '<p>Code untuk menampilkan list komentar.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:560px; background-color:#f0f0f0;">
...bersambung dari code di atas...
<?=$totaldcom;?> Komentar Pada Artikel Ini
<?php 
	if ($totaldcom > 0){
		foreach($composts as $compost){
		$comcontent = nl2br($compost->comment);
?>
			Img avatar src : <?=$website_url;?>/po-content/chingsy/images/avatar.jpg
			Nama : <?=$compost->name;?>
			<?php if ($compost->url != \'\'){ ?>
				<a href="<?=addhttp($compost->url);?>" target="_blank"><?=$compost->name;?></a>
			<?php }else{ ?>
				<a href="#"><?=$compost->name;?></a>
			<?php } ?>
			Tanggal dan jam : <?php echo "$compost->date | $compost->time"; ?>
			Isi komentar : <?=autolink($comcontent);?>
		<?php } ?>
		<ul>
			<?php
				$getpage = $val->validasi($_GET[\'page\'],\'sql\');
				$jmldata = $tabledcom->numRowByAnd(id_post, $idpost, active, \'Y\');
				$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
				$linkHalaman = $p->navHalaman($getpage, $jmlhalaman, $website_url, "detailpost", $currentDpost->seotitle);
				echo "$linkHalaman";
			?>
		</ul>
<?php } ?>
...bersambung ke code di bawah ini...
</textarea></p>';
echo '<p>Code untuk menampilkan form inputan komentar. Silahkan dicustom elementnya menurut theme yang dipakai.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:290px; background-color:#f0f0f0;">
...bersambung dari code di atas...
Tinggalkan Komentar
<form action="<?=$website_url;?>/po-postcom.php" method="post">
	<input type="text" name="name" placeholder="Nama *" />
	<input type="text" name="email" placeholder="E-mail *" />
	<input type="text" name="url" placeholder="Website *" />
	&lt;textarea name="comment" placeholder="Isi pesan *"&gt;&lt;/textarea&gt;
	<div class="g-recaptcha" data-sitekey="6LckEgETAAAAAPdqrQSY_boMDLZRL1vpkAatVqKf"></div>
	<input type="hidden" name="id" value="<?=$idpost;?>" />
	<input type="hidden" name="seotitle" value="<?=$currentDpost->seotitle;?>" />
	<input type="submit" value="Komentar" name="submit" />
</form>
...bersambung ke code di bawah ini...
</textarea></p>';
echo '<p>Code jika post tidak ditemukan.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:110px; background-color:#f0f0f0;">
...bersambung dari code di atas...
<?php }else{ ?>
	Pesan error jika post tidak ditemukan.
<?php } ?>
</textarea></p>';
//-----------------------------------------------------
	}elseif($post == "galleryhelper"){
//-----------------------------------------------------

echo '<p>Struktur code file gallery adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:590px; background-color:#f0f0f0;">
<?php
	$p = new Paging;
	$batas = 6;
	$posisi = $p->cariPosisi($batas);
	$tablegal = new PoTable(\'gallery\');
	$gallerys = $tablegal->findAllLimit(id_gallery, "DESC", "$posisi,$batas");
	foreach($gallerys as $gallery){
		$idalb = $gallery->id_album;
		$tablecalb = new PoTable(\'album\');
		$currentCalb = $tablecalb->findBy(id_album, $idalb);
		$currentCalb = $currentCalb->current();
		if ($currentCalb->active == \'Y\'){
?>
			Url a href : <?=$website_url;?>/po-content/po-upload/<?=$gallery->picture;?>
			Title dan alt gallery : <?=$gallery->title;?>
			Img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$gallery->picture;?>
			Img src large : <?=$website_url;?>/po-content/po-upload/<?=$gallery->picture;?>
			Title dan alt album : <?=$currentCalb->title;?>
<?php
		}
	}
?>
<?php
	$getpage = $val->validasi($_GET[\'page\'],\'sql\');
	$jmldata = $tablegal->numRow();
	$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman = $p->navHalaman($getpage, $jmlhalaman, $website_url, "gallery", "page", "1");
	echo "$linkHalaman";
?>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "contacthelper"){
//-----------------------------------------------------

echo '<p>Struktur code file contact adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:220px; background-color:#f0f0f0;">
<h1>Kontak</h1>
<p>Silahkan masukan pesan di form ini untuk menghubungi kami. Inputan yang bertanda * harus diisi.</p>
<form action="<?=$website_url;?>/contact.php" method="post">
	<input type="text" name="name_contact" placeholder="Nama *" />
	<input type="text" name="email_contact" placeholder="E-mail *" />
	<input type="text" name="subject_contact" placeholder="Subjek *" />
	&lt;textarea name="message_contact" placeholder="Pesan *"&gt;&lt;/textarea&gt;
	<input type="submit" name="submit" value="Kirim Pesan" />
</form>
<?php include_once "po-content/$folder/sidebar.php"; ?>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "searchresulthelper"){
//-----------------------------------------------------

echo '<p>Struktur code file search result adalah sebagai berikut.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:980px; background-color:#f0f0f0;">
<?php
if ($_GET[\'search\'] == ""){
	$postkata = $_POST[\'search\'];
	header(\'location:\'.$website_url.\'/search-result/\'.$postkata);
}else{
	$kata = $val->validasi($_GET[\'search\'],\'xss\');
	$p = new Paging;
	$batas = 5;
	$posisi = $p->cariPosisi($batas);
	$tablesearch = new PoTable(\'post\');
	$searchposts = $tablesearch->findSearchPost($kata, "$posisi,$batas");
	$numsearchposts = $tablesearch->numRowSearchPost($kata);
	if ($numsearchposts > 0){
?>
		<?php
			foreach($searchposts as $searchpost){
				$tabledscom = new PoTable(\'comment\');
				$totaldscom = $tabledscom->numRowByAnd(id_post, $searchpost->id_post, active, \'Y\');
				$tablecatds = new PoTable(\'category\');
				$currentCatds = $tablecatds->findBy(id_category, $searchpost->id_category);
				$currentCatds = $currentCatds->current();
				$tableuser = new PoTable(\'users\');
				$currentUser = $tableuser->findBy(id_user, $searchpost->editor);
				$currentUser = $currentUser->current();
		?>
				Url a href post : <?php echo "$website_url/detailpost/$searchpost->seotitle"; ?>
				Title dan alt post : <?=$searchpost->title;?>
				Url a href category : <?php echo "$website_url/category/$currentCatds->seotitle"; ?>
				Title dan alt category : <?=$currentCatds->title;?>
				Author post : <?=$currentUser->nama_lengkap;?>
				Tanggal post : <?=tgl_indo($searchpost->date); ?>
				Total komentar : <?=$totaldscom;?>
				Img src : <?=$website_url;?>/po-content/po-upload/medium/medium_<?=$searchpost->picture;?>
				Isi highlight post : <?=cuthighlight(\'post\', $searchpost->content, \'500\');?>
		<?php } ?>
		<ul>
			<?php
				$getpage = $val->validasi($_GET[\'page\'],\'sql\');
				$jmldata = $tablesearch->numRowSearchPost($kata);
				$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
				$linkHalaman = $p->navHalaman($getpage, $jmlhalaman, $website_url, "search-result", $kata);
				echo "$linkHalaman";
			?>
		</ul>
		<?php include_once "po-content/$folder/sidebar.php"; ?>
	<?php
	}else{
		Pesan error jika pencarian tidak ditemukan.
	}
	?>
<?php } ?>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "loginhelper"){
//-----------------------------------------------------

echo '<p>Pemanggilan form login default adalah sebagai berikut silahkan dicustom elementnya.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:270px; background-color:#f0f0f0;">
<h1>Login Member</h1>
<p>Login ke profilmu dan share segala sesuatu tentangmu sekarang.</p>
<form name="login-form" method="post" action="<?=$website_url;?>/po-adminboard/login.php" autocomplete="off">
	<input type="hidden" name="mod" value="login" />
	<input type="hidden" name="act" value="proclogin" />
	<input type="text" name="username" id="username" placeholder="Username" />
	<input type="password" name="password" id="password" placeholder="Password" />
	Belum punya akun ? Klik <a href="<?=$website_url;?>/register" title="Register Member">di sini!</a>
	Lupa password ? Klik <a href="<?=$website_url;?>/po-adminboard" title="Lupa password">di sini!</a>
	<input type="submit" value="Login" name="submit" />
</form>
<?php include_once "po-content/$folder/sidebar.php"; ?>
</textarea></p>';

//-----------------------------------------------------
	}elseif($post == "registerhelper"){
//-----------------------------------------------------

echo '<p>Pemanggilan form register default adalah sebagai berikut silahkan dicustom elementnya.';
echo '<textarea class="form-control" id="pohelper" style="width:100%; height:240px; background-color:#f0f0f0;">
<h1>Register Member</h1>
<p>Daftarkan profilmu dan share segala sesuatu tentangmu sekarang.</p>
<form name="register-form" method="post" action="<?=$website_url;?>/po-adminboard/actregister.php" autocomplete="off">
	<input type="text" name="username" id="username" placeholder="Username" />
	<input type="text" name="email" id="email" placeholder="Email" />
	<input type="password" name="password" id="password" placeholder="Password" />
	<input type="password" name="re-password" id="re-password" placeholder="Retype Password" />
	Sudah punya akun sebelumnya ? Klik <a href="<?=$website_url;?>/login" title="Login Member">di sini!</a>
	<input type="submit" value="Register Account" name="submit" />
</form>
<?php include_once "po-content/$folder/sidebar.php"; ?>
</textarea></p>';

//-----------------------------------------------------
	}else{
//-----------------------------------------------------

echo '<h1>Helper element tidak ditemukan.</h1>';
	}
//-----------------------------------------------------
}else{
	echo "404 Not Found Access";
}
}
}
?>