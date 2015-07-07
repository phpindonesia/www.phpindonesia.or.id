<?php
//Author  	= 'Jenuar Dwi Putra Dalapang';
//Contact 	= 'mailto:djenuar@gmail.com';
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-contact/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1>Contact Management</h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li>View and delete contact management</li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2>Contact Management</h2></div>
		<div class="table-responsive">
			<form method="post" action="<?=$aksi;?>">
				<input type="hidden" name="mod" value="contact">
				<input type="hidden" name="act" value="multidelete">
				<input type="hidden" value="0" name="totaldata" id="totaldata">
				<table cellpadding="0" cellspacing="0" border="0" class="dTableAjax table table-vcenter table-condensed table-bordered" id="dynamic">
					<thead><tr>
						<th style="width:80px;" class="text-center"><i class="fa fa-check-circle-o"></i></th>
						<th>Id Data</th>
						<th>Sender Name</th>
						<th>Email</th>
						<th>Subjek</th>
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
	<div id="viewdata" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 id="modal-title">View Contact</h3>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> Close</button>
				</div>
			</div>
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
						<input type="hidden" name="mod" value="contact">
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
    <div id="alertreply" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 id="modal-title">Reply Contact</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="contact">
						<input type="hidden" name="act" value="reply">
                        <input type="hidden" id="name_contact" name="name_contact">
                        <input type="hidden" id="email_contact" name="email_contact">
						<div class="form-group" style="height:50px;">
							<label class="col-md-3 col-lg-2 control-label" for="subject" style="padding-top:8px;">Subject</label>
							<div class="col-md-9 col-lg-10">
								<input type="text" id="subjek_contact" name="subjek_contact" class="form-control" placeholder="Your subject.." />
							</div>
						</div>
						<div class="form-group" style="height:200px;">
							<label class="col-md-3 col-lg-2 control-label" for="content">Message</label>
							<div class="col-md-9 col-lg-10">
								<textarea id="message_contact" name="message_contact" class="form-control textarea-editor" placeholder="Your message.." style="width:100%; height:auto;"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-envelope-o"></i> Send</button>
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<p style="width:100%; height:350px;">&nbsp;</p>
<?php
    break;
}
}
?>