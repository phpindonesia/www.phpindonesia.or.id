<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-post/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1><?=$langpost1;?></h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li><?=$langpost2;?></li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2><?=$langpost1;?></h2></div>
		<div class="table-responsive">
			<form method="post" action="<?=$aksi;?>">
				<input type="hidden" name="mod" value="post">
				<input type="hidden" name="act" value="multidelete">
				<input type="hidden" value="0" name="totaldata" id="totaldata">
				<table cellpadding="0" cellspacing="0" border="0" class="dTableAjax table table-vcenter table-condensed table-bordered" id="dynamic">
					<thead><tr>
						<th style="width:80px;" class="text-center"><i class="fa fa-check-circle-o"></i></th>
						<th>Id Data</th>
						<th><?=$langpost3;?></th>
						<th><?=$langpost4;?> | Link</th>
						<th><?=$langpost7;?></th>
					<tbody></tbody>
					<tfoot>
						<tr>
							<td style="width:80px;" class="text-center"><input type="checkbox" id="titleCheck" data-toggle="tooltip" title="<?=$langaction5;?>" /></td>
							<td colspan="4">
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
						<input type="hidden" name="mod" value="post">
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
    $permastr = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $permastrlink = preg_replace("/\/po-adminboard\/(admin\.php$)/","",$permastr);
?>
	<div class="block full">
		<div class="block-title"><h2>Add New</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="post">
				<input type="hidden" name="act" value="input">
				<?php
					$tablecats = new PoTable("category");
					$cats = $tablecats->findAll(id_category, ASC);
					$numcats = $tablecats->numRow();
					if ($numcats > 0){
						echo "<div class='form-group'>
							<label>Category</label>
							<div class='row'>
								<div class='col-md-6' id='selectcatdata'>
									<select class='select-chosen' name='id_category' style='width:280px;' data-placeholder='Choose a Category'>";
									foreach($cats as $cat){
										echo "<option value='$cat->id_category'>$cat->title</option>";
									}
									echo "</select>
								</div>
								<div class='col-md-6'>
									<a href='javascript:void(0);' id='tbladdcat' class='btn btn btn-success'><i class='fa fa-plus-square-o'></i> Or Add New Category</a>
								</div>
							</div>
						</div>";
					}else{
						echo "<div class='form-group'>
							<label>Add New Category</label>
							<div class='row'>
								<div class='col-md-6' id='selectcatdata'>
									<select class='select-chosen' name='id_category' style='width:280px;' data-placeholder='Choose a Category'>";
									foreach($cats as $cat){
										echo "<option value='$cat->id_category'>$cat->title</option>";
									}
									echo "</select>
								</div>
								<div class='col-md-6'>
									<a href='javascript:void(0);' id='tbladdcat' class='btn btn btn-success'><i class='fa fa-plus-square-o'></i> Add New Category</a>
								</div>
							</div>
						</div>";
					}
				?>
				<div class="form-group">
					<label>Title <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="title" name="title" required>
				</div>
                <div class="form-group">
					<label>SEO Title <span class="text-danger">*</span></label>
                    <div class="pull-right text-danger" style="font-style:italic;">Permalink : <?=$permastrlink;?>/detailpost/<span id="permalink"></span></div>
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
				<?php
					$tabletag = new PoTable("tag");
					$tags = $tabletag->findAll(id_tag, DESC);
					$numtags = $tabletag->numRow();
					if ($numtags > 0){
						echo "<div class='form-group'>
							<label>Tags</label>
							<div class='row'>
								<div class='col-md-8' id='selecttagdata'>
									<select class='select-chosen' name='tag[]' multiple='' data-placeholder='Your Tags'>";
									foreach($tags as $tag){
										echo "<option value='$tag->tag_seo'>$tag->tag_title</option>";
									}
									echo "</select>
								</div>
								<div class='col-md-4'>
									<a href='javascript:void(0);' id='tbladdtag' class='btn btn btn-success'><i class='fa fa-plus-square-o'></i> Or Add New Tags</a>
								</div>
							</div>
						</div>";
					}else{
						echo "<div class='form-group'>
							<label>Add New Tags</label>
							<div class='row'>
								<div class='col-md-8' id='selecttagdata'>
									<select class='select-chosen' name='tag[]' multiple='' data-placeholder='Your Tags'>";
									foreach($tags as $tag){
										echo "<option value='$tag->tag_seo'>$tag->tag_title</option>";
									}
									echo "</select>
								</div>
								<div class='col-md-4'>
									<a href='javascript:void(0);' id='tbladdtag' class='btn btn btn-success'><i class='fa fa-plus-square-o'></i> Add New Tags</a>
								</div>
							</div>
						</div>";
					}
				?>
				<div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image</label>
                            <div class="col-md-12 input-group">
                                <input class="form-control" type="text" id="picture" name="picture">
                                <span class="input-group-btn">
                                    <a href="js/plugins/filemanager/dialog.php?type=1&field_id=picture" class="btn btn-success" id="browse-file">Browse</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Publish Date<span class="text-danger">*</span></label>
                            <input type="text" id="publishdate" name="publishdate" class="form-control input-datepicker-close masked_date" data-date-format="yyyy-mm-dd" value="<?=$tgl_sekarang;?>" placeholder="yyyy-mm-dd" required />
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="form-group">
                            <label>Publish Time<span class="text-danger">*</span></label>
							<div class="input-group bootstrap-timepicker">
								<input type="text" id="publishtime" name="publishtime" class="form-control input-timepicker24" value="<?=$jam_sekarang;?>" placeholder="hh:mm:ss" required />
								<span class="input-group-btn"><a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a></span>
							</div>
                        </div>
                    </div>
                </div>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
            </fieldset>
		</form>
	</div>
	<!-- Dialog content -->
	<div id="modaladdext" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="form-validation" class="addnewext" method="post" action="#" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title"></h3>
					</div>
					<div class="modal-body">
						<input type="hidden" id="mod" name="mod" value="post">
						<input type="hidden" id="act" name="act" value="">
						<div class="form-group">
							<label id="labelmodal"></label>
							<div id="titlebox"><input type="text" id="title" name="title" class="form-control" required></div>
							<div id="tagbox"><input type="text" id="tag" name="tag" class="input-tags" required><p><i>Can input more than one tag (,)</i></p></div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnsubmitext" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<p style="width:100%; height:100px;">&nbsp;</p>
<?php
	break;

	case "edit":
	$valid = $val->validasi($_GET['id'],'sql');
	$table = new PoTable('post');
	if ($_SESSION[leveluser]=='1'){
		$currentPosts = $table->findBy(id_post, $valid);
	}else{
		$currentPosts = $table->findByAnd(id_post, $valid, editor, $_SESSION['iduser']);
	}
	$currentPosts = $currentPosts->current();
	if ($currentPosts == '0'){
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
	$dutf=html_entity_decode($currentPosts->content);
    $permastr = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $permastrlink = preg_replace("/\/po-adminboard\/(admin\.php$)/","",$permastr);
?>
	<div class="block full">
		<div class="block-title"><h2>Edit Post</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="post">
				<input type="hidden" name="act" value="update">
				<input type="hidden" name="id" value="<?=$currentPosts->id_post;?>">
				<?php
					$tableselcats = new PoTable('category');
					$selcats = $tableselcats->findBy(id_category, $currentPosts->id_category);
					$selcats = $selcats->current();
					$tablecats = new PoTable('category');
					$cats = $tablecats->findNotAll(id_category, $currentPosts->id_category);
					$numcats = $tablecats->numRow();
					if ($numcats > 0){
						echo "<div class='form-group'>
							<label>Category</label>
							<div class='row'>
								<div class='col-md-6' id='selectcatdata'>
									<select class='select-chosen' name='id_category' style='width:280px;' data-placeholder='Choose a Category'>
									<option value='$selcats->id_category'>$selcats->title</option>";
									foreach($cats as $cat){
										echo "<option value='$cat->id_category'>$cat->title</option>";
									}
									echo "</select>
								</div>
								<div class='col-md-6'>
									<a href='javascript:void(0);' id='tbladdcat' class='btn btn btn-success'><i class='fa fa-plus-square-o'></i> Or Add New Category</a>
								</div>
							</div>
						</div>";
					}else{
						echo "<div class='form-group'>
							<label>Add New Category</label>
							<div class='row'>
								<div class='col-md-6' id='selectcatdata'>
									<select class='select-chosen' name='id_category' style='width:280px;' data-placeholder='Choose a Category'>
									<option value='$selcats->id_category'>$selcats->title</option>";
									foreach($cats as $cat){
										echo "<option value='$cat->id_category'>$cat->title</option>";
									}
									echo "</select>
								</div>
								<div class='col-md-6'>
									<a href='javascript:void(0);' id='tbladdcat' class='btn btn btn-success'><i class='fa fa-plus-square-o'></i> Add New Category</a>
								</div>
							</div>
						</div>";
					}
				?>
				<div class="form-group">
					<label>Title <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="title" name="title" value="<?=$currentPosts->title;?>" required>
				</div>
                <div class="form-group">
					<label>SEO Title <span class="text-danger">*</span></label>
                    <div class="pull-right text-danger" style="font-style:italic;">Permalink : <?=$permastrlink;?>/detailpost/<span id="permalink"><?=$currentPosts->seotitle;?></span></div>
					<input class="form-control" type="text" id="seotitle" name="seotitle" value="<?=$currentPosts->seotitle;?>" required>
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
				<?php
					$tabletag = new PoTable("tag");
					$tags = $tabletag->findAll(id_tag, DESC);
					$numtags = $tabletag->numRow();
					if ($numtags > 0){
						echo "<div class='form-group'>
							<label>Tags</label>
							<div class='row'>
								<div class='col-md-8' id='selecttagdata'>";
									function GetCheckboxes($tagging){
										$tabletag = new PoTable("tag");
										$tags = $tabletag->findAll(id_tag, DESC);
										$_arrNilai = explode(',', $tagging);
										$str = '';
										foreach($tags as $tag){
											$_ck = (array_search($tag->tag_seo, $_arrNilai) === false)? '' : 'selected=selected';
											$str .= "<option value='$tag->tag_seo' $_ck>$tag->tag_title</option>";
										}
										return $str;
									}
									$d = GetCheckboxes($currentPosts->tag);
									echo "<select class='select-chosen' name='tag[]' multiple='' data-placeholder='Your Tags'>$d</select>";
								echo "</div>
								<div class='col-md-4'>
									<a href='javascript:void(0);' id='tbladdtag' class='btn btn btn-success'><i class='fa fa-plus-square-o'></i> Or Add New Tags</a>
								</div>
							</div>
						</div>";
					}else{
						echo "<div class='form-group'>
							<label>Add New Tags</label>
							<div class='row'>
								<div class='col-md-8' id='selecttagdata'>";
									function GetCheckboxes($tagging){
										$tabletag = new PoTable("tag");
										$tags = $tabletag->findAll(id_tag, DESC);
										$_arrNilai = explode(',', $tagging);
										$str = '';
										foreach($tags as $tag){
											$_ck = (array_search($tag->tag_seo, $_arrNilai) === false)? '' : 'selected=selected';
											$str .= "<option value='$tag->tag_seo' $_ck>$tag->tag_title</option>";
										}
										return $str;
									}
									$d = GetCheckboxes($currentPosts->tag);
									echo "<select class='select-chosen' name='tag[]' multiple='' data-placeholder='Your Tags'>$d</select>";
								echo "</div>
								<div class='col-md-4'>
									<a href='javascript:void(0);' id='tbladdtag' class='btn btn btn-success'><i class='fa fa-plus-square-o'></i> Add New Tags</a>
								</div>
							</div>
						</div>";
					}
				?>
				<div class="form-group" id="image-box">
					<div class="row">
						<?php if ($currentPosts->picture==''){ ?>
							<div class="col-md-3"><label>No Image Selected</label></div>
							<div class="col-md-9">
								<a data-toggle="lightbox-image" href="data:image/gif;base64,R0lGODdhyACWAOMAAO/v76qqqubm5t3d3bu7u7KystXV1cPDw8zMzAAAAAAAAAAAAAAAAAAAAAAAAAAAACwAAAAAyACWAAAE/hDISau9OOvNu/9gKI5kaZ5oqq5s675wLM90bd94ru987//AoHBILBqPyKRyyWw6n9CodEqtWq/YrHbL7Xq/4LB4TC6bz+i0es1uu9/wuHxOr9vv+Lx+z+/7/4CBgoOEhYaHiImKi4yNjo+QkZKTlJWWl5iZmpucnZ6foKGio6SlpqeoqaqrrK2ur7CxsrO0tba3TAMFBQO4LAUBAQW+K8DCxCoGu73IzSUCwQECAwQBBAIVCMAFCBrRxwDQwQLKvOHV1xbUwQfYEwIHwO3BBBTawu2BA9HGwcMT1b7Vw/Dt3z563xAIrHCQnzsAAf0F6ybhwDdwgAx8OxDQgASN/sKUBWNmwQDIfwBAThRoMYDHCRYJGAhI8eRMf+4OFrgZgCKgaB4PHqg4EoBQbxgBROtlrJu4ofYm0JMQkJk/mOMkTA10Vas1CcakJrXQ1eu/sF4HWhB3NphYlNsmxOWKsWtZtASTdsVb1mhEu3UDX3RLFyVguITzolQKji/GhgXNvhU7OICgsoflJr7Qd2/isgEPGGAruTTjnSZTXw7c1rJpznobf2Y9GYBjxIsJYQbXstfRDJ1luz6t2TDvosSJSpMw4GXG3TtT+hPpEoPJ6R89B7AaUrnolgWwnUQQEKVOAy199mlonPDfr3m/GeUHFjBhAf0SUh28+P12QOIIgDbcPdwgJV+Arf0jnwTwsHOQT/Hs1BcABObjDAcTXhiCOGppKAJI6nnIwQGiKZSViB2YqB+KHtxjjXMsxijjjDTWaOONOOao44489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSW6UsEADs=">No Existing Image Preview</a>
								<p><i>Please upload image type must be jpg and if the image is not replaced, do not choose any option below.</i></p>
							</div>
						<?php }else{ ?>
							<div class="col-md-3"><label>Image Selected</label></div>
							<div class="col-md-9">
								<a data-toggle="lightbox-image" href="../po-content/po-upload/<?=$currentPosts->picture;?>">Existing Image Preview</a>
								<p>
                                    <i>Please upload image type must be jpg and if the image is not replaced, do not choose any option below.</i>
                                    <button type="button" class="btn btn-xs btn-danger pull-right del-image" id="<?=$currentPosts->id_post;?>"><i class="fa fa-trash-o"></i></button>
                                </p>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image</label>
                            <div class="col-md-12 input-group">
                                <input class="form-control" type="text" id="picture" name="picture">
                                <span class="input-group-btn">
                                    <a href="js/plugins/filemanager/dialog.php?type=1&field_id=picture" class="btn btn-success" id="browse-file">Browse</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Publish Date<span class="text-danger">*</span></label>
                            <input type="text" id="publishdate" name="publishdate" class="form-control input-datepicker-close masked_date" data-date-format="yyyy-mm-dd" value="<?=$currentPosts->date;?>" placeholder="yyyy-mm-dd" required />
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="form-group">
                            <label>Publish Time<span class="text-danger">*</span></label>
							<div class="input-group bootstrap-timepicker">
								<input type="text" id="publishtime" name="publishtime" class="form-control input-timepicker24" value="<?=$currentPosts->time;?>" placeholder="hh:mm:ss" required />
								<span class="input-group-btn"><a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a></span>
							</div>
                        </div>
                    </div>
                </div>
				<?php if ($_SESSION[leveluser]=='1' OR $_SESSION[leveluser]=='2'){ ?>
				<div class="form-group">
					<div class="row">
						<?php if ($currentPosts->active=="N"){ ?>
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
				<?php } ?>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
            </fieldset>
		</form>
	</div>
	<!-- Dialog content -->
	<div id="modaladdext" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="form-validation" class="addnewext" method="post" action="#" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title"></h3>
					</div>
					<div class="modal-body">
						<input type="hidden" id="mod" name="mod" value="post">
						<input type="hidden" id="act" name="act" value="">
						<div class="form-group">
							<label id="labelmodal"></label>
							<div id="titlebox"><input type="text" id="title" name="title" class="form-control" required></div>
							<div id="tagbox"><input type="text" id="tag" name="tag" class="input-tags" required><p><i>Can input more than one tag (,)</i></p></div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnsubmitext" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
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