<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-user/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1><?=$languser1;?></h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li><?=$languser2;?></li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title">
			<h2><?=$languser1;?></h2>
			<?php if ($_SESSION[leveluser]=='1'){ ?>
			<div class="block-options pull-right">
				<a href="admin.php?mod=user&act=userlevel" class="btn btn-sm btn-primary" title="User Level"><i class="fa fa-user"></i> User Level</a>
				<a href="admin.php?mod=user&act=userrole" class="btn btn-sm btn-success" title="User Role"><i class="fa fa-user"></i> User Role</a>
			</div>
			<?php } ?>
		</div>
		<div class="table-responsive">
		<?php
			if ($_SESSION[leveluser]=='1'){
		?>
			<table cellpadding="0" cellspacing="0" border="0" class="dTableAjax table table-vcenter table-condensed table-bordered" id="dynamic">
				<thead><tr>
					<th>Id Data</th>
					<th><?=$languser3;?></th>
					<th><?=$languser4;?></th>
					<th><?=$languser5;?></th>
					<th><?=$languser6;?></th>
					<th><?=$languser7;?></th>
				</tr></thead>
				<tbody></tbody>
			</table>
		<?php
			}else{
				$tableuser = new PoTable('users');
				$currentUser = $tableuser->findBy(username, $_SESSION['namauser']);
				$currentUser = $currentUser->current();
				$tablelevel = new PoTable('user_level');
				$currentLevel = $tablelevel->findBy(id_level, $currentUser->level);
				$currentLevel = $currentLevel->current();
			?>
				<div class="row">
					<div class="col-md-4">
						<div class="widget">
							<div class="widget-advanced">
								<div class="widget-header text-center themed-background-dark">
									<h3 class="widget-content-light">
									<span class="themed-color"><?=$currentUser->nama_lengkap;?></span>
									<small>- <?=$currentUser->username;?></small>
									</h3>
								</div>
								<div class="widget-main" style="border-left:1px solid #EAEDF1;border-right:1px solid #EAEDF1;border-bottom:1px solid #EAEDF1;">
									<a href="#" class="widget-image-container animation-hatch">
									<?php
										$filename = "../po-content/po-upload/user-$_SESSION[iduser].jpg";
										if (file_exists("$filename")){
											echo "<img src='../po-content/po-upload/user-$_SESSION[iduser].jpg' class='widget-image img-circle' alt='avatar' width='30' height='30' />";
										}else{
											echo "<img src='../po-content/po-upload/user-editor.jpg' class='widget-image img-circle' alt='avatar' width='30' height='30' />";
										}
									?>
									</a>
									<div class="row text-center animation-fadeIn">
										<div class="col-xs-6">
											<h3>
												<?php
													$tableposts = new PoTable("post");
													$numposts = $tableposts->numRowBy(editor, $currentUser->id_user);
												?>
												<strong><?=$numposts;?></strong>
												<small>Post</small>
											</h3>
										</div>
										<div class="col-xs-6">
											<h3>
												<strong><?=$currentUser->id_user;?></strong>
												<small>User Id</small>
											</h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="block">
							<div class="block-title">
								<div class="block-options pull-right">
									<a href="?mod=user&act=edit&id=<?=$currentUser->id_session;?>" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="<?=$langaction1;?>"><i class="fa fa-pencil"></i></a>
								</div>
								<h2>About <strong>You</strong></h2>
							</div>
							<table class="table table-borderless table-striped">
								<tbody>
									<tr>
										<td style="width: 20%;"><strong>Biografi</strong></td>
										<td><?=$currentUser->bio;?></td>
									</tr>
									<tr>
										<td><strong>Email</strong></td>
										<td><?=$currentUser->email;?></td>
									</tr>
									<tr>
										<td><strong>Telphone</strong></td>
										<td><?=$currentUser->no_telp;?></td>
									</tr>
									<tr>
										<td><strong>Member From</strong></td>
										<td><?=$currentUser->tgl_daftar;?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php
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
						<input type="hidden" name="mod" value="user">
						<input type="hidden" name="act" value="deleteuser">
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
	<p style="width:100%; height:300px;">&nbsp;</p>
<?php
    break;

	case "userlevel":
?>
	<?php if ($_SESSION[leveluser]=='1'){ ?>
	<div class="block full">
		<div class="block-title">
			<h2>User Level</h2>
			<div class="block-options pull-right">
				<a href="#tblnew" class="btn btn-sm btn-primary" title="Add New" data-toggle="modal"><i class="fa fa-user"></i> Add New</a>
				<a href="admin.php?mod=user" class="btn btn-sm btn-default" title="Back to user"><i class="fa fa-reply"></i> Back to User</a>
			</div>
		</div>
		<div class="table-responsive">
		<?php
			$tableuserlevel = new PoTable('user_level');
			$userlevels = $tableuserlevel->findAll('', '');
			echo "<table cellpadding='0' cellspacing='0' border='0' class='dTableAjax2 table table-vcenter table-condensed table-bordered' id='dynamic'>
				<thead><tr>
					<th>Level</th>
					<th>$languser7</th>
				</tr></thead><tbody>"; 
				$no=1;
				foreach($userlevels as $userlevel){
					echo "<tr>
						<td>$userlevel->level</td>
						<td class='text-center'>
							<div class='btn-group btn-group-xs'>
								<a href='#tbledit$userlevel->id_level' id='$userlevel->id_level' class='btn btn-xs btn-default' data-toggle='modal' title='$langaction1'><i class='fa fa-pencil'></i></a>";
								if ($userlevel->id_level == "1" OR $userlevel->id_level == "2" OR $userlevel->id_level == "3"){
								}else{
								echo "<a class='btn btn-xs btn-danger alertdelu' id='$userlevel->id_level' data-toggle='tooltip' title='Delete'><i class='fa fa-times'></i></a>";
								}
							echo "</div>
						</td>
					</tr>";
					?>
					<div id="tbledit<?=$userlevel->id_level;?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h3 class="modal-title">Edit User Level</h3>
									</div>
									<div class="modal-body">
										<input type="hidden" name="mod" value="user">
										<input type="hidden" name="act" value="edituserlevel">
										<input type="hidden" name="id" value="<?=$userlevel->id_level;?>">
										<div class="form-group">
											<label>Level</label>
											<input class="form-control" type="text" id="title" name="title" value="<?=$userlevel->level;?>" required>
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
	<!-- Dialog content -->
	<div id="tblnew" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">Add User Level</h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="user">
						<input type="hidden" name="act" value="adduserlevel">
						<div class="form-group">
							<label>Level</label>
							<input class="form-control" type="text" id="title" name="title" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="alertdelu" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=$langdelete1;?></h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="user">
						<input type="hidden" name="act" value="deleteuserlevel">
						<input type="hidden" id="delidu" name="id">
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
	<p style="width:100%; height:300px;">&nbsp;</p>
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

	case "userrole":
?>
	<?php if ($_SESSION[leveluser]=='1'){ ?>
	<div class="block full">
		<div class="block-title">
			<h2>User Role</h2>
			<div class="block-options pull-right">
				<a href="#tblnew" class="btn btn-sm btn-primary" title="Add New" data-toggle="modal"><i class="fa fa-user"></i> Add New</a>
				<a href="admin.php?mod=user" class="btn btn-sm btn-default" title="Back to user"><i class="fa fa-reply"></i> Back to User</a>
			</div>
		</div>
		<div class="table-responsive">
		<?php
			$tableuserrole = new PoTable('user_role');
			$userroles = $tableuserrole->findAll('', '');
			echo "<table cellpadding='0' cellspacing='0' border='0' class='dTableAjax2 table table-vcenter table-condensed table-bordered' id='dynamic'>
				<thead><tr>
					<th>No</th>
					<th>Level Name</th>
					<th>Module</th>
					<th>Read</th>
					<th>Write</th>
					<th>Modify</th>
					<th>Delete</th>
					<th>$languser7</th>
				</tr></thead><tbody>"; 
				$no=1;
				foreach($userroles as $userrole){
					$tablelevel = new PoTable('user_level');
					$currentLevel = $tablelevel->findBy(id_level, $userrole->id_level);
					$currentLevel = $currentLevel->current();
					echo "<tr>
						<td>$no</td>
						<td>$currentLevel->level</td>
						<td>$userrole->module</td>
						<td>$userrole->read_access</td>
						<td>$userrole->write_access</td>
						<td>$userrole->modify_access</td>
						<td>$userrole->delete_access</td>
						<td class='text-center'>
							<div class='btn-group btn-group-xs'>
								<a href='#tbledit$userrole->id_role' id='$userrole->id_role' class='btn btn-xs btn-default' data-toggle='modal' title='$langaction1'><i class='fa fa-pencil'></i></a>
								<a class='btn btn-xs btn-danger alertdelu' id='$userrole->id_role' data-toggle='tooltip' title='Delete'><i class='fa fa-times'></i></a>
							</div>
						</td>
					</tr>";
					?>
					<div id="tbledit<?=$userrole->id_role;?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h3 class="modal-title">Edit User Role</h3>
									</div>
									<div class="modal-body">
										<input type="hidden" name="mod" value="user">
										<input type="hidden" name="act" value="edituserrole">
										<input type="hidden" name="id" value="<?=$userrole->id_role;?>">
										<div class="form-group">
											<label>Level</label>
											<select class="select-chosen-no-search" name="level" style="width:280px;" data-placeholder="Choose Level">
												<?php
													$tableselevel = new PoTable('user_level');
													$sellevels = $tableselevel->findBy(id_level, $userrole->id_level);
													$sellevels = $sellevels->current();
													echo "<option value='$sellevels->id_level'>$sellevels->level</option>";
													$tablelevels = new PoTable('user_level');
													$levels = $tablelevels->findNotAll(id_level, $userrole->id_level);
													foreach($levels as $level){
														echo "<option value='$level->id_level'>$level->level</option>";
													}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>Module <span class="text-danger">*</span></label>
											<input class="form-control" type="text" id="title" name="title" value="<?=$userrole->module;?>" required>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Read <span class="text-danger">*</span></label>
													<select class="select-chosen-no-search" name="read_access" style="width:280px;">
														<?php
															$read_access_a = ($userrole->read_access != 'Y') ? $read_access = 'selected=selected' : $read_access = '';
														?>
														<option value="Y" <?=$read_access;?>>Y</option>
														<option value="N" <?=$read_access;?>>N</option>
													</select>
												</div>
												<div class="form-group">
													<label>Write <span class="text-danger">*</span></label>
													<select class="select-chosen-no-search" name="write_access" style="width:280px;">
														<?php
															$write_access_a = ($userrole->write_access != 'Y') ? $write_access = 'selected=selected' : $write_access = '';
														?>
														<option value="Y" <?=$write_access;?>>Y</option>
														<option value="N" <?=$write_access;?>>N</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Modify <span class="text-danger">*</span></label>
													<select class="select-chosen-no-search" name="modify_access" style="width:280px;">
														<?php
															$modify_access_a = ($userrole->modify_access != 'Y') ? $modify_access = 'selected=selected' : $modify_access = '';
														?>
														<option value="Y" <?=$modify_access;?>>Y</option>
														<option value="N" <?=$modify_access;?>>N</option>
													</select>
												</div>
												<div class="form-group">
													<label>Delete <span class="text-danger">*</span></label>
													<select class="select-chosen-no-search" name="delete_access" style="width:280px;">
														<?php
															$delete_access_a = ($userrole->delete_access != 'Y') ? $delete_access = 'selected=selected' : $delete_access = '';
														?>
														<option value="Y" <?=$delete_access;?>>Y</option>
														<option value="N" <?=$delete_access;?>>N</option>
													</select>
												</div>
											</div>
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
	<!-- Dialog content -->
	<div id="tblnew" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">Add User Role</h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="user">
						<input type="hidden" name="act" value="adduserrole">
						<div class="form-group">
							<label>Level <span class="text-danger">*</span></label>
							<select class="select-chosen-no-search" name="level" style="width:280px;" data-placeholder="Choose Level">
							<?php
								$tablelevel = new PoTable("user_level");
								$levels = $tablelevel->findAll(id_level, ASC);
								foreach($levels as $level){
									echo "<option value='$level->id_level'>$level->level</option>";
								}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Module <span class="text-danger">*</span></label>
							<input class="form-control" type="text" id="title" name="title" required>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Read <span class="text-danger">*</span></label>
									<select class="select-chosen-no-search" name="read_access" style="width:280px;">
										<option value="Y">Y</option>
										<option value="N">N</option>
									</select>
								</div>
								<div class="form-group">
									<label>Write <span class="text-danger">*</span></label>
									<select class="select-chosen-no-search" name="write_access" style="width:280px;">
										<option value="Y">Y</option>
										<option value="N">N</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Modify <span class="text-danger">*</span></label>
									<select class="select-chosen-no-search" name="modify_access" style="width:280px;">
										<option value="Y">Y</option>
										<option value="N">N</option>
									</select>
								</div>
								<div class="form-group">
									<label>Delete <span class="text-danger">*</span></label>
									<select class="select-chosen-no-search" name="delete_access" style="width:280px;">
										<option value="Y">Y</option>
										<option value="N">N</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="alertdelu" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?=$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=$langdelete1;?></h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="user">
						<input type="hidden" name="act" value="deleteuserrole">
						<input type="hidden" id="delidu" name="id">
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
	<p style="width:100%; height:300px;">&nbsp;</p>
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

	case "addnew":
    if ($_SESSION[leveluser]=='1'){
?>
	<div class="block full">
		<div class="block-title"><h2>Add User</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" autocomplete="off">
			<fieldset>
				<input type="hidden" name="mod" value="user">
				<input type="hidden" name="act" value="input">
				<div class="form-group">
					<label>Username <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="username" name="username" required>
				</div>
				<div class="form-group">
					<label>Password <span class="text-danger">*</span></label>
					<input class="form-control" type="password" id="password" name="password" required>
				</div>
				<div class="form-group">
					<label>Repeat Password <span class="text-danger">*</span></label>
					<input class="form-control" type="password" id="repeatPass" name="repeatpass" required>
				</div>
				<div class="form-group">
					<label>Fullname <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="nama_lengkap" name="nama_lengkap" required>
				</div>
				<div class="form-group">
					<label>Email <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="email" name="email" required>
				</div>
				<div class="form-group">
					<label>Phone Number <span class="text-danger">*</span></label>
					<input class="form-control" type="text" id="no_telp" name="no_telp" required>
				</div>
				<div class="form-group">
					<label>Level <span class="text-danger">*</span></label>
					<select class="select-chosen-no-search" name="level" style="width:280px;" data-placeholder="Choose Level">
					<?php
						$tablelevel = new PoTable("user_level");
						$levels = $tablelevel->findAll(id_level, ASC);
						foreach($levels as $level){
							echo "<option value='$level->id_level'>$level->level</option>";
						}
					?>
					</select>
				</div>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
			</fieldset>
		</form>
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

	case "edit":
	$valid = $val->validasi($_GET['id'],'xss');
	$table = new PoTable('users');
	$currentUser = $table->findBy(id_session, $valid);
	$currentUser = $currentUser->current();
	$dutf=html_entity_decode($currentUser->bio);
	if ($currentUser == '0'){
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
	}else{
		if ($_SESSION[leveluser]=='1'){
?>
	<div class="block full">
		<div class="block-title"><h2>Edit User</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" enctype="multipart/form-data" autocomplete="off">
			<fieldset>
				<input type="hidden" name="id" value="<?=$currentUser->id_session;?>">
				<input type="hidden" name="iduser" value="<?=$currentUser->id_user;?>">
				<input type="hidden" name="blokir" value="<?=$currentUser->blokir;?>">
                <input type="hidden" name="locktype" id="locktype" value="<?=$currentUser->locktype;?>">
				<input type="hidden" name="mod" value="user">
				<input type="hidden" name="act" value="update">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" type="text" id="username" name="username" value="<?=$currentUser->username;?>" disabled>
                            <span class="help-block">Username can not be changed, except from direct database (phpmyadmin)</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <?php
                                if ($currentUser->locktype == "0") {
                            ?>
                            <div class="box-password">
                                <div class="input-group">
                                    <input class="form-control" type="password" id="newpassword" name="newpassword">
                                    <span class="input-group-btn">
                                        <button id="change-lock-type" class="btn btn-success" type="button"><i class="fa fa-gear"></i> Change Lock Type</button>
                                    </span>
                                </div>
                                <span class="help-block">If the password is not changed, just empty</span>
                            </div>
                            <div class="box-password-lock" style="display:none;">
                                <div class="input-group">
                                    <span class="btn-group">
                                        <button id="change-pattern" class="btn btn-warning" type="button"><i class="fa fa-barcode"></i> Change Pattern</button>
                                        <button id="change-lock-type-2" class="btn btn-success" type="button"><i class="fa fa-gear"></i> Change Lock Type</button>
                                    </span>
                                </div>
                                <div id="patternHolder"></div>
                                <span class="help-block">If the password is not changed, just ignore any options</span>
                            </div>
                            <?php } else { ?>
                            <div class="box-password" style="display:none;">
                                <div class="input-group">
                                    <input class="form-control" type="password" id="newpassword" name="newpassword">
                                    <span class="input-group-btn">
                                        <button id="change-lock-type" class="btn btn-success" type="button"><i class="fa fa-gear"></i> Change Lock Type</button>
                                    </span>
                                </div>
                                <span class="help-block">If the password is not changed, just empty</span>
                            </div>
                            <div class="box-password-lock">
                                <div class="input-group">
                                    <span class="btn-group">
                                        <button id="change-pattern" class="btn btn-warning" type="button"><i class="fa fa-barcode"></i> Change Pattern</button>
                                        <button id="change-lock-type-2" class="btn btn-success" type="button"><i class="fa fa-gear"></i> Change Lock Type</button>
                                    </span>
                                </div>
                                <div id="patternHolder"></div>
                                <span class="help-block">If the password is not changed, just ignore any options</span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fullname <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="nama_lengkap" name="nama_lengkap" value="<?=$currentUser->nama_lengkap;?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="email" name="email" value="<?=$currentUser->email;?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="no_telp" name="no_telp" value="<?=$currentUser->no_telp;?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Level</label>
                            <select class="select-chosen-no-search" name="level" style="width:280px;" data-placeholder="Choose Level">
                                <?php
                                    $tableselevel = new PoTable('user_level');
                                    $sellevels = $tableselevel->findBy(id_level, $currentUser->level);
                                    $sellevels = $sellevels->current();
                                    echo "<option value='$sellevels->id_level'>$sellevels->level</option>";
                                    $tablelevels = new PoTable('user_level');
                                    $levels = $tablelevels->findNotAll(id_level, $currentUser->level);
                                    foreach($levels as $level){
                                        echo "<option value='$level->id_level'>$level->level</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Bio</label>
                    <textarea class="form-control" rows="8" cols="" id="bio" name="bio"><?=$dutf;?></textarea>
                    <span class="help-block">Field limited to 600 characters.</span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>User Picture</label>
                            <input id="fileInput" name="fupload" type="file">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <?php if ($currentUser->blokir=="N"){ ?>
                                    <label class="col-md-12">Block</label>
                                    <div class="col-md-12">
                                        <label class="radio-inline"><input type="radio" id="blokir1" name="blokir" value="Y">Y</label>
                                        <label class="radio-inline"><input type="radio" id="blokir2" name="blokir" value="N" checked="checked">N</label>
                                    </div>
                                <?php }else{ ?>
                                    <label class="col-md-12">Block</label>
                                    <div class="col-md-12">
                                        <label class="radio-inline"><input type="radio" id="blokir1" name="blokir" value="Y" checked="checked">Y</label>
                                        <label class="radio-inline"><input type="radio" id="blokir2" name="blokir" value="N">N</label>
                                    </div>
                                <?php } ?>
                                <p style="height:35px;">&nbsp;</p>
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
<?php
		}else{
?>
	<div class="block full">
		<div class="block-title"><h2>Edit User</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=$aksi;?>" enctype="multipart/form-data" autocomplete="off">
			<fieldset>
				<input type="hidden" name="id" value="<?=$currentUser->id_session;?>">
				<input type="hidden" name="iduser" value="<?=$currentUser->id_user;?>">
				<input type="hidden" name="blokir" value="<?=$currentUser->blokir;?>">
                <input type="hidden" name="locktype" id="locktype" value="<?=$currentUser->locktype;?>">
				<input type="hidden" name="mod" value="user">
				<input type="hidden" name="act" value="update">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" type="text" id="username" name="username" value="<?=$currentUser->username;?>" disabled>
                            <span class="help-block">Username can not be changed, except from direct database (phpmyadmin)</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <?php
                                if ($currentUser->locktype == "0") {
                            ?>
                            <div class="box-password">
                                <div class="input-group">
                                    <input class="form-control" type="password" id="newpassword" name="newpassword">
                                    <span class="input-group-btn">
                                        <button id="change-lock-type" class="btn btn-success" type="button"><i class="fa fa-gear"></i> Change Lock Type</button>
                                    </span>
                                </div>
                                <span class="help-block">If the password is not changed, just empty</span>
                            </div>
                            <div class="box-password-lock" style="display:none;">
                                <div class="input-group">
                                    <span class="btn-group">
                                        <button id="change-pattern" class="btn btn-warning" type="button"><i class="fa fa-barcode"></i> Change Pattern</button>
                                        <button id="change-lock-type-2" class="btn btn-success" type="button"><i class="fa fa-gear"></i> Change Lock Type</button>
                                    </span>
                                </div>
                                <div id="patternHolder"></div>
                                <span class="help-block">If the password is not changed, just ignore any options</span>
                            </div>
                            <?php } else { ?>
                            <div class="box-password" style="display:none;">
                                <div class="input-group">
                                    <input class="form-control" type="password" id="newpassword" name="newpassword">
                                    <span class="input-group-btn">
                                        <button id="change-lock-type" class="btn btn-success" type="button"><i class="fa fa-gear"></i> Change Lock Type</button>
                                    </span>
                                </div>
                                <span class="help-block">If the password is not changed, just empty</span>
                            </div>
                            <div class="box-password-lock">
                                <div class="input-group">
                                    <span class="btn-group">
                                        <button id="change-pattern" class="btn btn-warning" type="button"><i class="fa fa-barcode"></i> Change Pattern</button>
                                        <button id="change-lock-type-2" class="btn btn-success" type="button"><i class="fa fa-gear"></i> Change Lock Type</button>
                                    </span>
                                </div>
                                <div id="patternHolder"></div>
                                <span class="help-block">If the password is not changed, just ignore any options</span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fullname <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="nama_lengkap" name="nama_lengkap" value="<?=$currentUser->nama_lengkap;?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="email" name="email" value="<?=$currentUser->email;?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="no_telp" name="no_telp" value="<?=$currentUser->no_telp;?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>User Picture</label>
                            <input id="fileInput" name="fupload" type="file">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Bio</label>
                    <textarea class="form-control" rows="8" cols="" id="bio" name="bio"><?=$dutf;?></textarea>
                    <span class="help-block">Field limited to 600 characters.</span>
                </div>
				<div class="form-group form-actions">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
					<button type="reset" class="btn btn-sm btn-danger pull-right" onclick="self.history.back()"><i class="fa fa-times"></i> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
<?php 
		}
	}
    break;  
}
}
?>