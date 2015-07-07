<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
$aksi="po-component/po-setting/proses.php";

$availableAdTheme = array("amethyst", "autumn", "fancy", "fire", "flatie", "modern", "night", "spring");
$localAdTheme = $_COOKIE['Popoji_CMS_AdTheme'];

function getAvailableAdTheme(){
	$outt = "";
	while(list($key,$adThemeId) = each($GLOBALS['availableAdTheme'])){
		$adThemeLib = ($GLOBALS['adThemeTranslated'][$adThemeId])? $GLOBALS['adThemeTranslated'][$adThemeId] : $adThemeId;
		$outt .= '<option value="'.$adThemeId.'"'.(($GLOBALS['localAdTheme']==$adThemeId)? ' selected="selected"' : '' ).'>'.$adThemeLib.'</option>'."\n";
	}
	return $outt;
}
?>
	<div class="content-header">
		<div class="header-section"><h1><?=$langsetting1;?></h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li><?=$langsetting2;?></li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2><?=$langsetting1;?> <small><?=$langsetting10;?></small></h2></div>
		<?php
			$tablesetting = new PoTable('setting');
			$currentSetting = $tablesetting->findBy(id_setting, '1');
			$currentSetting = $currentSetting->current();
		?>
		<div class="table-responsive">
			<table class="table table-vcenter" cellpadding="0" cellspacing="0">
				<thead><tr><th style="width:20%;"><?=$langsetting3;?></th><th><?=$langsetting4;?></th></tr></thead>
				<tbody>
				<tr>
					<td><?=$langsetting5;?></td>
					<td>
						<div id="setting1" style="cursor:pointer;"><?=$currentSetting->website_name;?></div>
						<div class="form-group" id="settinginput1" style="display:none;">
							<div class="input-group">
								<input class="form-control" id="settingtext1" type="text" value="<?=$currentSetting->website_name;?>">
								<span class="input-group-btn">
									<button id="settingbtn1" class="btn btn-primary" type="button"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
								</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting6;?></td>
					<td>
						<div id="setting2" style="cursor:pointer;"><?=$currentSetting->website_url;?></div>
						<div class="form-group" id="settinginput2" style="display:none;">
							<div class="input-group">
								<input class="form-control" id="settingtext2" type="text" value="<?=$currentSetting->website_url;?>">
								<span class="input-group-btn">
									<button id="settingbtn2" class="btn btn-primary" type="button"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
								</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting7;?></td>
					<td>
						<div id="setting3" style="cursor:pointer;"><?=$currentSetting->meta_description;?></div>
						<div class="form-group" id="settinginput3" style="display:none;">
							<textarea class="form-control" id="settingtext3"><?=$currentSetting->meta_description;?></textarea>
							<button id="settingbtn3" class="btn btn-primary" type="button"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
						</div>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting8;?></td>
					<td>
						<div id="setting4" style="cursor:pointer;"><?=$currentSetting->meta_keyword;?></div>
						<div class="form-group" id="settinginput4" style="display:none;">
							<textarea class="form-control" id="settingtext4"><?=$currentSetting->meta_keyword;?></textarea>
							<button id="settingbtn4" class="btn btn-primary" type="button"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
						</div>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting9;?></td>
					<td>
						<div id="setting5" style="cursor:pointer;"><img src="../<?=$currentSetting->favicon;?>" /></div>
						<form method="post" action="<?=$aksi;?>" enctype="multipart/form-data" autocomplete="off">
							<input type="hidden" name="mod" value="setting">
							<input type="hidden" name="act" value="favicon">
							<div class="form-group" id="settinginput5" style="display:none; border:none;">
								<input class="fileInput" id="fileInput" name="fupload" type="file" required>
								<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
							</div>
						</form>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting24;?></td>
					<td>
						<div id="setting6" style="cursor:pointer;"><?=$currentSetting->website_email;?></div>
						<div class="form-group" id="settinginput6" style="display:none;">
							<div class="input-group">
								<input class="form-control" id="settingtext6" type="text" value="<?=$currentSetting->website_email;?>">
								<span class="input-group-btn">
									<button id="settingbtn6" class="btn btn-primary" type="button"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
								</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting13;?></td>
					<td>
						<form action="<?=$aksi;?>" method="post">
							<div class="form-group">
								<input type="hidden" name="mod" value="setting">
								<input type="hidden" name="act" value="adtheme">
								<select class="select-chosen" name="adtheme" onChange="submit()"><?=getAvailableAdTheme();?></select>
							</div>
						</form>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting14;?></td>
					<td>
						<?=$langsetting15;?> : <?=$currentSetting->timezone;?><br />
						<?=$langsetting16;?> : <?php echo "$thn_sekarang-$bln_sekarang-$tgl_skrg & $jam_sekarang"; ?><br /><br />
						<?=$langsetting11;?> :
						<form action="<?=$aksi;?>" method="post">
							<div class="form-group">
								<input type="hidden" name="mod" value="setting">
								<input type="hidden" name="act" value="timezone">
								<select id="example-chosen" class="select-chosen" name="timezone" onChange="submit()">
									<?php
										$timezoneList = timezoneList();
										foreach ($timezoneList as $value => $label) {
											echo "<option value='$value'>$label</option>";
										}
									?>
								</select>
							</div>
						</form>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting18;?></td>
					<td>
						<?php
							$statusmaintenance = ($currentSetting->website_maintenance == 'Y') ? $langsetting19 : $langsetting20;
						?>
						<div id="setting7" style="cursor:pointer;"><?=$statusmaintenance;?></div>
						<div class="form-group" id="settinginput7" style="display:none;">
							<div class="row">
								<div class="col-md-2">
									<select id="select7" class="form-control">
										<option value="Y"><?=$langsetting19;?></option>
										<option value="N"><?=$langsetting20;?></option>
									</select>
								</div>
								<div class="col-md-4">
									<div class="input-group">
										<input class="form-control input-datepicker-close" id="settingtext7" type="text" value="<?=$currentSetting->website_maintenance_tgl;?>" data-date-format="mm-dd-yyyy" placeholder="mm-dd-yyyy">
										<span class="input-group-btn">
											<button id="settingbtn7" class="btn btn-primary" type="button"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
										</span>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting21;?></td>
					<td>
						<?php
							$statuscache = ($currentSetting->website_cache == 'Y') ? $langsetting19 : $langsetting20;
						?>
						<div id="setting8" style="cursor:pointer;"><?=$statuscache;?></div>
						<div class="form-group" id="settinginput8" style="display:none;">
							<div class="row">
								<div class="col-md-2">
									<select id="select8" class="form-control">
										<option value="Y"><?=$langsetting19;?></option>
										<option value="N"><?=$langsetting20;?></option>
									</select>
								</div>
								<div class="col-md-4">
									<div class="input-group">
										<select id="settingtext8" class="form-control">
											<option value="60">1 <?=$langsetting22;?></option>
											<option value="180">3 <?=$langsetting22;?></option>
											<option value="300">5 <?=$langsetting22;?></option>
											<option value="1440">1 <?=$langsetting23;?></option>
											<option value="14400">10 <?=$langsetting23;?></option>
											<option value="43200">30 <?=$langsetting23;?></option>
										</select>
										<span class="input-group-btn">
											<button id="settingbtn8" class="btn btn-primary" type="button"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
										</span>
									</div>
								</div>
								<div class="col-md-6">
									<form method="post" action="<?=$aksi;?>" autocomplete="off">
										<input type="hidden" name="mod" value="setting">
										<input type="hidden" name="act" value="delcache">
										<div class="form-group">
											<button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> <?=$langsetting25;?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td><?=$langsetting26;?></td>
					<td>
						<?php
							$statusmember = ($currentSetting->member_register == 'Y') ? $langsetting19 : $langsetting20;
						?>
						<div id="setting9" style="cursor:pointer;"><?=$statusmember;?></div>
						<div class="form-group" id="settinginput9" style="display:none;">
							<div class="row">
								<div class="col-md-4">
									<div class="input-group">
										<select id="select9" class="form-control">
											<option value="Y"><?=$langsetting19;?></option>
											<option value="N"><?=$langsetting20;?></option>
										</select>
										<span class="input-group-btn">
											<button id="settingbtn9" class="btn btn-primary" type="button"><i class="fa fa-check"></i> <?=$langsetting11;?></button>
										</span>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
                <tr>
					<td>Sitemap</td>
					<td>
                        <form class="form-inline" action="<?=$aksi;?>" method="post">
                            <input type="hidden" name="mod" value="setting">
				            <input type="hidden" name="act" value="sitemap">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Change Frequency</div>
                                    <select class="form-control" name="changefreq">
                                        <option value="" selected="">None</option>
                                        <option value="always">Always</option>
                                        <option value="hourly">Hourly</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                        <option value="never">Never</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Priority</div>
                                    <select class="form-control" name="priority">
                                        <option value="0.1" selected="">0.1</option>
                                        <option value="0.2">0.2</option>
                                        <option value="0.3">0.3</option>
                                        <option value="0.4">0.4</option>
                                        <option value="0.5">0.5</option>
                                        <option value="0.6">0.6</option>
                                        <option value="0.7">0.7</option>
                                        <option value="0.8">0.8</option>
                                        <option value="0.9">0.9</option>
                                        <option value="1.0">1.0</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" value="Generate Sitemap" />
                            </div>
                        </form>
                    </td>
                </tr>
			</tbody></table>
		</div>
	</div>
	<div class="block full">
		<div class="block-title">
			<h2>PopojiCMSOAuth - Facebook Connect</h2>
			<div class="block-options pull-right"><a class="btn btn-sm btn-default" href="https://developers.facebook.com/docs/web/tutorials/scrumptious/register-facebook-application/" target="_blank"><?=$langsetting17;?></a></div>
		</div>
		<?php
			$tableoauthfb = new PoTable('oauth');
			$currentOauthfb = $tableoauthfb->findBy(id_oauth, '1');
			$currentOauthfb = $currentOauthfb->current();
		?>
		<div class="table-responsive">
			<table class="table table-vcenter" cellpadding="0" cellspacing="0">
				<thead><tr><th style="width:20%;"><?=$langsetting3;?></th><th><?=$langsetting4;?></th></tr></thead>
				<tbody>
				<tr>
					<td>Facebook App Id</td>
					<td><?=$currentOauthfb->oauth_key;?></td>
				</tr>
				<tr>
					<td>Facebook App Secret</td>
					<td><?=$currentOauthfb->oauth_secret;?></td>
				</tr>
				<tr>
					<td>Facebook Id</td>
					<td><?=$currentOauthfb->oauth_id;?></td>
				</tr>
				<tr>
					<td>Facebook User</td>
					<td><?=$currentOauthfb->oauth_user;?></td>
				</tr>
				<tr>
					<td>Facebook Type</td>
					<td><?=$currentOauthfb->oauth_fbtype;?></td>
				</tr>
				<tr>
					<td colspan="2">
						<form method="post" action="<?=$aksi;?>" autocomplete="off">
							<input type="hidden" name="mod" value="setting">
							<input type="hidden" name="act" value="deloauthfb">
							<a href="#tbleditoauthfb" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fa fa-pencil"></i> Edit App Connect</a>
							<a class="btn btn-sm btn-primary" href="po-component/po-oauth/facebook/index.php"><i class="fa fa-facebook"></i> New Or Renew OAuth</a>
							<button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-times"></i> Delete OAuth</button>
						</form>
					</td>
				</tr>
			</tbody></table>
		</div>
		<!-- Dialog content -->
		<div id="tbleditoauthfb" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title">Edit App Connect</h3>
						</div>
						<div class="modal-body">
							<input type="hidden" name="mod" value="setting">
							<input type="hidden" name="act" value="editoauthfb">
							<div class="form-group">
								<label>Facebook App Id</label>
								<input class="form-control" type="text" id="oauth_key" name="oauth_key" value="<?=$currentOauthfb->oauth_key;?>" required>
							</div>
							<div class="form-group">
								<label>Facebook App Secret</label>
								<input class="form-control" type="text" id="oauth_secret" name="oauth_secret" value="<?=$currentOauthfb->oauth_secret;?>" required>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="block full">
		<div class="block-title">
			<h2>PopojiCMSOAuth - Twitter Connect</h2>
			<div class="block-options pull-right"><a class="btn btn-sm btn-default" href="http://iag.me/socialmedia/how-to-create-a-twitter-app-in-8-easy-steps/" target="_blank"><?=$langsetting17;?></a></div>
		</div>
		<?php
			$tableoauthtw = new PoTable('oauth');
			$currentOauthtw = $tableoauthtw->findBy(id_oauth, '2');
			$currentOauthtw = $currentOauthtw->current();
		?>
		<div class="table-responsive">
			<table class="table table-vcenter" cellpadding="0" cellspacing="0">
				<thead><tr><th style="width:20%;"><?=$langsetting3;?></th><th><?=$langsetting4;?></th></tr></thead>
				<tbody>
				<tr>
					<td>Twitter Consumer Key</td>
					<td><?=$currentOauthtw->oauth_key;?></td>
				</tr>
				<tr>
					<td>Twitter Consumer Secret</td>
					<td><?=$currentOauthtw->oauth_secret;?></td>
				</tr>
				<tr>
					<td>Twitter Id</td>
					<td><?=$currentOauthtw->oauth_id;?></td>
				</tr>
				<tr>
					<td>Twitter User</td>
					<td><?=$currentOauthtw->oauth_user;?></td>
				</tr>
				<tr>
					<td colspan="2">
						<form method="post" action="<?=$aksi;?>" autocomplete="off">
							<input type="hidden" name="mod" value="setting">
							<input type="hidden" name="act" value="deloauthtw">
							<a href="#tbleditoauthtw" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fa fa-pencil"></i> Edit App Connect</a>
							<a class="btn btn-sm btn-primary" href="po-component/po-oauth/twitter/index.php"><i class="fa fa-twitter"></i> New Or Renew OAuth</a>
							<button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-times"></i> Delete OAuth</button>
						</form>
					</td>
				</tr>
			</tbody></table>
		</div>
		<!-- Dialog content -->
		<div id="tbleditoauthtw" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="form-validation" method="post" action="<?=$aksi;?>" autocomplete="off">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title">Edit App Connect</h3>
						</div>
						<div class="modal-body">
							<input type="hidden" name="mod" value="setting">
							<input type="hidden" name="act" value="editoauthtw">
							<div class="form-group">
								<label>Twitter Consumer Key</label>
								<input class="form-control" type="text" id="oauth_key" name="oauth_key" value="<?=$currentOauthtw->oauth_key;?>" required>
							</div>
							<div class="form-group">
								<label>Twitter Consumer Secret</label>
								<input class="form-control" type="text" id="oauth_secret" name="oauth_secret" value="<?=$currentOauthtw->oauth_secret;?>" required>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    <?php
    $filename_meta = "po-component/po-setting/meta-social.txt";
	if (file_exists("$filename_meta")){
	$fh_meta = fopen($filename_meta, "r") or die("Could not open file!");
	$data_meta = fread($fh_meta, filesize($filename_meta)) or die("Could not read file!");
	fclose($fh_meta);
    ?>
    <style type="text/css">
		.CodeMirror { height: 300px; }
		.CodeMirror-matchingtag { background: #4d4d4d; }
		.breakpoints { width: .8em; }
		.breakpoint { color: #3498db; }
    </style>
    <div class="block full">
		<div class="block-title">
            <h2>Meta Social For Social Media Shared Link</h2>
        </div>
        <form method="post" action="<?=$aksi;?>" autocomplete="off">
			<input type="hidden" name="mod" value="setting">
			<input type="hidden" name="act" value="metasocial">
            <textarea class="form-control" id="pocodemirror" name="meta_content" style="width:100%; height:300px;"><?=$data_meta;?></textarea>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit Meta</button>
        </form>
    </div>
    <?php } ?>
<?php
    break;  
}
}
?>