<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-theme/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1><?=$langtheme1;?></h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li><?=$langtheme2;?></li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2><?=$langtheme1;?></h2></div>
		<div class="row">
		<?php
			$tabletheme = new PoTable('theme');
			$themes = $tabletheme->findAll(id_theme, DESC);
			$jml_kolom = 2;
			$cnt = 0;
			$tableroleaccess = new PoTable('user_role');
			$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, 'theme');
			$currentRoleAccess = $currentRoleAccess->current();
				foreach($themes as $theme){
					$cnt++;
					if($currentRoleAccess->delete_access == "Y"){
						$tbldelete = "<a class='btn btn-sm btn-alt btn-danger alertdel' id='$theme->id_theme' data-toggle='tooltip' title='$langtheme5'><i class='fa fa-times'></i></a>";
					}
					echo "<div class='col-sm-4 block-section text-center' id='del$theme->id_theme'>
						<h4 class='sub-header'>$theme->title</h4>
						<div class='gallery-image'>
							<img src='../po-content/$theme->folder/preview.jpg' alt='' style='width:100%;'>
							<div class='gallery-image-options'>
								<form method='post' action='$aksi' autocomplete='off'>
									<input type='hidden' name='mod' value='theme'>
									<input type='hidden' name='act' value='active'>
									<input type='hidden' name='id' value='$theme->id_theme'>";
										if ($theme->active=='Y'){
											echo "<input type='hidden' name='active' value='N'>
											<a href='admin.php?mod=theme&act=edit&id=header.php' class='btn btn-sm btn-alt btn-primary' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>&nbsp;
											<button class='btn btn-sm btn-alt btn-success' type='submit' title='$langtheme6'><i class='fa fa-eye-slash'></i></button>&nbsp;&nbsp;";
										}else{
											echo "<input type='hidden' name='active' value='Y'>
											<button class='btn btn-sm btn-alt btn-success' type='submit' title='$langtheme7'><i class='fa fa-eye'></i></button>&nbsp;&nbsp;";
										}
								echo "$tbldelete
								</form>
							</div>
						</div>
						<h5>By $theme->author</h5>
					</div>";
				}
		?>
		</div>
	</div>
	<div id="alertdel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=$langdelete1;?></h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="theme">
						<input type="hidden" name="act" value="delete">
						<input type="hidden" id="delid" name="id">
						<?=$langdelete2;?>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> <?=$langdelete3;?></button>
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> <?=$langdelete4;?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<p style="width:100%; height:150px;">&nbsp;</p>
<?php
    break;

	case "addnew":
?>
	<div class="block full">
		<div class="block-title"><h2>Add New</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" enctype="multipart/form-data" autocomplete="off">
			<fieldset>
				<input type="hidden" name="mod" value="theme">
				<input type="hidden" name="act" value="input">
				<div class="form-group">
					<label>Title <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="title" name="title" required>
				</div>
				<div class="form-group">
					<label>Author <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="author" name="author" required>
				</div>
				<div class="form-group">
					<label>Folder <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="folder" name="folder" required>
				</div>
				<div class="form-group">
					<label>Please select theme <i>(.zip)</i> <span class="text-danger">*</span></label>
					<input id="fileInput" name="fupload" type="file" /><br />
					<p><i>* Please empty the box if you can create one blank theme.</i></p>
				</div>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
            </fieldset>
		</form>
	</div>
	<p style="width:100%; height:100px;">&nbsp;</p>
<?php
    break;

	case "edit":
	$table = new PoTable('theme');
	$currentTheme = $table->findBy(active, 'Y');
	$currentTheme = $currentTheme->current();
	$valid = $val->validasi($_GET['id'],'xss');
	$filename = "../po-content/$currentTheme->folder/$valid";
	if (file_exists("$filename")){
	$fh = fopen($filename, "r") or die("Could not open file!");
	$data = fread($fh, filesize($filename)) or die("Could not read file!");
	$data = str_replace("textarea", "textareapopojicms", $data);
	fclose($fh);
?>
	<style type="text/css">
		.CodeMirror { height: 800px; }
		.CodeMirror-matchingtag { background: #4d4d4d; }
		.breakpoints { width: .8em; }
		.breakpoint { color: #3498db; }
    </style>
	<div class="block full">
		<div class="block-title">
			<h2><?php echo "$langtheme8 - $currentTheme->title <i>(File $valid)</i>"; ?> <small><?=$langtheme9;?></small></h2>
			<div class="block-options pull-right">
				<div class="btn-group btn-group-sm">
					<a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default dropdown-toggle enable-tooltip" data-toggle="dropdown" title="Options"><span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
					<?php
					$str = rtrim($_SERVER['DOCUMENT_ROOT'], '/').$_SERVER['PHP_SELF'];
					$strlink = preg_replace("/\/po-adminboard\/(admin\.php$)/","",$str);
					$folderpath = "$strlink/po-content/$currentTheme->folder/";
						if ($handle = opendir($folderpath)) {
							while (false !== ($file = readdir($handle))) {
								if ($file != "." && $file != "..") {
									$filename = substr($file, 0);
									$pecah = explode(".", $filename);
									$ekstensi = $pecah[1];
									if ($ekstensi!='' AND $ekstensi!='jpg' AND $filename!='index.html'){
										echo "<li><a href='?mod=theme&act=edit&id=$filename'><i class='fa fa-cog pull-right'></i>$filename</a></li>";
									}else{ }
								}
							}
						}
						closedir($handle);
					?>
					</ul>
				</div>
			</div>
		</div>
		<form method="post" action="<?=$aksi;?>" enctype="multipart/form-data" autocomplete="off">
			<input type="hidden" name="mod" value="theme">
			<input type="hidden" name="act" value="edit">
			<input type="hidden" name="folder" value="<?=$currentTheme->folder;?>">
			<input type="hidden" name="file" value="<?=$valid;?>">
			<textarea name="code_content" id="pocodemirror" style="width:100%; height:800px;"><?=$data;?></textarea>
			<p>&nbsp;</p>
			<fieldset>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="block full">
		<div class="block-title"><h2>Editor Shortcut Key</h2></div>
		<ul class="fa-ul">
			<li><i class="fa fa-pencil fa-li"></i> Put the cursor on or inside a pair of tags to highlight them. Press <strong>Ctrl+J</strong> to jump to the tag that matches the one under the cursor.</li>
			<li><i class="fa fa-pencil fa-li"></i> Click the line-number gutter to add or remove <i>breakpoints</i>.</li>
			<li><i class="fa fa-pencil fa-li"></i> Press <strong>F11</strong> when cursor is in the editor to toggle full screen editing. <strong>Esc</strong> can also be used to <i>exit</i> full screen editing.</li>
			<li><i class="fa fa-pencil fa-li"></i> Press <strong>Ctrl+Space</strong> to activate completion.</li>
			<li><i class="fa fa-pencil fa-li"></i> Demonstration of primitive search/replace functionality. The keybindings (which can be overridden by custom keymaps) are :
				<ul>
					<li><strong>Ctrl+F / Cmd-F</strong> for Start searching</li>
					<li><strong>Ctrl+G / Cmd+G</strong> for Find next</li>
					<li><strong>Shift+Ctrl+G / Shift+Cmd+G</strong> for Find previous</li>
					<li><strong>Shift+Ctrl+F / Cmd+Option+F</strong> for Replace</li>
					<li><strong>Shift+Ctrl+R / Shift+Cmd+Option+F</strong> for Replace all</li>
				</ul>
			</li>
		</ul>
	</div>
	<div id="helper-box" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title">Helper Element</h3>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close Helper</button>
				</div>
			</div>
		</div>
	</div>
<?php
	}else{
?>
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
			<a href="<?=$siteurl;?>" title="Back to the website" class="btn btn-sm btn-primary"><?=$langpagenotfound2;?></a>
		</p>
		<p>&nbsp;</p>
	</div>
	<p style="width:100%; height:250px;">&nbsp;</p>
<?php
	}
    break;
}
}
?>