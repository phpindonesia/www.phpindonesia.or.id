<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
	if ($_SESSION[leveluser]=='1' OR $_SESSION[leveluser]=='2'){
	$action = $_GET['mod'];
	$activehome = ($action == 'home') ? 'active' : '';
	$activepost = ($action == 'post') ? 'active' : '';
	$activecategory = ($action == 'category') ? 'active' : '';
	$activetags = ($action == 'tag') ? 'active' : '';
	$activepages = ($action == 'pages') ? 'active' : '';
	$activelibrary = ($action == 'library') ? 'active' : '';
	$activesetting = ($action == 'setting') ? 'active' : '';
	$activetheme = ($action == 'theme') ? 'active' : '';
	$activemenu = ($action == 'menumanager') ? 'active' : '';
	$activecomponent = ($action == 'component') ? 'active' : '';
	$activeuser = ($action == 'user') ? 'active' : '';
    $activecogen = ($action == 'cogen') ? 'active' : '';

	if ($action == 'post'){
		$actionact = $_GET['act'];
		$thispost = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thispostaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'category'){
		$actionact = $_GET['act'];
		$thiscategory = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thiscategoryaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'tag'){
		$actionact = $_GET['act'];
		$thistag = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thistagaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'pages'){
		$actionact = $_GET['act'];
		$thispages = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thispagesaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'library'){
		$actionact = $_GET['act'];
		$thislibrary = ($actionact == '') ? 'active' : '';
		$thislibraryaddnew = ($actionact == 'addnew') ? 'active' : '';
		$thislibraryaddnewmulti = ($actionact == 'addnewmultiple') ? 'active' : '';
	}elseif ($action == 'theme'){
		$actionact = $_GET['act'];
		$thistheme = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thisthemeaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'component'){
		$actionact = $_GET['act'];
		$thiscomponent = ($actionact == '' OR $actionact == 'importtable') ? 'active' : '';
		$thiscomponentaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'user'){
		$actionact = $_GET['act'];
		$thisuser = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thisuseraddnew = ($actionact == 'addnew') ? 'active' : '';
    }elseif ($action == 'cogen'){
		$actionact = $_GET['act'];
		$thiscogen = ($actionact == '' OR $actionact == 'compogen') ? 'active' : '';
	}else{
		$actionact = $_GET['act'];
		$thiscomponent = ($actionact == '') ? 'active' : '';
	}
	echo "<ul class='sidebar-nav'>
		<li>
			<a href='admin.php?mod=home' class='$activehome'><i class='gi gi-home sidebar-nav-icon'></i>$langmenu1</a>
		</li>
		<li class='sidebar-header'>
			<span class='sidebar-header-title'>$langmenu2</span>
		</li>
		<li class='$activepost'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='gi gi-book sidebar-nav-icon'></i>$langmenu2</a>
			<ul>
				<li><a href='admin.php?mod=post' class='$thispost'>$langmenu3</a></li>
				<li><a href='admin.php?mod=post&act=addnew' class='$thispostaddnew'>$langmenu4</a></li>
			</ul>
		</li>
		<li class='$activecategory'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='hi hi-tasks sidebar-nav-icon'></i>$langmenu5</a>
			<ul>
				<li><a href='admin.php?mod=category' class='$thiscategory'>$langmenu5</a></li>
				<li><a href='admin.php?mod=category&act=addnew' class='$thiscategoryaddnew'>$langmenu4</a></li>
			</ul>
		</li>
		<li class='$activetags'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='gi gi-tags sidebar-nav-icon'></i>$langmenu6</a>
			<ul>
				<li><a href='admin.php?mod=tag' class='$thistag'>$langmenu6</a></li>
				<li><a href='admin.php?mod=tag&act=addnew' class='$thistagaddnew'>$langmenu4</a></li>
			</ul>
		</li>
		<li class='sidebar-header'>
			<span class='sidebar-header-title'>$langmenu10</span>
		</li>
		<li class='$activepages'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='hi hi-file sidebar-nav-icon'></i>$langmenu10</a>
			<ul>
				<li><a href='admin.php?mod=pages' class='$thispages'>$langmenu11</a></li>
				<li><a href='admin.php?mod=pages&act=addnew' class='$thispagesaddnew'>$langmenu12</a></li>
			</ul>
		</li>
		<li class='sidebar-header'>
			<span class='sidebar-header-title'>$langmenu7</span>
		</li>
		<li class='$activelibrary'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='fa fa-picture-o sidebar-nav-icon'></i>$langmenu7</a>
			<ul>
				<li><a href='admin.php?mod=library' class='$thislibrary'>$langmenu8</a></li>
				<li><a href='admin.php?mod=library&act=addnew' class='$thislibraryaddnew'>$langmenu9</a></li>
				<li><a href='admin.php?mod=library&act=addnewmultiple' class='$thislibraryaddnewmulti'>$langmenu9 Multiple</a></li>
			</ul>
		</li>
		<li class='sidebar-header'>
			<span class='sidebar-header-title'>$langmenu13</span>
		</li>
		<li>
			<a href='admin.php?mod=setting' class='$activesetting'><i class='gi gi-cogwheels sidebar-nav-icon'></i>$langmenu14</a>
		</li>
		<li class='$activetheme'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='gi gi-imac sidebar-nav-icon'></i>$langmenu15</a>
			<ul>
				<li><a href='admin.php?mod=theme' class='$thistheme'>$langmenu15</a></li>
				<li><a href='admin.php?mod=theme&act=addnew' class='$thisthemeaddnew'>$langmenu18</a></li>
			</ul>
		</li>
		<li>
			<a href='admin.php?mod=menumanager' class='$activemenu'><i class='fa fa-sitemap sidebar-nav-icon'></i>$langmenu28</a>
		</li>
		<li class='sidebar-header'>
			<span class='sidebar-header-title'>$langmenu16</span>
		</li>
		<li class='$activecomponent $activecogen'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='fa fa-puzzle-piece sidebar-nav-icon'></i>$langmenu16</a>
			<ul>
				<li><a href='admin.php?mod=component' class='$thiscomponent'>$langmenu17</a></li>
				<li><a href='admin.php?mod=component&act=addnew' class='$thiscomponentaddnew'>$langmenu18</a></li>
                <li><a href='admin.php?mod=cogen' class='$thiscogen'>CoGen</a></li>
				<li>
					<a href='#' class='sidebar-nav-submenu'><i class='fa fa-angle-left sidebar-nav-indicator'></i>$langmenu31</a>
					<ul>";
						include_once '../po-library/po-database.php';
						$tablecomponentm = new PoTable('component');
						$componentmenus = $tablecomponentm->findAll(id_component, DESC);
						foreach($componentmenus as $componentmenu){
							$pecahurl = explode("-", $componentmenu->component);
							$url = $pecahurl[1];
							echo "<li><a href='admin.php?mod=$url'>$componentmenu->component</a></li>";
						}
					echo "</ul>
				</li>
			</ul>
		</li>
		<li class='sidebar-header'>
			<span class='sidebar-header-title'>$langmenu19</span>
		</li>
		<li class='$activeuser'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='gi gi-group sidebar-nav-icon'></i>$langmenu19</a>
			<ul>
				<li><a href='admin.php?mod=user' class='$thisuser'>$langmenu20</a></li>
				<li><a href='admin.php?mod=user&act=addnew' class='$thisuseraddnew'>$langmenu21</a></li>
			</ul>
		</li>
	</ul>";
	}else{
	$action = $_GET['mod'];
	$activehome = ($action == 'home') ? 'active' : '';
	$activepost = ($action == 'post') ? 'active' : '';
	$activecategory = ($action == 'category') ? 'active' : '';
	$activetags = ($action == 'tag') ? 'active' : '';
	$activeuser = ($action == 'user') ? 'active' : '';

	if ($action == 'post'){
		$actionact = $_GET['act'];
		$thispost = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thispostaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'category'){
		$actionact = $_GET['act'];
		$thiscategory = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thiscategoryaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'tag'){
		$actionact = $_GET['act'];
		$thistag = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thistagaddnew = ($actionact == 'addnew') ? 'active' : '';
	}elseif ($action == 'user'){
		$actionact = $_GET['act'];
		$thisuser = ($actionact == '' OR $actionact == 'edit') ? 'active' : '';
		$thisuseraddnew = ($actionact == 'addnew') ? 'active' : '';
	}else{
		$actionact = $_GET['act'];
		$thiscomponent = ($actionact == '') ? 'active' : '';
	}
	echo "<ul class='sidebar-nav'>
		<li>
			<a href='admin.php?mod=home' class='$activehome'><i class='gi gi-home sidebar-nav-icon'></i>$langmenu1</a>
		</li>
		<li class='sidebar-header'>
			<span class='sidebar-header-title'>$langmenu2</span>
		</li>
		<li class='$activepost'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='gi gi-book sidebar-nav-icon'></i>$langmenu2</a>
			<ul>
				<li><a href='admin.php?mod=post' class='$thispost'>$langmenu3</a></li>
				<li><a href='admin.php?mod=post&act=addnew' class='$thispostaddnew'>$langmenu4</a></li>
			</ul>
		</li>
		<li class='$activecategory'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='hi hi-tasks sidebar-nav-icon'></i>$langmenu5</a>
			<ul>
				<li><a href='admin.php?mod=category' class='$thiscategory'>$langmenu5</a></li>
				<li><a href='admin.php?mod=category&act=addnew' class='$thiscategoryaddnew'>$langmenu4</a></li>
			</ul>
		</li>
		<li class='$activetags'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='gi gi-tags sidebar-nav-icon'></i>$langmenu6</a>
			<ul>
				<li><a href='admin.php?mod=tag' class='$thistag'>$langmenu6</a></li>
				<li><a href='admin.php?mod=tag&act=addnew' class='$thistagaddnew'>$langmenu4</a></li>
			</ul>
		</li>
		<li class='sidebar-header'>
			<span class='sidebar-header-title'>$langmenu19</span>
		</li>
		<li class='$activeuser'>
			<a href='#' class='sidebar-nav-menu'><i class='fa fa-angle-left sidebar-nav-indicator'></i><i class='gi gi-group sidebar-nav-icon'></i>$langmenu32</a>
			<ul>
				<li><a href='admin.php?mod=user' class='$thisuser'>$langmenu32</a></li>
			</ul>
		</li>
	</ul>";
	}
}
?>