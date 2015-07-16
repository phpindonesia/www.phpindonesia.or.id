<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-event/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1>Manajemen Event</h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li>Tambah, ubah dan hapus manajemen event</li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2>Brute Add New</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off" enctype="multipart/form-data">
            <fieldset>
				<input type="hidden" name="mod" value="event">
				<input type="hidden" name="act" value="uploadgroupevent">
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label>Event File <span class="text-danger">*</span></label>
							<input type="file" id="eventfile" name="eventfile" required />
							<small>File Format : .txt, </small>
							<small>Example : <a href="<?php echo $site['con'].'event/phpindonesia-event-2014.txt'; ?>">phpindonesia-event-2014.txt</a></small>
						</div>
						<div class="col-md-6">
							<label>Color <span class="text-danger">*</span></label>
							<select class="select-chosen-no-search" name="color" style="width:280px;">
								<option value="#1BBAE1">default</option>
								<option value="#888">night</option>
								<option value="#AF64CC">amethyst</option>
								<option value="#46B7BF">modern</option>
								<option value="#E67E22">autumn</option>
								<option value="#1EC1B8">flatie</option>
								<option value="#27AE60">spring</option>
								<option value="#F31455">fancy</option>
								<option value="#E74C3C">fire</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<!-- <button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button> -->
				</div>
            </fieldset>
		</form>
	</div>
	<div class="block block-alt-noborder full">
		<div class="row">
			<div class="col-md-12">
				<div id="calendar"></div>
			</div>
		</div>
	</div>
	<p style="width:100%; height:50px;">&nbsp;</p>
<?php
    break;

	case "addnew":
	$start = $val->validasi($_GET['start'],'xss');
	$end = $val->validasi($_GET['end'],'xss');
	$allday = $val->validasi($_GET['allday'],'xss');
?>
	<div class="block full">
		<div class="block-title"><h2>Add New</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="event">
				<input type="hidden" name="act" value="input">
				<input type="hidden" name="start" value="<?=$start;?>">
				<input type="hidden" name="end" value="<?=$end;?>">
				<input type="hidden" name="allday" value="<?=$allday;?>">
				<div class="form-group">
					<label>Title <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="title" name="title" required>
				</div>
				<div class="form-group">
					<label>Content <span class="text-danger">*</span></label>
					<textarea class="form-control" id="po-wysiwyg" name="content" style="height:500px;" required></textarea>
				</div>
				<div class="form-group">
					<label>Color <span class="text-danger">*</span></label>
					<div class="row">
						<div class="col-md-6">
							<select class="select-chosen-no-search" name="color" style="width:280px;">
								<option value="#1BBAE1">default</option>
								<option value="#888">night</option>
								<option value="#AF64CC">amethyst</option>
								<option value="#46B7BF">modern</option>
								<option value="#E67E22">autumn</option>
								<option value="#1EC1B8">flatie</option>
								<option value="#27AE60">spring</option>
								<option value="#F31455">fancy</option>
								<option value="#E74C3C">fire</option>
							</select>
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
	<p style="width:100%; height:100px;">&nbsp;</p>
<?php
	break;

	case "edit":
	$valid = $val->validasi($_GET['id'],'sql');
	$table = new PoTable('event');
	$currentEvents = $table->findBy(id_event, $valid);
	$currentEvents = $currentEvents->current();
	if ($currentEvents == '0'){
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
	$dutf=html_entity_decode($currentEvents->content);
?>
	<div class="block full">
		<div class="block-title">
			<h2>Edit Pages</h2>
			<div class="block-options pull-right">
				<a href="#alertdel" class="btn btn-sm btn-danger" data-toggle="modal" title="Delete Event"><i class="fa fa-trash-o"></i> Delete This Event</a>
			</div>
		</div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="event">
				<input type="hidden" name="act" value="update">
				<input type="hidden" name="id" value="<?=$currentEvents->id_event;?>">
				<div class="form-group">
					<label>Title <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="title" name="title" value="<?=$currentEvents->title;?>" required>
				</div>
				<div class="form-group">
					<label>Content <span class="text-danger">*</span></label>
					<textarea class="form-control" id="po-wysiwyg" name="content" style="height:500px;" required><?=$dutf;?></textarea>
				</div>
				<div class="form-group">
					<label>Color <span class="text-danger">*</span></label>
					<div class="row">
						<div class="col-md-6">
							<select class="select-chosen-no-search" name="color" style="width:280px;">
								<option value="#1BBAE1">default</option>
								<option value="#888">night</option>
								<option value="#AF64CC">amethyst</option>
								<option value="#46B7BF">modern</option>
								<option value="#E67E22">autumn</option>
								<option value="#1EC1B8">flatie</option>
								<option value="#27AE60">spring</option>
								<option value="#F31455">fancy</option>
								<option value="#E74C3C">fire</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<?php if ($currentEvents->active=="N"){ ?>
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
	<div id="alertdel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=$langdelete1;?></h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="event">
						<input type="hidden" name="act" value="delete">
						<input type="hidden" name="id" value="<?=$currentEvents->id_event;?>">
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
	<p style="width:100%; height:100px;">&nbsp;</p>
<?php
	}
    break;
}
}
?>