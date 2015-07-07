<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-component/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1><?=$langcomponent1;?></h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li><?=$langcomponent2;?></li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2><?=$langcomponent1;?></h2></div>
		<div class="table-responsive">
		<?php
			$tablecomponent = new PoTable('component');
			$components = $tablecomponent->findAll(id_component, DESC);
			echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-vcenter table-condensed table-bordered' id='table-datatable'>
				<thead><tr>
					<th>Id Data</th>
					<th>$langcomponent3</th>
					<th>$langcomponent4</th>
					<th>$langcomponent5</th>
					<th>$langcomponent6</th>
				</tr></thead><tbody>"; 
				$no=1;
				$tableroleaccess = new PoTable('user_role');
				$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, 'component');
				$currentRoleAccess = $currentRoleAccess->current();
				foreach($components as $component){
				$pecahurl = explode("-", $component->component);
				$url = $pecahurl[1];
				if($currentRoleAccess->delete_access == "Y"){
					$tbldelete = "<a class='btn btn-xs btn-danger alertdel' id='$component->id_component' data-toggle='tooltip' title='$langaction2'><i class='fa fa-times'></i></a>";
				}
					echo "<tr>
						<td>$component->id_component</td>
						<td>$component->component</td>
						<td>$component->date</td>
						<td>$component->table_name</td>
						<td class='text-center'>
							<div class='btn-group btn-group-xs'>
								<a href='admin.php?mod=$url' class='btn btn-xs btn-default' data-toggle='tooltip' title='$langaction3'><i class='fa fa-pencil-square-o'></i></a>
								<a href='?mod=component&act=importtable&id=$component->id_component' class='btn btn-xs btn-default' data-toggle='tooltip' title='$langaction4'><i class='fa fa-sign-out'></i></a>
								$tbldelete
							</div>
						</td>
					</tr>";
				$no++;
				}
			echo "</tbody></table>";
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
						<input type="hidden" name="mod" value="component">
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
	<p style="width:100%; height:350px;">&nbsp;</p>
<?php
    break;

	case "addnew":
	if ($_SESSION[leveluser]=='1'){
?>
	<div class="block full">
		<div class="block-title"><h2>Add New</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" enctype="multipart/form-data" autocomplete="off">
			<fieldset>
				<input type="hidden" name="mod" value="component">
				<input type="hidden" name="act" value="input">
				<div class="form-group">
					<label>Component Name <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="component" name="component" required>
				</div>
				<div class="form-group">
					<label>Table Name</label>
					<input class="form-control" type="text" id="table_name" name="table_name">
				</div>
				<div class="form-group">
					<label>Please select component <i>(.zip)</i> <span class="text-danger">*</span></label>
					<input id="fileInput" name="fupload" type="file" required>
				</div>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
            </fieldset>
		</form>
	</div>
	<div class="block full">
		<div class="block-title"><h2><?=$langcomponent15;?></h2></div>
		<ul class="fa-ul">
			<li><i class="fa fa-pencil fa-li"></i> <?=$langcomponent7;?><br /><i><?=$langcomponent8;?></i></li>
			<li><i class="fa fa-pencil fa-li"></i> <?=$langcomponent9;?></li>
			<li><i class="fa fa-pencil fa-li"></i> <?=$langcomponent10;?></li>
			<li><i class="fa fa-pencil fa-li"></i> <?=$langcomponent11;?></li>
		</ul>
	</div>
	<p style="width:100%; height:150px;">&nbsp;</p>
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

	case "importtable":
	if ($_SESSION[leveluser]=='1'){
?>
	<div class="block full">
		<div class="block-title"><h2>Import Table</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" enctype="multipart/form-data" autocomplete="off">
			<fieldset>
				<input type="hidden" name="mod" value="component">
				<input type="hidden" name="act" value="importtable">
				<div class="form-group">
					<label>Please select sql file <i>(.sql)</i> <span class="text-danger">*</span></label>
					<input id="fileInput" name="fupload" type="file" required>
				</div>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
            </fieldset>
		</form>
	</div>
	<div class="block full">
		<div class="block-title"><h2><?=$langcomponent15;?></h2></div>
		<ul class="fa-ul">
			<li><i class="fa fa-pencil fa-li"></i> <?=$langcomponent12;?></li>
			<li><i class="fa fa-pencil fa-li"></i> <?=$langcomponent13;?></li>
			<li><i class="fa fa-pencil fa-li"></i> <?=$langcomponent14;?></li>
		</ul>
	</div>
	<p style="width:100%; height:350px;">&nbsp;</p>
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