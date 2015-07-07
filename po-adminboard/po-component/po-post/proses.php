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

// Delete Post
if ($mod=='post' AND $act=='delete'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$tabledel = new PoTable('post');
		$currentPosts = $tabledel->findByAnd(id_post, $id, editor, $_SESSION['iduser']);
		$currentPosts = $currentPosts->current();
		if ($currentPosts == '0'){
			header('location:../../admin.php?mod='.$mod);
		}else{
			$tabledel->deleteBy('id_post', $id);
		}
		header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Multi Delete Post
elseif ($mod=='post' AND $act=='multidelete'){
	if($currentRoleAccess->delete_access == "Y"){
		$totaldata = $val->validasi($_POST['totaldata'],'xss');
		if ($totaldata != "0"){
			$itemdel = $_POST['item'];
			$tabledel = new PoTable('post');
			foreach ($itemdel as $item){
				$id = $val->validasi($item['deldata'],'xss');
				$tabledel->deleteBy('id_post', $id);
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			header('location:../../404.php');
		}
	}else{
		header('location:../../404.php');
	}
}

// Delete Image Update
elseif ($mod=='post' AND $act=='delimage'){
	if($currentRoleAccess->delete_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$picture = '';
		$data = array(
			'picture' => $picture
		);
		$table = new PoTable('post');
		$table->updateBy('id_post', $id, $data);
	}else{
		echo "404 Not Found Access";
	}
}

// Input Post
elseif ($mod=='post' AND $act=='input'){
	if($currentRoleAccess->write_access == "Y"){
		$id_category = $val->validasi($_POST['id_category'],'sql');
		$title = $val->validasi($_POST['title'],'xss');
		if ($_POST['seotitle'] != "") {
			$seotitle = $_POST['seotitle'];
		} else {
			$seotitle = seo_title($title);
		}
		$publishdate = $_POST['publishdate'];
		$publishtime = $_POST['publishtime'];
		$data = $_POST['content'];
		$data = stripslashes($data);
		$eutf = htmlspecialchars($data,ENT_QUOTES);
		if ($_SESSION[leveluser]=='1' OR $_SESSION[leveluser]=='2'){
			$active = "Y";
		}else{
			$active = "N";
		}
		if (!empty($_POST['tag'])){
			$tag_seo = $_POST['tag'];
			$tag = implode(',',$tag_seo);
		}
		if(!empty($_POST['picture'])){
			$picture = $_POST['picture'];
			$table = new PoTable('post');
			$table->save(array(
				'id_category' => $id_category,
				'title' => $title,
				'content' => $eutf,
				'seotitle' => $seotitle,
				'tag' => $tag,
				'date' => $publishdate,
				'time' => $publishtime,
				'editor' => $_SESSION['iduser'],
				'active' => $active,
				'picture' => $picture
			));
			$jml = count($tag_seo);
			for($i=0; $i<$jml; $i++){
				$dbhostsql = DATABASE_HOST;
				$dbusersql = DATABASE_USER;
				$dbpasswordsql = DATABASE_PASS;
				$dbnamesql = DATABASE_NAME;
				$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
				mysql_select_db($dbnamesql, $connection) or die(mysql_error());
				mysql_query("UPDATE tag SET count=count+1 WHERE tag_seo='$tag_seo[$i]'");
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			$table = new PoTable('post');
			$table->save(array(
				'id_category' => $id_category,
				'title' => $title,
				'content' => $eutf,
				'seotitle' => $seotitle,
				'tag' => $tag,
				'date' => $publishdate,
				'time' => $publishtime,
				'editor' => $_SESSION['iduser'],
				'active' => $active
			));
			$jml = count($tag_seo);
			for($i=0; $i<$jml; $i++){
				$dbhostsql = DATABASE_HOST;
				$dbusersql = DATABASE_USER;
				$dbpasswordsql = DATABASE_PASS;
				$dbnamesql = DATABASE_NAME;
				$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
				mysql_select_db($dbnamesql, $connection) or die(mysql_error());
				mysql_query("UPDATE tag SET count=count+1 WHERE tag_seo='$tag_seo[$i]'");
			}
			header('location:../../admin.php?mod='.$mod);
		}
	}else{
		header('location:../../404.php');
	}
}

// Edit Post
elseif ($mod=='post' AND $act=='update'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$id_category = $val->validasi($_POST['id_category'],'sql');
		$title = $val->validasi($_POST['title'],'xss');
		if ($_POST['seotitle'] != "") {
			$seotitle = $_POST['seotitle'];
		} else {
			$seotitle = seo_title($title);
		}
		$publishdate = $_POST['publishdate'];
		$publishtime = $_POST['publishtime'];
		$data = $_POST['content'];
		$data = stripslashes($data);
		$eutf = htmlspecialchars($data,ENT_QUOTES);
		if ($_SESSION[leveluser]=='1' OR $_SESSION[leveluser]=='2'){
			$active = $val->validasi($_POST['active'],'xss');
		}else{
			$active = "N";
		}
		if (!empty($_POST['tag'])){
			$tag_seo = $_POST['tag'];
			$tag = implode(',',$tag_seo);
		}
		if(!empty($_POST['picture'])){
			$picture = $_POST['picture'];
			$data = array(
				'id_category' => $id_category,
				'title' => $title,
				'content' => $eutf,
				'seotitle' => $seotitle,
				'tag' => $tag,
				'date' => $publishdate,
				'time' => $publishtime,
				'picture' => $picture,
				'active' => $active
			);
			$table = new PoTable('post');
			$table->updateBy('id_post', $id, $data);
			$jml = count($tag_seo);
			for($i=0; $i<$jml; $i++){
				$dbhostsql = DATABASE_HOST;
				$dbusersql = DATABASE_USER;
				$dbpasswordsql = DATABASE_PASS;
				$dbnamesql = DATABASE_NAME;
				$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
				mysql_select_db($dbnamesql, $connection) or die(mysql_error());
				mysql_query("UPDATE tag SET count=count+1 WHERE tag_seo='$tag_seo[$i]'");
			}
			header('location:../../admin.php?mod='.$mod);
		}else{
			$data = array(
				'id_category' => $id_category,
				'title' => $title,
				'content' => $eutf,
				'seotitle' => $seotitle,
				'tag' => $tag,
				'date' => $publishdate,
				'time' => $publishtime,
				'active' => $active
			);
			$table = new PoTable('post');
			$table->updateBy('id_post', $id, $data);
			$jml = count($tag_seo);
			for($i=0; $i<$jml; $i++){
				$dbhostsql = DATABASE_HOST;
				$dbusersql = DATABASE_USER;
				$dbpasswordsql = DATABASE_PASS;
				$dbnamesql = DATABASE_NAME;
				$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
				mysql_select_db($dbnamesql, $connection) or die(mysql_error());
				mysql_query("UPDATE tag SET count=count+1 WHERE tag_seo='$tag_seo[$i]'");
			}
			header('location:../../admin.php?mod='.$mod);
		}
	}else{
		header('location:../../404.php');
	}
}

// Input Category
elseif ($mod=='post' AND $act=='inputcategory'){
	if($currentRoleAccess->write_access == "Y"){
		$title = $val->validasi($_POST['title'],'xss');
		$seotitle = seo_title($title);
		if($title == ""){
			echo "error";
		}else{
			$table = new PoTable('category');
			$table->save(array(
				'title' => $title,
				'seotitle' => $seotitle
			));
			$tablecats = new PoTable("category");
			$cats = $tablecats->findAll(id_category, DESC);
			echo "<select class='select-chosen' name='id_category' style='width:280px;' data-placeholder='Choose a Category'>";
				foreach($cats as $cat){
					echo "<option value='$cat->id_category'>$cat->title</option>";
				}
			echo "</select>";
			?>
			<script type="text/javascript">
				$(".select-chosen").chosen({
					width: "100%"
				})
			</script>
			<?php
		}
	}else{
		echo "error";
	}
}

// Input Tag
elseif ($mod=='post' AND $act=='inputtag'){
	if($currentRoleAccess->write_access == "Y"){
		$post = $val->validasi($_POST['tag'],'xss');
		if($post == ""){
			echo "error";
		}else{
			$pecah = explode(",", $post);
			$total = count($pecah);
			$table = new PoTable('tag');
			for ($i=0; $i<$total; $i++) {
				$tag_title = $pecah[$i];
				$tag_seo = seo_title($tag_title);
				$table->save(array(
					'tag_title' => $tag_title,  
					'tag_seo' => $tag_seo
				));
			}
			$tabletag = new PoTable("tag");
			$tags = $tabletag->findAll(id_tag, DESC);
			echo "<select class='select-chosen' name='tag[]' multiple='' data-placeholder='Your Tags'>";
				foreach($tags as $tag){
					echo "<option value='$tag->tag_seo'>$tag->tag_title</option>";
				}
			echo "</select>";
			?>
			<script type="text/javascript">
				$(".select-chosen").chosen({
					width: "100%"
				})
			</script>
			<?php
		}
	}else{
		echo "error";
	}
}

// Subscribe Post
elseif ($mod=='post' AND $act=='subscribe'){
	if($currentRoleAccess->write_access == "Y"){
		$idsub = $_POST['id'];
		$table = new PoTable('post');
		$currentPosts = $table->findBy(id_post, $idsub);
		$currentPosts = $currentPosts->current();
		$titlesub = $currentPosts->title;
		$seotitlesub = $currentPosts->seotitle;
			$tableset = new PoTable('setting');
			$currentSet = $tableset->findBy(id_setting, '1');
			$currentSet = $currentSet->current();
			$website_name = $currentSet->website_name;
			$website_url = $currentSet->website_url;
			$website_email = $currentSet->website_email;
				$tablesubs = new PoTable('subscribe');
				$subs = $tablesubs->findAll(id_subscribe, ASC);
				foreach($subs as $sub){
				$emailto = $sub->email;
					$to = "$emailto";
					$from = "$website_name <$website_email>";
					$subject = "News Update - $titlesub";
					$message = "<html>
						<body>
							Hi $sub->email<br />
							We have the latest updates for you!<br />
							Please click on the link below to begin reading :<br />
							<a href='$website_url/detailpost/$seotitlesub'>$titlesub</a><br /><br />
							Thank you for subscribing,<br />
							$website_name
						</body>
					</html>"; 
					$headers  = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
					$headers .= "From: " . $from . "\r\n";
			
					mail($to, $subject, $message, $headers);
				}
			header('location:../../admin.php?mod='.$mod);
	}else{
		header('location:../../404.php');
	}
}

// Set Headline
elseif ($mod=='post' AND $act=='setheadline'){
	if($currentRoleAccess->modify_access == "Y"){
		$id = $val->validasi($_POST['id'],'sql');
		$headline = $val->validasi($_POST['headline'],'xss');
			$data = array(
				'headline' => $headline
			);
			$table = new PoTable('post');
			$table->updateBy('id_post', $id, $data);
	}else{
		echo "404 Not Found Access";
	}
}
}
?>