<?php
//Author  	= 'CompoGen';
//Contact 	= 'mailto:info@popojicms.org';
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-komunitas/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1>Komunitas Management</h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li>Add, update, delete Komunitas management</li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title">
            <h2>Komunitas Management</h2>
            <div class="block-options pull-right">
				<a href="admin.php?mod=komunitas&act=addnew" class="btn btn-sm btn-primary" title="Add New"><i class="fa fa-plus-square-o"></i> Add New</a>
			</div>
        </div>
		<div class="table-responsive">
			<form method="post" action="<?=$aksi;?>">
				<input type="hidden" name="mod" value="komunitas">
				<input type="hidden" name="act" value="multidelete">
				<input type="hidden" value="0" name="totaldata" id="totaldata">
				<table cellpadding="0" cellspacing="0" border="0" class="dTableAjax table table-vcenter table-condensed table-bordered" id="dynamic">
					<thead><tr>
						<th style="width:80px;" class="text-center"><i class="fa fa-check-circle-o"></i></th>
                        <th>Nama</th>
						<th>Kontak</th>
						<th>Skill</th>
						<th>Status</th>
                        <th>Action</th>
					</tr></thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<td style="width:80px;" class="text-center"><input type="checkbox" id="titleCheck" data-toggle="tooltip" title="<?=$langaction5;?>" /></td>
							<td colspan="11">
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
						<input type="hidden" name="mod" value="komunitas">
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

	<div id="setuju" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i>Konfirmasi Persetujuan</h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="komunitas">
						<input type="hidden" name="act" value="setuju">
						<input type="hidden" id="setujuid" name="id">
						Apakah Anda Yakin Menyetujui Data Ini
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Setuju</button>
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<p style="width:100%; height:350px;">&nbsp;</p>
<?php
    break;

	case "addnew":
?>
	<div class="block full">
		<div class="block-title"><h2>Add New</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="komunitas" />
				<input type="hidden" name="act" value="input" />
                        <div class="form-group">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="nama" name="nama" required />
                        </div>
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="alamat" name="alamat" required />
                        </div>
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="email" name="email" required />
                        </div>
                        <div class="form-group">
                            <label>Facebook <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="facebook" name="facebook" required />
                        </div>
                        <div class="form-group">
                            <label>Twitter <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="twitter" name="twitter" required />
                        </div>
                        <div class="form-group">
                            <label>Skill <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="skill" name="skill" required />
                        </div>
                        <div class="form-group">
                            <label>Lat <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="lat" name="lat" required />
                        </div>
                        <div class="form-group">
                            <label>Lng <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="lng" name="lng" required />
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="status" name="status" required />
                        </div>
                <div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
            </fieldset>
		</form>
	</div>
	<p style="width:100%; height:500px;">&nbsp;</p>
<?php
	break;

	case "setuju":
	$id = $val->validasi($_GET['id'],'xss');
	$tabledel = new PoTable('komunitas');
	$data = array(
		'status' => '1'
	);
	$table = new PoTable('komunitas');
	$table->updateBy('id_komunitas', $id, $data);
	//header('location:../../admin.php?mod='.$mod);
?>
<?php
	break;

	case "edit":
	$valid = $val->validasi($_GET['id'],'sql');
	$table = new PoTable('komunitas');
	$currentKomunitas = $table->findBy(id_komunitas, $valid);
	$currentKomunitas = $currentKomunitas->current();
	if ($currentKomunitas == '0'){
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
		<div class="block-title"><h2>Edit Komunitas</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="komunitas" />
				<input type="hidden" name="act" value="update" />
                <input type="hidden" name="id" value="<?=$currentKomunitas->id_komunitas;?>">
                        <div class="form-group">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="nama" name="nama" value="<?=$currentKomunitas->nama;?>" required />
                        </div>
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="alamat" name="alamat" value="<?=$currentKomunitas->alamat;?>" required />
                        </div>
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="email" name="email" value="<?=$currentKomunitas->email;?>" required />
                        </div>
                        <div class="form-group">
                            <label>Facebook <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="facebook" name="facebook" value="<?=$currentKomunitas->facebook;?>" required />
                        </div>
                        <div class="form-group">
                            <label>Twitter <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="twitter" name="twitter" value="<?=$currentKomunitas->twitter;?>" required />
                        </div>
                        <div class="form-group">
                            <label>Skill <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="skill" name="skill" value="<?=$currentKomunitas->skill;?>" required />
                        </div>
                        <div class="form-group">
                            <label>Lat <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="lat" name="lat" value="<?=$currentKomunitas->lat;?>" required />
                        </div>
                        <div class="form-group">
                            <label>Lng <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="lng" name="lng" value="<?=$currentKomunitas->lng;?>" required />
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="status" name="status" value="<?=$currentKomunitas->status;?>" required />
                        </div>
                <div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
            </fieldset>
		</form>
	</div>
	<p style="width:100%; height:450px;">&nbsp;</p>
<?php
	}
    break;
}
}
?>