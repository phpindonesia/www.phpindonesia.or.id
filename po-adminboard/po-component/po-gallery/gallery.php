<?php
//Author  	= 'Jenuar Dwi Putra Dalapang';
//Contact 	= 'mailto:djenuar@gmail.com';
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-gallery/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1>Gallery Management</h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li>Input, edit, view and delete gallery management</li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title">
			<h2>Gallery Management</h2>
			<div class="block-options pull-right">
				<a href="admin.php?mod=gallery&act=addnew" class="btn btn-sm btn-primary" title="Add New"><i class="fa fa-plus-square-o"></i> Add New</a>
				<a href="admin.php?mod=gallery&act=album" class="btn btn-sm btn-success" title="Album"><i class="fa fa-picture-o"></i> Album</a>
			</div>
		</div>
		<div class="table-responsive">
			<form method="post" action="<?=$aksi;?>">
				<input type="hidden" name="mod" value="gallery">
				<input type="hidden" name="act" value="multidelete">
				<input type="hidden" value="0" name="totaldata" id="totaldata">
				<table cellpadding="0" cellspacing="0" border="0" class="dTableAjax table table-vcenter table-condensed table-bordered" id="dynamic">
					<thead><tr>
						<th style="width:80px;" class="text-center"><i class="fa fa-check-circle-o"></i></th>
						<th>Id Data</th>
						<th>Album</th>
						<th>Title</th>
						<th>Preview</th>
						<th>Action</th>
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
						<input type="hidden" name="mod" value="gallery">
						<input type="hidden" name="act" value="deletegallery">
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
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="gallery">
				<input type="hidden" name="act" value="inputgallery">
				<?php
					$tablealbums = new PoTable('album');
					$albums = $tablealbums->findAll(id_album, DESC);
					$numalbums = $tablealbums->numRow();
					if ($numalbums > 0){
					echo "<div class='form-group'>
						<label>Album</label>
						<div class='row'>
							<div class='col-md-6'>
								<select class='select-chosen' name='id_album' style='width:280px;' data-placeholder='Choose a Album'>";
								foreach($albums as $album){
									echo "<option value='$album->id_album'>$album->title</option>";
								}
								echo "</select>
							</div>
							<div class='col-md-6'>
								<a href='#tbladdalbum' class='btn btn btn-success' data-toggle='modal'><i class='fa fa-plus-square-o'></i> Or Add New Album</a>
							</div>
						</div>
					</div>";
					}else{
					echo "<div class='form-group'>
						<div class='row'>
							<div class='col-md-2'>
								<label>Add New Album</label>
							</div>
							<div class='col-md-10'>
								<a href='#tbladdalbum' class='btn btn btn-success' data-toggle='modal'><i class='fa fa-plus-square-o'></i> Add New Album</a>
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
	<!-- Dialog content -->
	<div id="tbladdalbum" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">Add Album</h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="gallery">
						<input type="hidden" name="act" value="inputalbum">
						<input type="hidden" id="addalb" name="addalb" value="addnew">
						<div class="form-group">
							<label>Title</label>
							<input class="form-control"type="text" id="title" name="title" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<p style="width:100%; height:250px;">&nbsp;</p>
<?php
	break;


	case "edit":
	$valid = $val->validasi($_GET['id'],'sql');
	$table = new PoTable('gallery');
	$currentGallery = $table->findBy(id_gallery, $valid);
	$currentGallery = $currentGallery->current();

	if ($currentGallery == '0'){
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
?>
	<div class="block full">
		<div class="block-title"><h2>Edit Data</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="gallery">
				<input type="hidden" name="act" value="editgallery">
				<input type="hidden" name="id" value="<?=$currentGallery->id_gallery;?>">
				<?php
					$tableselcats = new PoTable('album');
					$selcats = $tableselcats->findBy(id_album, $currentGallery->id_album);
					$selcats = $selcats->current();
					$tablealbums = new PoTable('album');
					$albums = $tablealbums->findNotAll(id_album, $currentGallery->id_album);
					$numalbums = $tablealbums->numRow();
					if ($numalbums > 0){
					echo "<div class='form-group'>
						<label>Album</label>
						<div class='row'>
							<div class='col-md-6'>
								<select class='select-chosen' name='id_album' style='width:280px;' data-placeholder='Choose a Album'>
								<option value='$selcats->id_album'>$selcats->title</option>";
								foreach($albums as $album){
									echo "<option value='$album->id_album'>$album->title</option>";
								}
								echo "</select>
							</div>
							<div class='col-md-6'>
								<a href='#tbladdalbum' class='btn btn btn-success' data-toggle='modal'><i class='fa fa-plus-square-o'></i> Or Add New Album</a>
							</div>
						</div>
					</div>";
					}else{
					echo "<div class='form-group'>
						<div class='row'>
							<div class='col-md-2'>
								<label>Add New Album</label>
							</div>
							<div class='col-md-10'>
								<a href='#tbladdalbum' class='btn btn btn-success' data-toggle='modal'><i class='fa fa-plus-square-o'></i> Add New Album</a>
							</div>
						</div>
					</div>";
					}
				?>
				<div class="form-group">
					<label>Title <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="title" name="title" value="<?=$currentGallery->title;?>" required>
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
	<!-- Dialog content -->
	<div id="tbladdalbum" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">Add Album</h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="gallery">
						<input type="hidden" name="act" value="inputalbum">
						<input type="hidden" name="id" value="<?=$currentGallery->id_gallery;?>">
						<input type="hidden" id="addalb" name="addalb" value="addnew">
						<div class="form-group">
							<label>Title</label>
							<input class="form-control"type="text" id="title" name="title" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<p style="width:100%; height:250px;">&nbsp;</p>
<?php
	}
	break;


	case "album":
?>
	<div class="block full">
		<div class="block-title">
			<h2>Album Management</h2>
			<div class="block-options pull-right">
				<a href="admin.php?mod=gallery" class="btn btn-sm btn-default" title="Add New"><i class="fa fa-reply"></i> Back To Gallery</a>
			</div>
		</div>
		<div class="table-responsive">
			<?php
				$tablealbum = new PoTable('album');
				$albums = $tablealbum->findAll(id_album, DESC);
				echo "<table cellpadding='0' cellspacing='0' border='0' class='dTableAjax2 table table-vcenter table-condensed table-bordered' id='dynamic'>
						<thead><tr>
							<th>No</th>
							<th>Id Data</th>
							<th>Title</th>
							<th>Active</th>
							<th>Action</th>
						</tr></thead><tbody>";
						$no=1;
						foreach($albums as $album){
						echo "<tr class='gradeA' id='dela$album->id_album'>
							<td style='width:80px;'>$no</td>
							<td style='width:100px;'>$album->id_album</td>
							<td>$album->title</td>
							<td style='width:80px;' class='text-center'><span id='activespan$album->id_album'>$album->active</span></td>
							<td style='width:200px;'><div class='text-center'><div class='btn-group btn-group-xs'>
									<a class='btn btn-xs btn-default tblactive' id='$album->id_album' data-toggle='tooltip' title='Active'><i class='fa fa-eye'></i></a>
									<a href='#tbledit$album->id_album' class='btn btn-xs btn-default' id='$album->id_album' data-toggle='modal' title='Edit'><i class='fa fa-pencil'></i></a>
									<a class='btn btn-xs btn-danger alertdela' id='$album->id_album' data-toggle='tooltip' title='Delete'><i class='fa fa-times'></i></a>
								</div></div>
							</td>
						</tr>";
						?>
						<div id="tbledit<?=$album->id_album;?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h3 class="modal-title">Edit Album</h3>
										</div>
										<div class="modal-body">
											<input type="hidden" name="mod" value="gallery">
											<input type="hidden" name="act" value="editalbum">
											<input type="hidden" name="id" value="<?=$album->id_album;?>">
											<div class="form-group">
												<label>Title</label>
												<input class="form-control"type="text" id="title" name="title" value="<?=$album->title;?>" required>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<?php
						$no++;
						}
				echo "</tbody></table>";
			?>
		</div>
	</div>
	<div id="alertdela" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=$langdelete1;?></h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="gallery">
						<input type="hidden" name="act" value="deletealbum">
						<input type="hidden" id="delida" name="id">
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
}
}
?>