<?php
//Author  	= 'Jenuar Dwi Putra Dalapang';
//Contact 	= 'mailto:djenuar@gmail.com';
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-comment/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1>Comment Management</h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li>View, approve and delete comment management</li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2>Comment Management</h2></div>
		<p>Comments can be adjusted with two buttons below. If a user comment will appear directly without approved so press the button "Without Approved" and then vice versa.</p>
		<form method="post" action="<?=$aksi;?>">
			<input type="hidden" name="mod" value="comment">
			<input type="hidden" name="act" value="setting1">
			<button class="btn btn-sm btn-primary pull-left" type="submit" style="margin-right:10px;"><i class="fa fa-comment-o"></i> Without Approved</button>
		</form>
		<form method="post" action="<?=$aksi;?>">
			<input type="hidden" name="mod" value="comment">
			<input type="hidden" name="act" value="setting2">
			<button class="btn btn-sm btn-primary pull-left" type="submit"><i class="fa fa-comment"></i> Must Be Approved</button>
		</form>
		<p>&nbsp;</p>
		<div class="table-responsive">
			<form method="post" action="<?=$aksi;?>">
				<input type="hidden" name="mod" value="comment">
				<input type="hidden" name="act" value="multidelete">
				<input type="hidden" value="0" name="totaldata" id="totaldata">
				<table cellpadding="0" cellspacing="0" border="0" class="dTableAjax table table-vcenter table-condensed table-bordered" id="dynamic">
					<thead><tr>
						<th style="width:80px;" class="text-center"><i class="fa fa-check-circle-o"></i></th>
						<th>Id Data</th>
						<th>Post</th>
						<th>Sender</th>
						<th>Email</th>
						<th>Url</th>
						<th>Date, Time</th>
						<th>Approve</th>
						<th>Action</th>
					</tr></thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<td style="width:80px;" class="text-center"><input type="checkbox" id="titleCheck" data-toggle="tooltip" title="<?=$langaction5;?>" /></td>
							<td colspan="8">
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
					<h3 id="modal-title">View Comment</h3>
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
						<input type="hidden" name="mod" value="comment">
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
}
}
?>