<?php
session_start();
error_reporting(0);
include "timeout.php";

if($_SESSION[login]==1){
	if(!cek_login()){
		$_SESSION[login] = 0;
	}
}
if($_SESSION[login]==0){
	header('location:logout.php');
}else{
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
	header('location:404.php');
}else{
	if(isset($_POST['Lang'])) {
		$localLang = $_POST['Lang'];
		setcookie('Popoji_CMS_Lang',$_POST['Lang'],1719241200,'/');
		$_COOKIE['Popoji_CMS_Lang'] = $_POST['Lang'];
		echo "<script type=\"text/javascript\">parent.location='admin.php?mod=home';</script>";
	}elseif(isset($_COOKIE['Popoji_CMS_Lang'])){
		$localLang = $_COOKIE['Popoji_CMS_Lang'];
	}else{
		$localLang = 'indonesia';
	}
	include "lang/$localLang/lang.php";
	$urlhost = rtrim("http://".$_SERVER['HTTP_HOST'], "/").$_SERVER['PHP_SELF'];
	$urlhost2 = preg_replace("/\/po-adminboard\/(admin\.php$)/","",$urlhost);
	$siteurl = $urlhost2;
	if(isset($_COOKIE['Popoji_CMS_AdTheme'])){
		$localAdTheme = $_COOKIE['Popoji_CMS_AdTheme'];
	}else{
		$localAdTheme = 'modern';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="Copyright" content="Popojicms" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Administrator PopojiCMS" />
    <meta name="keywords" content="administrator popojicms, popojicms" />
    <meta name="generator" content="PopojiCMS v.1.3.0" />
    <meta name="author" content="Dwira Survivor" />
    <meta name="language" content="Indonesia" />
    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->
    <title><?php $titcomponame = ucfirst($_GET['mod']); if ($_SESSION[leveluser]=='1' OR $_SESSION[leveluser]=='2'){ echo $titcomponame; ?> - Administrator Dashboard<?php }else{ echo $titcomponame; ?> - Member Dashboard<?php } ?></title>
    <link rel="shortcut icon" href="favicon.png" />

	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="css/plugins.css" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<link type="text/css" rel="stylesheet" href="css/themes.css" />
	<link type="text/css" rel="stylesheet" href="css/themes/<?=$localAdTheme;?>.css" />
	<link type="text/css" rel="stylesheet" href="js/plugins/filemanager/fancybox/jquery.fancybox.css" />
    <link type="text/css" rel="stylesheet" href="js/plugins/others/datetimepicker/jquery.datetimepicker.css">

	<?php
		$modedtheme = $_GET['mod'];
		if ($modedtheme == "theme" OR $modedtheme == "setting"){
	?>
	<link type="text/css" rel="stylesheet" href="js/plugins/codemirror/lib/codemirror.css" />
	<link type="text/css" rel="stylesheet" href="js/plugins/codemirror/theme/github.css" />
	<link type="text/css" rel="stylesheet" href="js/plugins/codemirror/addon/display/fullscreen.css" />
	<link type="text/css" rel="stylesheet" href="js/plugins/codemirror/addon/hint/show-hint.css" />
	<link type="text/css" rel="stylesheet" href="js/plugins/codemirror/addon/dialog/dialog.css" />
	<link type="text/css" rel="stylesheet" href="js/plugins/contextmenu/jquery.contextMenu.css" />
	<?php
		}
	?>

	<script type="text/javascript" src="js/vendor/modernizr-2.7.1-respond-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/vendor/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/vendor/bootstrap.min.js"></script>
</head>
<body>
	<div id="page-container" class="sidebar-full">
		<div id="sidebar">
			<div class="sidebar-scroll">
				<div class="sidebar-content">
					<a href="admin.php?mod=home" class="sidebar-brand">
					<?php if ($_SESSION[leveluser]=='1' OR $_SESSION[leveluser]=='2'){ ?><strong>Admin</strong>istrator</a><?php }else{ ?><strong>Member</strong> Page</a><?php } ?>
					<?php include "menu.php"; ?>
				</div>
			</div>
		</div>
		<div id="main-container">
			<header class="navbar navbar-inverse">
			<ul class="nav navbar-nav-custom">
				<li class="hidden-xs hidden-sm">
					<a href="javascript:void(0)" id="sidebar-toggle-lg"><i class="fa fa-list-ul fa-fw"></i></a>
				</li>
				<li class="hidden-md hidden-lg">
					<a href="javascript:void(0)" id="sidebar-toggle-sm"><i class="fa fa-bars fa-fw"></i></a>
				</li>
				<li class="hidden-md hidden-lg">
					<a href="admin.php?mod=home"><i class="gi gi-home fa-fw"></i></a>
				</li>
			</ul>
			<ul class="nav navbar-nav-custom pull-right">
				<li class="dropdown">
					<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
					<?php
					$filename = "../po-content/po-upload/user-$_SESSION[iduser].jpg";
					if (file_exists("$filename")){
						echo "<img src='../po-content/po-upload/user-$_SESSION[iduser].jpg' alt='avatar' width='30' height='30' />";
					}else{
						echo "<img src='../po-content/po-upload/user-editor.jpg' alt='avatar' width='30' height='30' />";
					}
					?>
					</a>
					<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
						<?php if ($_SESSION[leveluser]=='1' OR $_SESSION[leveluser]=='2'){ ?>
						<li class="dropdown-header text-center"><?=$langmenu29;?></li>
						<li>
							<a href="<?=$siteurl;?>" target="_blank"><i class="fa fa-desktop fa-fw pull-right"></i><?=$langmenu30;?></a>
							<a href="admin.php?mod=contact"><i class="fa fa-envelope fa-fw pull-right"></i><?=$langmenu26;?></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="admin.php?mod=user"><i class="fa fa-user fa-fw pull-right"></i><?=$langmenu27;?></a>
							<a href="admin.php?mod=setting" data-toggle="modal"><i class="fa fa-cog fa-fw pull-right"></i><?=$langmenu14;?></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="logout.php"><i class="fa fa-ban fa-fw pull-right"></i><?=$langmenu22;?></a>
						</li>
						<?php }else{ ?>
						<li class="dropdown-header text-center"><?=$langmenu29;?></li>
						<li>
							<a href="<?=$siteurl;?>" target="_blank"><i class="fa fa-desktop fa-fw pull-right"></i><?=$langmenu30;?></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="admin.php?mod=user"><i class="fa fa-user fa-fw pull-right"></i><?=$langmenu27;?></a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="logout.php"><i class="fa fa-ban fa-fw pull-right"></i><?=$langmenu22;?></a>
						</li>
						<?php } ?>
					</ul>
				</li>
			</ul>
			</header>
			<div id="page-content">
				<?php include "content.php"; ?>
			</div>
			<footer class="clearfix"></footer>
		</div>
	</div>
	<div id="alertalldel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=$langdelete1;?></h3>
				</div>
				<div class="modal-body"><?=$langdelete2;?></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" id="confirmdel"><i class="fa fa-trash-o"></i> <?=$langdelete3;?></button>
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> <?=$langdelete4;?></button>
				</div>
			</div>
		</div>
	</div>
    <ul id="nav-fast-menu">
        <li><a href="admin.php?mod=post&act=addnew" class="themed-background-fire" data-toggle="tooltip" data-original-title="+ <?=$langmenu2;?>"><i class="fa fa-book"></i></a></li>
        <li><a href="admin.php?mod=category&act=addnew" class="themed-background-amethyst" data-toggle="tooltip" data-original-title="+ <?=$langmenu5;?>"><i class="fa fa-tasks"></i></a></li>
        <li><a href="admin.php?mod=tag&act=addnew" class="themed-background-modern" data-toggle="tooltip" data-original-title="+ <?=$langmenu6;?>"><i class="fa fa-tags"></i></a></li>
        <li><a href="admin.php?mod=pages&act=addnew" class="themed-background-flatie" data-toggle="tooltip" data-original-title="+ <?=$langmenu10;?>"><i class="fa fa-file-text"></i></a></li>
        <li><a href="admin.php?mod=library&act=addnewmultiple" class="themed-background-autumn" data-toggle="tooltip" data-original-title="+ <?=$langmenu7;?>"><i class="fa fa-picture-o"></i></a></li>
        <li><a href="admin.php?mod=theme&act=addnew" class="themed-background-night" data-toggle="tooltip" data-original-title="+ <?=$langmenu15;?>"><i class="fa fa-desktop"></i></a></li>
        <li><a href="admin.php?mod=component&act=addnew" class="themed-background-spring" data-toggle="tooltip" data-original-title="+ <?=$langmenu16;?>"><i class="fa fa fa-puzzle-piece"></i></a></li>
        <li><a href="admin.php?mod=user&act=addnew" class="themed-background-fancy" data-toggle="tooltip" data-original-title="+ <?=$langmenu19;?>"><i class="fa fa-users"></i></a></li>
    </ul>
	<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

	<script type="text/javascript" src="js/plugins.js"></script>
	<script type="text/javascript" src="js/plugins/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="js/plugins/uploader/plupload.full.min.js"></script>
	<script type="text/javascript" src="js/plugins/uploader/jquery.plupload.queue.min.js"></script>
	<script type="text/javascript" src="js/plugins/filemanager/fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/menu/ferromenu.js"></script>
    <script type="text/javascript" src="js/plugins/others/datetimepicker/jquery.datetimepicker.js"></script>

	<?php
		$modedtheme = $_GET['mod'];
		if ($modedtheme == "theme" OR $modedtheme == "setting"){
	?>
	<script type="text/javascript" src="js/plugins/codemirror/lib/codemirror.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/fold/xml-fold.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/edit/matchtags.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/edit/closetag.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/edit/closebrackets.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/selection/active-line.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/display/fullscreen.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/hint/show-hint.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/hint/xml-hint.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/hint/html-hint.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/dialog/dialog.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/search/searchcursor.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/addon/search/search.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/mode/clike/clike.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/mode/css/css.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/mode/javascript/javascript.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/mode/php/php.js"></script>
	<script type="text/javascript" src="js/plugins/codemirror/mode/xml/xml.js"></script>
	<script type="text/javascript" src="js/plugins/contextmenu/jquery.contextMenu.js"></script>
	<script type="text/javascript" src="js/plugins/contextmenu/data.contextMenu.js"></script>
	<?php
		}
	?>

	<script type="text/javascript" src="js/app.js"></script>
	<?php
		$modjs = $_GET['mod'];
		if (file_exists("po-component/po-$modjs/javascript.js")){
	?>
			<script type="text/javascript" src="<?php echo "po-component/po-$modjs/javascript.js"; ?>"></script>
	<?php } ?>
	<?php
		$tableseteditor = new PoTable('setting');
		$currentSetEditor = $tableseteditor->findBy(id_setting, '1');
		$currentSetEditor = $currentSetEditor->current();
	?>
	<script type="text/javascript">
		tinymce.init({
			selector: "#po-wysiwyg",
			skin: "light",
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons paste textcolor responsivefilemanager",
                "code fullscreen youtube autoresize"
			],
			menubar : false,
			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent table",
            toolbar2: "| fontsizeselect | styleselect | link unlink anchor | responsivefilemanager image media youtube | forecolor backcolor | fullscreen ",
			image_advtab: true,
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
			relative_urls: false,
			remove_script_host: false,
			external_filemanager_path: "<?=$currentSetEditor->website_url;?>/po-adminboard/js/plugins/filemanager/",
			filemanager_title: "File Manager",
			external_plugins: {
				"filemanager" : "<?=$currentSetEditor->website_url;?>/po-adminboard/js/plugins/filemanager/plugin.min.js"
			}
		});
	</script>
</body>
</html>
<?php
}
}
?>