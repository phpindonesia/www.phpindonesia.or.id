<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
	include_once '../po-library/po-database.php';
	include_once '../po-library/po-function.php';
	$val = new Povalidasi;
	$mod = $_GET['mod'];
	$act = $_GET['act'];
	if (!file_exists("po-component/po-$mod/$mod.php")){ ?>
		<div class="content-header">
			<div class="header-section">
				<h1><i class="gi gi-warning_sign"></i>404<small> <?=$langpagenotfound1;?></small><br /><br /></h1>
			</div>
		</div>
		<ul class="breadcrumb breadcrumb-top">
			<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
			<li>Error</li>
		</ul>
		<div class="block block-alt-noborder">
			<h3 class="sub-header">Ooops! <?=$langpagenotfound1;?></h3>
			<p>&nbsp;</p>
			<p align="center">
				<?php
					$url = rtrim("http://".$_SERVER['HTTP_HOST'], "/").$_SERVER['PHP_SELF'];
					$url2 = preg_replace("/\/(admin\.php$)/","",$url);
					$siteurl = $url2;
				?>
				<a title="Back to Previous page" class="btn btn-sm btn-primary" onClick="history.back();"><?=$langpagenotfound3;?></a>
				<a href="<?php echo $siteurl; ?>" title="Back to the website" class="btn btn-sm btn-primary"><?=$langpagenotfound2;?></a>
			</p>
			<p>&nbsp;</p>
		</div>
		<p style="width:100%; height:250px;">&nbsp;</p>
	<?php
	}else{
		$tableroleaccess = new PoTable('user_role');
		$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, $mod);
		$currentRoleAccess = $currentRoleAccess->current();
		$numRowAccess = $tableroleaccess->numRowByAnd(id_level, $_SESSION['leveluser'], module, $mod);
		if($numRowAccess > 0){
			if($act == ""){
				if($currentRoleAccess->read_access == "Y"){
					include "po-component/po-$mod/$mod.php";
				}else{ ?>
					<div class="content-header">
						<div class="header-section">
							<h1><i class="gi gi-warning_sign"></i>404<small> <?=$langpagenotfound1;?></small><br /><br /></h1>
						</div>
					</div>
					<ul class="breadcrumb breadcrumb-top">
						<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
						<li>Error</li>
					</ul>
					<div class="block block-alt-noborder">
						<h3 class="sub-header">Ooops! <?=$langpagenotfound1;?></h3>
						<p>&nbsp;</p>
						<p align="center">
							<?php
								$url = rtrim("http://".$_SERVER['HTTP_HOST'], "/").$_SERVER['PHP_SELF'];
								$url2 = preg_replace("/\/(admin\.php$)/","",$url);
								$siteurl = $url2;
							?>
							<a title="Back to Previous page" class="btn btn-sm btn-primary" onClick="history.back();"><?=$langpagenotfound3;?></a>
							<a href="<?php echo $siteurl; ?>" title="Back to the website" class="btn btn-sm btn-primary"><?=$langpagenotfound2;?></a>
						</p>
						<p>&nbsp;</p>
					</div>
					<p style="width:100%; height:250px;">&nbsp;</p>
				<?php }
			}elseif($act == "addnew" OR $act == "addnewmultiple"){
				if($currentRoleAccess->write_access == "Y"){
					include "po-component/po-$mod/$mod.php";
				}else{ ?>
					<div class="content-header">
						<div class="header-section">
							<h1><i class="gi gi-warning_sign"></i>404<small> <?=$langpagenotfound1;?></small><br /><br /></h1>
						</div>
					</div>
					<ul class="breadcrumb breadcrumb-top">
						<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
						<li>Error</li>
					</ul>
					<div class="block block-alt-noborder">
						<h3 class="sub-header">Ooops! <?=$langpagenotfound1;?></h3>
						<p>&nbsp;</p>
						<p align="center">
							<?php
								$url = rtrim("http://".$_SERVER['HTTP_HOST'], "/").$_SERVER['PHP_SELF'];
								$url2 = preg_replace("/\/(admin\.php$)/","",$url);
								$siteurl = $url2;
							?>
							<a title="Back to Previous page" class="btn btn-sm btn-primary" onClick="history.back();"><?=$langpagenotfound3;?></a>
							<a href="<?php echo $siteurl; ?>" title="Back to the website" class="btn btn-sm btn-primary"><?=$langpagenotfound2;?></a>
						</p>
						<p>&nbsp;</p>
					</div>
					<p style="width:100%; height:250px;">&nbsp;</p>
				<?php }
			}elseif($act == "edit"){
				if($currentRoleAccess->modify_access == "Y"){
					include "po-component/po-$mod/$mod.php";
				}else{ ?>
					<div class="content-header">
						<div class="header-section">
							<h1><i class="gi gi-warning_sign"></i>404<small> <?=$langpagenotfound1;?></small><br /><br /></h1>
						</div>
					</div>
					<ul class="breadcrumb breadcrumb-top">
						<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
						<li>Error</li>
					</ul>
					<div class="block block-alt-noborder">
						<h3 class="sub-header">Ooops! <?=$langpagenotfound1;?></h3>
						<p>&nbsp;</p>
						<p align="center">
							<?php
								$url = rtrim("http://".$_SERVER['HTTP_HOST'], "/").$_SERVER['PHP_SELF'];
								$url2 = preg_replace("/\/(admin\.php$)/","",$url);
								$siteurl = $url2;
							?>
							<a title="Back to Previous page" class="btn btn-sm btn-primary" onClick="history.back();"><?=$langpagenotfound3;?></a>
							<a href="<?php echo $siteurl; ?>" title="Back to the website" class="btn btn-sm btn-primary"><?=$langpagenotfound2;?></a>
						</p>
						<p>&nbsp;</p>
					</div>
					<p style="width:100%; height:250px;">&nbsp;</p>
				<?php }
			}elseif($act == "delete"){
				if($currentRoleAccess->delete_access == "Y"){
					include "po-component/po-$mod/$mod.php";
				}else{ ?>
					<div class="content-header">
						<div class="header-section">
							<h1><i class="gi gi-warning_sign"></i>404<small> <?=$langpagenotfound1;?></small><br /><br /></h1>
						</div>
					</div>
					<ul class="breadcrumb breadcrumb-top">
						<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
						<li>Error</li>
					</ul>
					<div class="block block-alt-noborder">
						<h3 class="sub-header">Ooops! <?=$langpagenotfound1;?></h3>
						<p>&nbsp;</p>
						<p align="center">
							<?php
								$url = rtrim("http://".$_SERVER['HTTP_HOST'], "/").$_SERVER['PHP_SELF'];
								$url2 = preg_replace("/\/(admin\.php$)/","",$url);
								$siteurl = $url2;
							?>
							<a title="Back to Previous page" class="btn btn-sm btn-primary" onClick="history.back();"><?=$langpagenotfound3;?></a>
							<a href="<?php echo $siteurl; ?>" title="Back to the website" class="btn btn-sm btn-primary"><?=$langpagenotfound2;?></a>
						</p>
						<p>&nbsp;</p>
					</div>
					<p style="width:100%; height:250px;">&nbsp;</p>
				<?php }
			}else{
				include "po-component/po-$mod/$mod.php";
			}
		}else{
			include "po-component/po-$mod/$mod.php";
		}
	}
}
?>