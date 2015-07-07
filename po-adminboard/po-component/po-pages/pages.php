<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-pages/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1><?=$langpages1;?></h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li><?=$langpages2;?></li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2><?=$langcategory1;?></h2></div>
		<div class="table-responsive">
			<form method="post" action="<?=$aksi;?>">
				<input type="hidden" name="mod" value="pages">
				<input type="hidden" name="act" value="multidelete">
				<input type="hidden" value="0" name="totaldata" id="totaldata">
				<table cellpadding="0" cellspacing="0" border="0" class="dTableAjax table table-vcenter table-condensed table-bordered" id="dynamic">
					<thead><tr>
						<th style="width:80px;" class="text-center"><i class="fa fa-check-circle-o"></i></th>
						<th>Id Data</th>
						<th><?=$langpages3;?> | Link</th>
						<th><?=$langpages5;?></th>
						<th><?=$langpages6;?></th>
						</tr></thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<td style="width:80px;" class="text-center"><input type="checkbox" id="titleCheck" data-toggle="tooltip" title="<?=$langaction5;?>" /></td>
							<td colspan="5">
								<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#alertalldel"><i class="fa fa-trash-o"></i> Delete Selected Item</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</form>
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
						<input type="hidden" name="mod" value="pages">
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
    $permastr = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $permastrlink = preg_replace("/\/po-adminboard\/(admin\.php$)/","",$permastr);
?>
	<div class="block full">
		<div class="block-title"><h2>Add New</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="pages">
				<input type="hidden" name="act" value="input">
				<div class="form-group">
					<label>Title <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="title" name="title" required>
				</div>
                <div class="form-group">
					<label>SEO Title <span class="text-danger">*</span></label>
                    <div class="pull-right text-danger" style="font-style:italic;">Permalink : <?=$permastrlink;?>/pages/<span id="permalink"></span></div>
					<input class="form-control" type="text" id="seotitle" name="seotitle" required>
				</div>
				<div class="form-group">
					<label>Content <span class="text-danger">*</span></label>
                    <div class="row" style="margin-top:-30px;">
						<div class="col-md-12">
							<div class="pull-right">
								<div class="input-group">
									<span class="btn-group">
										<a class="btn btn-sm btn-default" id="tiny-visual">Visual</a>
										<a class="btn btn-sm btn-default" id="tiny-text">Text</a>
									</span>
								</div>
							</div>
						</div>
					</div>
					<textarea class="form-control" id="po-wysiwyg" name="content" style="height:500px;" required></textarea>
				</div>
				<div class="form-group">
					<label>Image</label>
					<div class="col-md-6 input-group">
						<input class="form-control" type="text" id="picture" name="picture">
						<span class="input-group-btn">
							<a href="js/plugins/filemanager/dialog.php?type=1&field_id=picture" class="btn btn-success" id="browse-file">Browse</a>
						</span>
					</div>
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
	$valid = $val->validasi($_GET['id'],'sql');
	$table = new PoTable('pages');
	$currentPages = $table->findBy(id_pages, $valid);
	$currentPages = $currentPages->current();
	if ($currentPages == '0'){
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
	<p style="width:100%; height:500px;">&nbsp;</p>
<?php
	}else{
	$dutf = html_entity_decode($currentPages->content);
    $permastr = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $permastrlink = preg_replace("/\/po-adminboard\/(admin\.php$)/","",$permastr);
?>
	<div class="block full">
		<div class="block-title"><h2>Edit Pages</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="pages">
				<input type="hidden" name="act" value="update">
				<input type="hidden" name="id" value="<?=$currentPages->id_pages;?>">
				<div class="form-group">
					<label>Title <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="title" name="title" value="<?=$currentPages->title;?>" required>
				</div>
                <div class="form-group">
					<label>SEO Title <span class="text-danger">*</span></label>
                    <div class="pull-right text-danger" style="font-style:italic;">Permalink : <?=$permastrlink;?>/pages/<span id="permalink"><?=$currentPages->seotitle;?></span></div>
					<input class="form-control" type="text" id="seotitle" name="seotitle" value="<?=$currentPages->seotitle;?>" required>
				</div>
				<div class="form-group">
					<label>Content <span class="text-danger">*</span></label>
                    <div class="row" style="margin-top:-30px;">
						<div class="col-md-12">
							<div class="pull-right">
								<div class="input-group">
									<span class="btn-group">
										<a class="btn btn-sm btn-default" id="tiny-visual">Visual</a>
										<a class="btn btn-sm btn-default" id="tiny-text">Text</a>
									</span>
								</div>
							</div>
						</div>
					</div>
					<textarea class="form-control" id="po-wysiwyg" name="content" style="height:500px;" required><?=$dutf;?></textarea>
				</div>
				<div class="form-group" id="image-box">
					<div class="row">
						<?php if ($currentPages->picture==''){ ?>
							<div class="col-md-3"><label>No Image Selected</label></div>
							<div class="col-md-9">
								<a data-toggle="lightbox-image" href="data:image/gif;base64,R0lGODdhyACWAOMAAO/v76qqqubm5t3d3bu7u7KystXV1cPDw8zMzAAAAAAAAAAAAAAAAAAAAAAAAAAAACwAAAAAyACWAAAE/hDISau9OOvNu/9gKI5kaZ5oqq5s675wLM90bd94ru987//AoHBILBqPyKRyyWw6n9CodEqtWq/YrHbL7Xq/4LB4TC6bz+i0es1uu9/wuHxOr9vv+Lx+z+/7/4CBgoOEhYaHiImKi4yNjo+QkZKTlJWWl5iZmpucnZ6foKGio6SlpqeoqaqrrK2ur7CxsrO0tba3TAMFBQO4LAUBAQW+K8DCxCoGu73IzSUCwQECAwQBBAIVCMAFCBrRxwDQwQLKvOHV1xbUwQfYEwIHwO3BBBTawu2BA9HGwcMT1b7Vw/Dt3z563xAIrHCQnzsAAf0F6ybhwDdwgAx8OxDQgASN/sKUBWNmwQDIfwBAThRoMYDHCRYJGAhI8eRMf+4OFrgZgCKgaB4PHqg4EoBQbxgBROtlrJu4ofYm0JMQkJk/mOMkTA10Vas1CcakJrXQ1eu/sF4HWhB3NphYlNsmxOWKsWtZtASTdsVb1mhEu3UDX3RLFyVguITzolQKji/GhgXNvhU7OICgsoflJr7Qd2/isgEPGGAruTTjnSZTXw7c1rJpznobf2Y9GYBjxIsJYQbXstfRDJ1luz6t2TDvosSJSpMw4GXG3TtT+hPpEoPJ6R89B7AaUrnolgWwnUQQEKVOAy199mlonPDfr3m/GeUHFjBhAf0SUh28+P12QOIIgDbcPdwgJV+Arf0jnwTwsHOQT/Hs1BcABObjDAcTXhiCOGppKAJI6nnIwQGiKZSViB2YqB+KHtxjjXMsxijjjDTWaOONOOao44489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSW6UsEADs=">No Existing Image Preview</a>
								<p><i>Please upload image type must be jpg and if the image is not replaced, do not choose any option below.</i></p>
							</div>
						<?php }else{ ?>
							<div class="col-md-3"><label>Image Selected</label></div>
							<div class="col-md-9">
								<a data-toggle="lightbox-image" href="../po-content/po-upload/<?=$currentPages->picture;?>">Existing Image Preview</a>
								<p>
                                    <i>Please upload image type must be jpg and if the image is not replaced, do not choose any option below.</i>
                                    <button type="button" class="btn btn-xs btn-danger pull-right del-image" id="<?=$currentPages->id_pages;?>"><i class="fa fa-trash-o"></i></button>
                                </p>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label>Image</label>
					<div class="col-md-6 input-group">
						<input class="form-control" type="text" id="picture" name="picture">
						<span class="input-group-btn">
							<a href="js/plugins/filemanager/dialog.php?type=1&field_id=picture" class="btn btn-success" id="browse-file">Browse</a>
						</span>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<?php if ($currentPages->active=="N"){ ?>
							<label class="col-md-2">Active</label>
							<div class="col-md-10">
								<label class="radio-inline"><input type="radio" id="active1" name="active" value="Y">Y</label>
								<label class="radio-inline"><input type="radio" id="active2" name="active" value="N" checked="checked">N</label>
							</div>
						<?php }else{ ?>
							<label class="col-md-2">Active</label>
							<div class="col-md-10">
								<label class="radio-inline"><input type="radio" id="active1" name="active" value="Y" checked="checked">Y</label>
								<label class="radio-inline"><input type="radio" id="active2" name="active" value="N">N</label>
							</div>
						<?php } ?>
						<p>&nbsp;</p>
					</div>
				</div>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
            </fieldset>
		</form>
	</div>
    <div id="alertdelimg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=$langdelete1;?></h3>
					</div>
					<div class="modal-body">
						<?=$langdelete2;?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-danger btn-del-image" id=""><i class="fa fa-trash-o"></i> <?=$langdelete3;?></button>
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> <?=$langdelete4;?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<p style="width:100%; height:100px;">&nbsp;</p>
<?php
	}
    break;
}
}
?>