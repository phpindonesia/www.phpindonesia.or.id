<?php
//                                              Don't delete this comments
// =======================================================================
// CoGen a.k.a Component Generator
// =======================================================================
// Creator : Dwira Survivor
// Version : 1.0.0
// About :
// CoGen is tool for PopojiCMS for generate some component without
// coding, so user can create new component in PopojiCMS with easy steps.
// =======================================================================
//                                              Don't delete this comments
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

$val = new Povalidasi;
$mod = $_POST['mod'];
$act = $_POST['act'];

// Add Field Form
if ($mod=='cogen' AND $act=='compogenaddfield'){
	$id = $val->validasi($_POST['id'],'sql');
	?>
					<div class="col-md-12" style="margin-top:10px;">
						<label>Field <?=$id;?> <span class="text-danger">*</span></label>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_name_<?=$id;?>">Field Name <span class="text-danger">*</span></label>
									<input type="text" id="compo_field_name_<?=$id;?>" name="ifield[<?=$id;?>][compo_field_name]" class="form-control" placeholder="Type field name here..." required="" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_type_<?=$id;?>">Field Type</label>
									<select id="compo_field_type_<?=$id;?>" name="ifield[<?=$id;?>][compo_field_type]" class="form-control" placeholder="Type field type here...">
										<option value="int">Integer</option>
										<option value="varchar">Varchar</option>
										<option value="text">Text</option>
										<option value="date">Date</option>
										<option value="time">Time</option>
										<option value="datetime">Datetime</option>
										<option value="enum">Enum</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_length_value_<?=$id;?>">Field Length / Values</label>
									<input type="text" id="compo_field_length_value_<?=$id;?>" name="ifield[<?=$id;?>][compo_field_length_value]" class="form-control" placeholder="Type field length / value here..." />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_default_value_<?=$id;?>">Field Default Values</label>
									<input type="text" id="compo_field_default_value_<?=$id;?>" name="ifield[<?=$id;?>][compo_field_default_value]" class="form-control" placeholder="Type field default / value here..." />
								</div>
							</div>
						</div>
					</div>
	<?php
}

// Cek component exist
elseif ($mod=='cogen' AND $act=='compogenexists'){
$compo_name = trim(strtolower($_POST['compo_name']));
$dirpath = "../../po-component/po-".$compo_name;
	if (file_exists($dirpath)){
		echo "true";
	} else {
		echo "false";
	}
}

// Cek table exist
elseif ($mod=='cogen' AND $act=='compogentblexist'){
$dbhostsql = DATABASE_HOST;
$dbusersql = DATABASE_USER;
$dbpasswordsql = DATABASE_PASS;
$dbnamesql = DATABASE_NAME;
$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
mysql_select_db($dbnamesql, $connection) or die(mysql_error());

$compo_table = trim(strtolower($_POST['compo_table']));
$table = mysql_query("SELECT 1 FROM `".$compo_table."`");
	if($table !== FALSE) {
		echo "true";
	} else {
		echo "false";
	}
}

// Generate Component
elseif ($mod=='cogen' AND $act=='compogen'){
?>
<title>CompoGen Generating Process</title>
<link rel="shortcut icon" href="../../favicon.png">
<link type="text/css" rel="stylesheet" href="../../css/bootstrap.min.css">
<div class="container" style="margin-top:50px;margin-bottom:50px;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Generating Process</div>
                    <div class="panel-body">
                        <ul class="list-group">
<?php
$dbhostsql = DATABASE_HOST;
$dbusersql = DATABASE_USER;
$dbpasswordsql = DATABASE_PASS;
$dbnamesql = DATABASE_NAME;
$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
mysql_select_db($dbnamesql, $connection) or die(mysql_error());

// General Data
$compo_name = trim(strtolower($_POST['compo_name']));
$ucompo_name = ucfirst($compo_name);
$compo_desc = trim(strtolower($_POST['compo_desc']));
$dirpath = "../../po-component/po-".$compo_name;

// Database Data
$compo_table = trim(strtolower($_POST['compo_table']));
$compo_field_name_1 = trim(strtolower($_POST['compo_field_name_1']));
$compo_field_type_1 = trim(strtolower($_POST['compo_field_type_1']));
$compo_field_length_value_1 = trim(strtolower($_POST['compo_field_length_value_1']));
$totalfield = $val->validasi($_POST['totalfield'],'sql');
$totalfieldrow = $totalfield + 1;
$ifield = $_POST['ifield'];

// Finish Data
$compo_action = trim(strtolower($_POST['compo_action']));
$compo_seourl = trim(strtolower($_POST['compo_seourl']));
$compo_browse = trim(strtolower($_POST['compo_browse']));

	// Create Table
	$droptable = "DROP TABLE IF EXISTS `".$compo_table."`";
	$resultdrp = mysql_query($droptable);
	echo "<li class='list-group-item'>- ".$droptable."</li>";

	$createtbl = "CREATE TABLE IF NOT EXISTS `".$compo_table."` (
		`".$compo_field_name_1."` ".$compo_field_type_1."(".$compo_field_length_value_1.") NOT NULL AUTO_INCREMENT,
		PRIMARY KEY (`".$compo_field_name_1."`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1";
	$resultcrt = mysql_query($createtbl);
	echo "<li class='list-group-item'>- ".$createtbl."</li>";

	// Create Field
	foreach($ifield as $ifields){
		if ($ifields['compo_field_type'] == "int" OR $ifields['compo_field_type'] == "date" OR $ifields['compo_field_type'] == "time" OR $ifields['compo_field_type'] == "datetime") {
			$charset = "";
		} else {
			$charset = "CHARACTER SET latin1 COLLATE latin1_general_ci";
		}
		if (empty($ifields['compo_field_length_value'])) {
			$typefield = $ifields['compo_field_type'];
			$defaultvalue = "";
		} else {
			$typefield = $ifields['compo_field_type']."(".$ifields['compo_field_length_value'].")";
			$defaultvalue = "DEFAULT '".$ifields['compo_field_default_value']."'";
		}
		$createfield = "ALTER TABLE ".$compo_table." ADD ".$ifields['compo_field_name']." ".$typefield." ".$charset." NOT NULL ".$defaultvalue."";
		$resultcrtf = mysql_query($createfield);
		echo "<li class='list-group-item'>- ".$createfield."</li>";
	}
	if (!empty($compo_seourl)) {
		$createfieldurl = "ALTER TABLE ".$compo_table." ADD seourl varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL";
		$resultcrtfurl = mysql_query($createfieldurl);
		echo "<li class='list-group-item'>- ".$createfieldurl."</li>";
	}

	// Create new folder
	if (file_exists($dirpath)){
		$delcompo = deleteDir($dirpath);
		mkdir($dirpath, 755);
		copy("../../po-component/index.html", "".$dirpath."/index.html");
		echo "<li class='list-group-item'>- DELETE OLD DIRECTORY `po-".$compo_name."`</li>";
		echo "<li class='list-group-item'>- MAKE NEW DIRECTORY `po-".$compo_name."`</li>";
	}else{
		mkdir($dirpath, 755);
		echo "<li class='list-group-item'>- MAKE NEW DIRECTORY `po-".$compo_name."`</li>";
	}

	// Create component element
	$make1 = fopen("".$dirpath."/".$compo_name.".php", 'w');
	$make2 = fopen("".$dirpath."/datatable.php", 'w');
	$make3 = fopen("".$dirpath."/javascript.js", 'w');
	$make4 = fopen("".$dirpath."/proses.php", 'w');
	echo "<li class='list-group-item'>- CREATE FILE ".$compo_name.".php, datatable.php, javascript.js and proses.php INTO FOLDER `po-".$compo_name."`</li>";

	$dumpingpoint = <<<EOS
<?php
//Author  	= 'CompoGen';
//Contact 	= 'mailto:info@popojicms.org';
session_start();
if (empty(\$_SESSION['namauser']) AND empty(\$_SESSION['passuser'])){
	header('location:404.php');
}else{
\$aksi="po-component/po-{$compo_name}/proses.php";
?>
	<div class="content-header">
		<div class="header-section"><h1>{$ucompo_name} Management</h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=\$langmenu1;?></a></li>
		<li>Add, update, delete {$ucompo_name} management</li>
	</ul>
<?php
switch(\$_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title">
            <h2>{$ucompo_name} Management</h2>
            <div class="block-options pull-right">
				<a href="admin.php?mod={$compo_name}&act=addnew" class="btn btn-sm btn-primary" title="Add New"><i class="fa fa-plus-square-o"></i> Add New</a>
			</div>
        </div>
		<div class="table-responsive">
			<form method="post" action="<?=\$aksi;?>">
				<input type="hidden" name="mod" value="{$compo_name}">
				<input type="hidden" name="act" value="multidelete">
				<input type="hidden" value="0" name="totaldata" id="totaldata">
				<table cellpadding="0" cellspacing="0" border="0" class="dTableAjax table table-vcenter table-condensed table-bordered" id="dynamic">
					<thead><tr>
						<th style="width:80px;" class="text-center"><i class="fa fa-check-circle-o"></i></th>
                        <th>Id Data</th>\n
EOS;
	fwrite($make1, $dumpingpoint);
    foreach($ifield as $ifields){
		if ($ifields['compo_field_type'] != "text") {
			if ($ifields['compo_field_length_value'] < 255) {
                $uifields = str_replace('_', ' ', ucfirst($ifields['compo_field_name']));
                if ($compo_seourl != $ifields['compo_field_name'] OR $compo_browse != $ifields['compo_field_name']) {
				    $dumpingpoint2 = <<<EOS
						<th>{$uifields}</th>\n
EOS;
				    file_put_contents($dirpath."/".$compo_name.".php", $dumpingpoint2, FILE_APPEND | LOCK_EX);
                }
			}
		}
	}
    $dumpingpoint3 = <<<EOS
                        <th>Action</th>
					</tr></thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<td style="width:80px;" class="text-center"><input type="checkbox" id="titleCheck" data-toggle="tooltip" title="<?=\$langaction5;?>" /></td>
							<td colspan="{$totalfieldrow}">
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
				<form method="post" action="<?=\$aksi;?>" autocomplete="off">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=\$langdelete1;?></h3>
					</div>
					<div class="modal-body">
						<input type="hidden" name="mod" value="{$compo_name}">
						<input type="hidden" name="act" value="delete">
						<input type="hidden" id="delid" name="id">
						<?=\$langdelete2;?>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> <?=\$langdelete3;?></button>
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> <?=\$langdelete4;?></button>
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
		<form id="form-validation" class="form-bordered" method="post" action="<?=\$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="{$compo_name}" />
				<input type="hidden" name="act" value="input" />\n
EOS;
    file_put_contents($dirpath."/".$compo_name.".php", $dumpingpoint3, FILE_APPEND | LOCK_EX);
    foreach($ifield as $ifields){
        $uifields = str_replace('_', ' ', ucfirst($ifields['compo_field_name']));
        if ($compo_seourl != $ifields['compo_field_name'] OR $compo_browse != $ifields['compo_field_name']) {
            if ($ifields['compo_field_type'] == "varchar") {
                if ($compo_browse == $ifields['compo_field_name']) {
                    $dumpingpoint4 = <<<EOS
                        <div class="form-group">
                        <label>{$uifields}</label>
                        <div class="col-md-6 input-group">
                            <input class="form-control" type="text" id="picture" name="{$ifields['compo_field_name']}" />
                            <span class="input-group-btn">
                                <a href="js/plugins/filemanager/dialog.php?type=1&field_id=picture" class="btn btn-success" id="browse-file">Browse</a>
                            </span>
                        </div>
                    </div>\n
EOS;
                } else {
                    $dumpingpoint4 = <<<EOS
                        <div class="form-group">
                            <label>{$uifields} <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" required />
                        </div>\n
EOS;
                }
            } elseif ($ifields['compo_field_type'] == "date") {
                $dumpingpoint4 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" class="form-control input-datepicker-close masked_date" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required />
                            </div>
                        </div>
                    </div>\n
EOS;
            } elseif ($ifields['compo_field_type'] == "time") {
                $dumpingpoint4 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <div class="col-md-2 input-group bootstrap-timepicker">
                            <input type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" class="form-control input-timepicker24" required />
                            <span class="input-group-btn"><a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a></span>
                        </div>
                    </div>\n
EOS;
            } elseif ($ifields['compo_field_type'] == "datetime") {
                $dumpingpoint4 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" class="form-control datetimepicker masked_date_time" placeholder="yyyy-mm-dd hh:mm:ss" required />
                            </div>
                        </div>
                    </div>\n
EOS;
            } elseif ($ifields['compo_field_type'] == "enum") {
                $dumpingpoint4 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-4">
                                <select class="select-chosen-no-search" name="{$ifields['compo_field_name']}" style="width:280px;" data-placeholder="Choose {$uifields}">\n
EOS;
                $enumchooses = explode(",",  str_replace('\'', '', $ifields['compo_field_length_value']));
                foreach($enumchooses as $enumchoose){
                $dumpingpoint4 .= <<<EOS
                                    <option value="{$enumchoose}">{$enumchoose}</option>\n
EOS;
                }
                $dumpingpoint4 .= <<<EOS
                                </select>
                            </div>
                        </div>
                    </div>\n
EOS;
            } elseif ($ifields['compo_field_type'] == "text") {
                $dumpingpoint4 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="po-wysiwyg" name="{$ifields['compo_field_name']}" style="height:500px;" required></textarea>
                    </div>\n
EOS;
            } else {
                if ($compo_browse == $ifields['compo_field_name']) {
                    $dumpingpoint4 = <<<EOS
                        <div class="form-group">
                        <label>$uifields</label>
                        <div class="col-md-6 input-group">
                            <input class="form-control" type="text" id="picture" name="{$ifields['compo_field_name']}" />
                            <span class="input-group-btn">
                                <a href="js/plugins/filemanager/dialog.php?type=1&field_id=picture" class="btn btn-success" id="browse-file">Browse</a>
                            </span>
                        </div>
                    </div>\n
EOS;
                } else {
                    $dumpingpoint4 = <<<EOS
                        <div class="form-group">
                            <label>{$uifields} <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" required />
                        </div>\n
EOS;
                }
            }
		}
		file_put_contents($dirpath."/".$compo_name.".php", $dumpingpoint4, FILE_APPEND | LOCK_EX);
	}
    $dumpingpoint5 = <<<EOS
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

	case "edit":
	\$valid = \$val->validasi(\$_GET['id'],'sql');
	\$table = new PoTable('{$compo_table}');
	\$current{$ucompo_name} = \$table->findBy({$compo_field_name_1}, \$valid);
	\$current{$ucompo_name} = \$current{$ucompo_name}->current();
	if (\$current{$ucompo_name} == '0'){
?>
	<div class="block block-alt-noborder">
		<h3 class="sub-header">Ooops! <?=\$langpagenotfound1;?></h3>
		<p>&nbsp;</p>
		<p align="center">
			<?php
				\$url = rtrim("http://".\$_SERVER['HTTP_HOST'], "/").\$_SERVER['PHP_SELF'];
				\$url2 = preg_replace("/\/(admin\.php$)/","",\$url);
				\$siteurl = \$url2;
			?>
			<a title="Back to Previous page" class="btn btn-sm btn-primary" onClick="history.back();"><?=\$langpagenotfound3;?></a>
			<a href="<?=\$siteurl;?>" title="Back to the website" class="btn btn-sm btn-primary"><?=\$langpagenotfound2;?></a>
		</p>
		<p>&nbsp;</p>
	</div>
	<p style="width:100%; height:500px;">&nbsp;</p>
<?php
	}else{
?>
	<div class="block full">
		<div class="block-title"><h2>Edit {$ucompo_name}</h2></div>
		<form id="form-validation" class="form-bordered" method="post" action="<?=\$aksi;?>" autocomplete="off">
            <fieldset>
				<input type="hidden" name="mod" value="{$compo_name}" />
				<input type="hidden" name="act" value="update" />
                <input type="hidden" name="id" value="<?=\$current{$ucompo_name}->{$compo_field_name_1};?>">\n
EOS;
    file_put_contents($dirpath."/".$compo_name.".php", $dumpingpoint5, FILE_APPEND | LOCK_EX);
    foreach($ifield as $ifields){
        $uifields = str_replace('_', ' ', ucfirst($ifields['compo_field_name']));
        if ($compo_seourl != $ifields['compo_field_name'] OR $compo_browse != $ifields['compo_field_name']) {
            if ($ifields['compo_field_type'] == "varchar") {
                if ($compo_browse == $ifields['compo_field_name']) {
                    $dumpingpoint6 = <<<EOS
                        <div class="form-group">
                        <label>{$uifields}</label>
                        <div class="col-md-6 input-group">
                            <input class="form-control" type="text" id="picture" name="{$ifields['compo_field_name']}" value="<?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?>" />
                            <span class="input-group-btn">
                                <a href="js/plugins/filemanager/dialog.php?type=1&field_id=picture" class="btn btn-success" id="browse-file">Browse</a>
                            </span>
                        </div>
                    </div>\n
EOS;
                } else {
                    $dumpingpoint6 = <<<EOS
                        <div class="form-group">
                            <label>{$uifields} <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" value="<?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?>" required />
                        </div>\n
EOS;
                }
            } elseif ($ifields['compo_field_type'] == "date") {
                $dumpingpoint6 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" class="form-control input-datepicker-close masked_date" data-date-format="yyyy-mm-dd" value="<?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?>" placeholder="yyyy-mm-dd" required />
                            </div>
                        </div>
                    </div>\n
EOS;
            } elseif ($ifields['compo_field_type'] == "time") {
                $dumpingpoint6 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <div class="col-md-2 input-group bootstrap-timepicker">
                            <input type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" class="form-control input-timepicker24" value="<?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?>" required />
                            <span class="input-group-btn"><a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a></span>
                        </div>
                    </div>\n
EOS;
            } elseif ($ifields['compo_field_type'] == "datetime") {
                $dumpingpoint6 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" class="form-control datetimepicker masked_date_time" value="<?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?>" placeholder="yyyy-mm-dd hh:mm:ss" required />
                            </div>
                        </div>
                    </div>\n
EOS;
            } elseif ($ifields['compo_field_type'] == "enum") {
                $dumpingpoint6 = <<<EOS
                    <div class="form-group">
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-4">
                                <select class="select-chosen-no-search" name="{$ifields['compo_field_name']}" style="width:280px;" data-placeholder="Choose {$uifields}">
                                    <option value="<?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?>"><?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?></option>\n
EOS;
                $enumchooses = explode(",",  str_replace('\'', '', $ifields['compo_field_length_value']));
                foreach($enumchooses as $enumchoose){
                $dumpingpoint6 .= <<<EOS
                                    <option value="{$enumchoose}">{$enumchoose}</option>\n
EOS;
                }
                $dumpingpoint6 .= <<<EOS
                                </select>
                            </div>
                        </div>
                    </div>\n
EOS;
            } elseif ($ifields['compo_field_type'] == "text") {
                $dumpingpoint6 = <<<EOS
                    <div class="form-group">
                        <?php \$dutf = html_entity_decode(\$current{$ucompo_name}->{$ifields['compo_field_name']}); ?>
                        <label>{$uifields} <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="po-wysiwyg" name="{$ifields['compo_field_name']}" style="height:500px;" required><?=\$dutf;?></textarea>
                    </div>\n
EOS;
            } else {
                if ($compo_browse == $ifields['compo_field_name']) {
                    $dumpingpoint6 = <<<EOS
                        <div class="form-group">
                        <label>$uifields</label>
                        <div class="col-md-6 input-group">
                            <input class="form-control" type="text" id="picture" name="{$ifields['compo_field_name']}" value="<?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?>" />
                            <span class="input-group-btn">
                                <a href="js/plugins/filemanager/dialog.php?type=1&field_id=picture" class="btn btn-success" id="browse-file">Browse</a>
                            </span>
                        </div>
                    </div>\n
EOS;
                } else {
                    $dumpingpoint6 = <<<EOS
                        <div class="form-group">
                            <label>{$uifields} <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="{$ifields['compo_field_name']}" name="{$ifields['compo_field_name']}" value="<?=\$current{$ucompo_name}->{$ifields['compo_field_name']};?>" required />
                        </div>\n
EOS;
                }
            }
		}
		file_put_contents($dirpath."/".$compo_name.".php", $dumpingpoint6, FILE_APPEND | LOCK_EX);
	}
    $dumpingpointlast = <<<EOS
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
EOS;
    file_put_contents($dirpath."/".$compo_name.".php", $dumpingpointlast, FILE_APPEND | LOCK_EX);
	echo "<li class='list-group-item'>- WRITE CODE INTO `".$compo_name.".php`</li>";

	if ($compo_action == "0" OR $compo_action == "3" OR $compo_action == "5" OR $compo_action == "6"){
		$checkdata = "\$checkdata = \"<div class='text-center'><input type='checkbox' id='titleCheckdel' /><input type='hidden' class='deldata' name='item[\$no][deldata]' value='\$aRow[".$compo_field_name_1."]' disabled></div>\";";
		$rowcheckdata = "\$row[] = \$checkdata;";
		$tbldelete = "\$tbldelete = \"<a class='btn btn-xs btn-danger alertdel' id='\$aRow[".$compo_field_name_1."]'><i class='fa fa-times'></i></a>\";";
	} else {
		$checkdata = "";
		$rowcheckdata = "";
		$tbldelete = "";
	}
	if ($compo_action == "0" OR $compo_action == "2" OR $compo_action == "4" OR $compo_action == "6"){
		$tbledit = "<a href='admin.php?mod=".$compo_name."&act=edit&id=\$aRow[".$compo_field_name_1."]' class='btn btn-xs btn-default' id='\$aRow[".$compo_field_name_1."]'><i class='fa fa-pencil'></i></a>";
	} else {
		$tbledit = "";
	}
	if ($compo_action == "7") {
		$rowaction = "";
	} else {
		$rowaction = "\$row[] = \"<div class='text-center'><div class='btn-group btn-group-xs'>
				{$tbledit}
				\$tbldelete
			</div></div>\";";
	}
	$dumpingdatatable = <<<EOS
<?php
session_start();
if (empty(\$_SESSION['namauser']) AND empty(\$_SESSION['passuser'])){
	header('location:404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';\n\n
EOS;
	fwrite($make2, $dumpingdatatable);
	$dumpingdatatable2 = <<<EOS
	\$aColumns= array( "{$compo_field_name_1}", 
EOS;
	file_put_contents($dirpath."/datatable.php", $dumpingdatatable2, FILE_APPEND | LOCK_EX);
	foreach($ifield as $ifields){
		$dumpingdatatable3 = <<<EOS
"{$ifields['compo_field_name']}", 
EOS;
		file_put_contents($dirpath."/datatable.php", $dumpingdatatable3, FILE_APPEND | LOCK_EX);
	}
	if (!empty($compo_seourl)) {
		$dumpingdatatable4 = <<<EOS
'seourl', );\n\n
EOS;
	} else {
		$dumpingdatatable4 = <<<EOS
);\n\n
EOS;
	}
	file_put_contents($dirpath."/datatable.php", $dumpingdatatable4, FILE_APPEND | LOCK_EX);
	$dumpingdatatable5 = <<<EOS
    \$sIndexColumn = "{$compo_field_name_1}";

    \$sTable = "{$compo_table}";

    \$gaSql['user']       = DATABASE_USER;
    \$gaSql['password']   = DATABASE_PASS;
    \$gaSql['db']         = DATABASE_NAME;
    \$gaSql['server']     = DATABASE_HOST;

    \$gaSql['link'] =  mysql_pconnect( \$gaSql['server'], \$gaSql['user'], \$gaSql['password']  ) or
        die( 'Could not open connection to server' );

    mysql_select_db( \$gaSql['db'], \$gaSql['link'] ) or
        die( 'Could not select database '. \$gaSql['db'] );

    \$sLimit = "";
    if ( isset( \$_GET['iDisplayStart'] ) && \$_GET['iDisplayLength'] != '-1' )
    {
		\$sLimit = "LIMIT ".mysql_real_escape_string( \$_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( \$_GET['iDisplayLength'] );
    }

    \$sOrder = "";
    if ( isset( \$_GET['iSortCol_0'] ) )
    {
        \$sOrder = "ORDER BY  ";
        for ( \$i=0 ; \$i<intval( \$_GET['iSortingCols'] ) ; \$i++ )
        {
            if ( \$_GET[ 'bSortable_'.intval(\$_GET['iSortCol_'.\$i]) ] == "true" )
            {
                \$sOrder .= \$aColumns[ intval( \$_GET['iSortCol_'.\$i] ) ]."
                    ".mysql_real_escape_string( \$_GET['sSortDir_'.\$i] ) .", ";
            }
        }

        \$sOrder = substr_replace( \$sOrder, "", -2 );
        if ( \$sOrder == "ORDER BY" )
        {
            \$sOrder = "";
        }
    }

    \$sWhere = "";
    if ( isset(\$_GET['sSearch']) && \$_GET['sSearch'] != "" )
    {
        \$sWhere = "WHERE (";
        for ( \$i=0 ; \$i<count(\$aColumns) ; \$i++ )
        {
            \$sWhere .= \$aColumns[\$i]." LIKE '%".mysql_real_escape_string( \$_GET['sSearch'] )."%' OR ";
        }
        \$sWhere = substr_replace( \$sWhere, "", -3 );
        \$sWhere .= ')';
    }

    for ( \$i=0 ; \$i<count(\$aColumns) ; \$i++ )
    {
        if ( isset(\$_GET['bSearchable_'.\$i]) && \$_GET['bSearchable_'.\$i] == "true" && \$_GET['sSearch_'.\$i] != '' )
        {
            if ( \$sWhere == "" )
            {
                \$sWhere = "WHERE ";
            }
            else
            {
                \$sWhere .= " AND ";
            }
            \$sWhere .= \$aColumns[\$i]." LIKE '%".mysql_real_escape_string(\$_GET['sSearch_'.\$i])."%' ";
        }
    }

    \$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", \$aColumns))."
        FROM   \$sTable
        \$sWhere
        \$sOrder
        \$sLimit
    ";
    \$rResult = mysql_query( \$sQuery, \$gaSql['link'] ) or die(mysql_error());

    \$sQuery = "
        SELECT FOUND_ROWS()
    ";
    \$rResultFilterTotal = mysql_query( \$sQuery, \$gaSql['link'] ) or die(mysql_error());
    \$aResultFilterTotal = mysql_fetch_array(\$rResultFilterTotal);
    \$iFilteredTotal = \$aResultFilterTotal[0];

    \$sQuery = "
        SELECT COUNT(".\$sIndexColumn.")
        FROM   \$sTable
    ";
    \$rResultTotal = mysql_query( \$sQuery, \$gaSql['link'] ) or die(mysql_error());
    \$aResultTotal = mysql_fetch_array(\$rResultTotal);
    \$iTotal = \$aResultTotal[0];

    \$output = array(
        "sEcho" => intval(\$_GET['sEcho']),
        "iTotalRecords" => \$iTotal,
        "iTotalDisplayRecords" => \$iFilteredTotal,
        "aaData" => array()
    );

	\$no = 1;
    while ( \$aRow = mysql_fetch_array( \$rResult ) )
    {
        \$row = array();
        for ( \$i=1 ; \$i<count(\$aColumns) ; \$i++ )
        {
			\$str = "http://".\$_SERVER['HTTP_HOST'].\$_SERVER['PHP_SELF'];
			\$strlink = preg_replace("/\/po-adminboard\/po-component\/po-{$compo_name}\/(datatable\.php$)/","",\$str);
			{$tbldelete}
			{$checkdata}
			{$rowcheckdata}
			\$row[] = \$aRow['{$compo_field_name_1}'];\n
EOS;
	file_put_contents($dirpath."/datatable.php", $dumpingdatatable5, FILE_APPEND | LOCK_EX);
	foreach($ifield as $ifields){
		if ($ifields['compo_field_type'] != "text") {
			if ($ifields['compo_field_length_value'] < 255) {
                if ($compo_seourl != $ifields['compo_field_name'] OR $compo_browse != $ifields['compo_field_name']) {
				    $dumpingdatatable6 = <<<EOS
			\$row[] = \$aRow['{$ifields['compo_field_name']}'];\n
EOS;
				    file_put_contents($dirpath."/datatable.php", $dumpingdatatable6, FILE_APPEND | LOCK_EX);
                }
			}
		}
	}
	$dumpingdatatable7 = <<<EOS
			{$rowaction}
        }
        \$output['aaData'][] = \$row;
	\$no++;
    }

    echo json_encode( \$output );
}
?>
EOS;
	file_put_contents($dirpath."/datatable.php", $dumpingdatatable7, FILE_APPEND | LOCK_EX);
	echo "<li class='list-group-item'>- WRITE CODE INTO `datatable.php`</li>";

	$dumpingjavascript = <<<EOS
oTable = $('.dTableAjax').dataTable({
	"sAjaxSource": "po-component/po-{$compo_name}/datatable.php",
	"sDom": "<'row'<'col-sm-6 col-xs-5'l><'col-sm-6 col-xs-7'f>r>t<'row'<'col-sm-5 hidden-xs'i><'col-sm-7 col-xs-12 clearfix'p>>",
	"sPaginationType": "bootstrap",
	"oLanguage": {
		"sLengthMenu": "_MENU_",
			"sSearch": '<div class="input-group">_INPUT_<span class="input-group-addon"><i class="fa fa-search"></i></span></div>',
			"sInfo": "<strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
			"oPaginate": {
				"sPrevious": "",
				"sNext": ""
			}
	},
	"bJQueryUI": false,
	"bAutoWidth": false,
	"aaSorting": [[2, "desc"]],
	"bStateSave": true,
	"bServerSide": true,
	"iDisplayLength": 10,
		"aLengthMenu": [
			[10, 30, 50, -1],
			[10, 30, 50, "All"]
		],
	"fnDrawCallback": function( oSettings ) {
		$("#titleCheck").click(function() {
			var checkedStatus = this.checked;
			$("table tbody tr td div:first-child input[type=checkbox]").each(function() {
				this.checked = checkedStatus;
				if (checkedStatus == this.checked) {
					$(this).closest('table tbody tr').removeClass('danger');
					$(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
					$('#totaldata').val($('form input[type=checkbox]:checked').size());
				}
				if (this.checked) {
					$(this).closest('table tbody tr').addClass('danger');
					$(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
					$('#totaldata').val($('form input[type=checkbox]:checked').size());
				}
			});
		});	
		$('table tbody tr td div:first-child input[type=checkbox]').on('click', function () {
			var checkedStatus = this.checked;
			this.checked = checkedStatus;
			if (checkedStatus == this.checked) {
				$(this).closest('table tbody tr').removeClass('danger');
				$(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
				$('#totaldata').val($('form input[type=checkbox]:checked').size());
			}
			if (this.checked) {
				$(this).closest('table tbody tr').addClass('danger');
				$(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
				$('#totaldata').val($('form input[type=checkbox]:checked').size());
			}
		});
		$('table tbody tr td div:first-child input[type=checkbox]').change(function() {
			$(this).closest('tr').toggleClass("danger", this.checked);
		});
		$(".alertdel").click(function(){
			var id = $(this).attr("id");
			$('#alertdel').modal('show');
			$('#delid').val(id);
		});
	}
});

$(".masked_date").mask("9999-99-99");
$(".masked_date_time").mask("9999-99-99 99:99:99");
EOS;
	fwrite($make3, $dumpingjavascript);
	echo "<li class='list-group-item'>- WRITE CODE INTO `javascript.js`</li>";

	$dumpingproses = <<<EOS
<?php
session_start();
if (empty(\$_SESSION['namauser']) AND empty(\$_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

\$val = new Povalidasi;
\$mod = \$_POST['mod'];
\$act = \$_POST['act'];

// Delete {$ucompo_name}
if (\$mod=='{$compo_name}' AND \$act=='delete'){
	\$id = \$val->validasi(\$_POST['id'],'sql');
	\$tabledel = new PoTable('{$compo_table}');
	\$tabledel->deleteBy('{$compo_field_name_1}', \$id);
	header('location:../../admin.php?mod='.\$mod);
}

// Multi Delete {$ucompo_name}
elseif (\$mod=='{$compo_name}' AND \$act=='multidelete'){
	\$totaldata = \$val->validasi(\$_POST['totaldata'],'xss');
	if (\$totaldata != "0"){
		\$itemdel = \$_POST['item'];
		\$tabledel = new PoTable('{$compo_table}');
		foreach (\$itemdel as \$item){
			\$id = \$val->validasi(\$item['deldata'],'xss');
			\$tabledel->deleteBy('{$compo_field_name_1}', \$id);
		}
		header('location:../../admin.php?mod='.\$mod);
	}else{
		header('location:../../404.php');
	}
}

// Input {$ucompo_name}
elseif (\$mod=='{$compo_name}' AND \$act=='input'){\n
EOS;
	fwrite($make4, $dumpingproses);
	foreach($ifield as $ifields){
		if ($ifields['compo_field_type'] == "varchar") {
			$dumpingproses2 = <<<EOS
\${$ifields['compo_field_name']} = \$val->validasi(\$_POST['{$ifields['compo_field_name']}'],'xss');\n
EOS;
		} elseif ($ifields['compo_field_type'] == "date" OR $ifields['compo_field_type'] == "time" OR $ifields['compo_field_type'] == "datetime" OR $ifields['compo_field_type'] == "enum") {
			$dumpingproses2 = <<<EOS
\${$ifields['compo_field_name']} = \$_POST['{$ifields['compo_field_name']}'];\n
EOS;
		} elseif ($ifields['compo_field_type'] == "text") {
			$dumpingproses2 = <<<EOS
\${$ifields['compo_field_name']} = stripslashes(htmlspecialchars(\$_POST['{$ifields['compo_field_name']}'],ENT_QUOTES));\n
EOS;
		} else {
			$dumpingproses2 = <<<EOS
\${$ifields['compo_field_name']} = \$_POST['{$ifields['compo_field_name']}'];\n
EOS;
		}
		file_put_contents($dirpath."/proses.php", $dumpingproses2, FILE_APPEND | LOCK_EX);
	}
	if (!empty($compo_seourl)) {
		$dumpingproses3 = <<<EOS
\$seourl = seo_title(\${$compo_seourl});\n
EOS;
		file_put_contents($dirpath."/proses.php", $dumpingproses3, FILE_APPEND | LOCK_EX);
	}
	if (!empty($compo_browse)) {
		$dumpingproses4 = <<<EOS
if(!empty(\$_POST['{$compo_browse}'])){
	\$table = new PoTable('{$compo_table}');
	\$table->save(array(\n
EOS;
		file_put_contents($dirpath."/proses.php", $dumpingproses4, FILE_APPEND | LOCK_EX);
		foreach($ifield as $ifields){
			$dumpingproses5 = <<<EOS
		'{$ifields['compo_field_name']}' => \${$ifields['compo_field_name']},\n
EOS;
			file_put_contents($dirpath."/proses.php", $dumpingproses5, FILE_APPEND | LOCK_EX);
		}
		if (!empty($compo_seourl)) {
			$dumpingproses6 = <<<EOS
		'seourl' => \$seourl,
	));
	header('location:../../admin.php?mod='.\$mod);
}else{
	\$table = new PoTable('{$compo_table}');
	\$table->save(array(\n
EOS;
		} else {
			$dumpingproses6 = <<<EOS
	));
	header('location:../../admin.php?mod='.\$mod);
}else{
	\$table = new PoTable('{$compo_table}');
	\$table->save(array(\n
EOS;
		}
		file_put_contents($dirpath."/proses.php", $dumpingproses6, FILE_APPEND | LOCK_EX);
		foreach($ifield as $ifields){
			if ($compo_browse != $ifields['compo_field_name']) {
				$dumpingproses7 = <<<EOS
		'{$ifields['compo_field_name']}' => \${$ifields['compo_field_name']},\n
EOS;
				file_put_contents($dirpath."/proses.php", $dumpingproses7, FILE_APPEND | LOCK_EX);
			}
		}
		if (!empty($compo_seourl)) {
			$dumpingproses8 = <<<EOS
		'seourl' => \$seourl,
	));
	header('location:../../admin.php?mod='.\$mod);
}
}

// Edit {$ucompo_name}
elseif (\$mod=='{$compo_name}' AND \$act=='update'){
\$id = \$val->validasi(\$_POST['id'],'sql');\n
EOS;
		} else {
			$dumpingproses8 = <<<EOS
	));
	header('location:../../admin.php?mod='.\$mod);
}
}

// Edit {$ucompo_name}
elseif (\$mod=='{$compo_name}' AND \$act=='update'){
\$id = \$val->validasi(\$_POST['id'],'sql');\n
EOS;
		}
		file_put_contents($dirpath."/proses.php", $dumpingproses8, FILE_APPEND | LOCK_EX);
	} else {
		$dumpingproses9 = <<<EOS
	\$table = new PoTable('{$compo_table}');
	\$table->save(array(\n
EOS;
		file_put_contents($dirpath."/proses.php", $dumpingproses9, FILE_APPEND | LOCK_EX);
		foreach($ifield as $ifields){
			$dumpingproses10 = <<<EOS
		'{$ifields['compo_field_name']}' => \${$ifields['compo_field_name']},\n
EOS;
			file_put_contents($dirpath."/proses.php", $dumpingproses10, FILE_APPEND | LOCK_EX);
		}
		if (!empty($compo_seourl)) {
			$dumpingproses11 = <<<EOS
		'seourl' => \$seourl,
	));
	header('location:../../admin.php?mod='.\$mod);
}

// Edit {$ucompo_name}
elseif (\$mod=='{$compo_name}' AND \$act=='update'){
\$id = \$val->validasi(\$_POST['id'],'sql');\n
EOS;
		} else {
			$dumpingproses11 = <<<EOS
	));
	header('location:../../admin.php?mod='.\$mod);
}

// Edit {$ucompo_name}
elseif (\$mod=='{$compo_name}' AND \$act=='update'){
\$id = \$val->validasi(\$_POST['id'],'sql');\n
EOS;
		}
		file_put_contents($dirpath."/proses.php", $dumpingproses11, FILE_APPEND | LOCK_EX);
	}
	foreach($ifield as $ifields){
		if ($ifields['compo_field_type'] == "varchar") {
			$dumpingproses12 = <<<EOS
\${$ifields['compo_field_name']} = \$val->validasi(\$_POST['{$ifields['compo_field_name']}'],'xss');\n
EOS;
		} elseif ($ifields['compo_field_type'] == "date" OR $ifields['compo_field_type'] == "time" OR $ifields['compo_field_type'] == "datetime" OR $ifields['compo_field_type'] == "enum") {
			$dumpingproses12 = <<<EOS
\${$ifields['compo_field_name']} = \$_POST['{$ifields['compo_field_name']}'];\n
EOS;
		} elseif ($ifields['compo_field_type'] == "text") {
			$dumpingproses12 = <<<EOS
\${$ifields['compo_field_name']} = stripslashes(htmlspecialchars(\$_POST['{$ifields['compo_field_name']}'],ENT_QUOTES));\n
EOS;
		} else {
			$dumpingproses12 = <<<EOS
\${$ifields['compo_field_name']} = \$_POST['{$ifields['compo_field_name']}'];\n
EOS;
		}
		file_put_contents($dirpath."/proses.php", $dumpingproses12, FILE_APPEND | LOCK_EX);
	}
	if (!empty($compo_seourl)) {
		$dumpingproses13 = <<<EOS
\$seourl = seo_title(\${$compo_seourl});\n
EOS;
		file_put_contents($dirpath."/proses.php", $dumpingproses13, FILE_APPEND | LOCK_EX);
	}
	if (!empty($compo_browse)) {
		$dumpingproses14 = <<<EOS
if(!empty(\$_POST['{$compo_browse}'])){
	\$data = array(\n
EOS;
		file_put_contents($dirpath."/proses.php", $dumpingproses14, FILE_APPEND | LOCK_EX);
		foreach($ifield as $ifields){
			$dumpingproses15 = <<<EOS
		'{$ifields['compo_field_name']}' => \${$ifields['compo_field_name']},\n
EOS;
			file_put_contents($dirpath."/proses.php", $dumpingproses15, FILE_APPEND | LOCK_EX);
		}
		if (!empty($compo_seourl)) {
			$dumpingproses16 = <<<EOS
		'seourl' => \$seourl,
	);
	\$table = new PoTable('{$compo_table}');
	\$table->updateBy('{$compo_field_name_1}', \$id, \$data);
	header('location:../../admin.php?mod='.\$mod);
}else{
	\$data = array(\n
EOS;
		} else {
			$dumpingproses16 = <<<EOS
	);
	\$table = new PoTable('{$compo_table}');
	\$table->updateBy('{$compo_field_name_1}', \$id, \$data);
	header('location:../../admin.php?mod='.\$mod);
}else{
	\$data = array(\n
EOS;
		}
		file_put_contents($dirpath."/proses.php", $dumpingproses16, FILE_APPEND | LOCK_EX);
		foreach($ifield as $ifields){
			if ($compo_browse != $ifields['compo_field_name']) {
				$dumpingproses17 = <<<EOS
		'{$ifields['compo_field_name']}' => \${$ifields['compo_field_name']},\n
EOS;
				file_put_contents($dirpath."/proses.php", $dumpingproses17, FILE_APPEND | LOCK_EX);
			}
		}
		if (!empty($compo_seourl)) {
			$dumpingproses18 = <<<EOS
		'seourl' => \$seourl,
	);
	\$table = new PoTable('{$compo_table}');
	\$table->updateBy('{$compo_field_name_1}', \$id, \$data);
	header('location:../../admin.php?mod='.\$mod);
}
}

EOS;
		} else {
			$dumpingproses18 = <<<EOS
	);
	\$table = new PoTable('{$compo_table}');
	\$table->updateBy('{$compo_field_name_1}', \$id, \$data);
	header('location:../../admin.php?mod='.\$mod);
}
}

EOS;
		}
		file_put_contents($dirpath."/proses.php", $dumpingproses18, FILE_APPEND | LOCK_EX);
	} else {
		$dumpingproses19 = <<<EOS
	\$data = array(\n
EOS;
		file_put_contents($dirpath."/proses.php", $dumpingproses19, FILE_APPEND | LOCK_EX);
		foreach($ifield as $ifields){
			$dumpingproses20 = <<<EOS
		'{$ifields['compo_field_name']}' => \${$ifields['compo_field_name']},\n
EOS;
			file_put_contents($dirpath."/proses.php", $dumpingproses20, FILE_APPEND | LOCK_EX);
		}
		if (!empty($compo_seourl)) {
			$dumpingproses21 = <<<EOS
		'seourl' => \$seourl,
	);
	\$table = new PoTable('{$compo_table}');
	\$table->updateBy('{$compo_field_name_1}', \$id, \$data);
	header('location:../../admin.php?mod='.\$mod);
}

EOS;
		} else {
			$dumpingproses21 = <<<EOS
	);
	\$table = new PoTable('{$compo_table}');
	\$table->updateBy('{$compo_field_name_1}', \$id, \$data);
	header('location:../../admin.php?mod='.\$mod);
}

EOS;
		}
		file_put_contents($dirpath."/proses.php", $dumpingproses21, FILE_APPEND | LOCK_EX);
	}
	$dumpingproseslast = <<<EOS
}
?>
EOS;
	file_put_contents($dirpath."/proses.php", $dumpingproseslast, FILE_APPEND | LOCK_EX);
	echo "<li class='list-group-item'>- WRITE CODE INTO `proses.php`</li>";

	// Registration new component to component list
	$regcomponent = "po-".$compo_name;
	$tablereg = new PoTable('component');
	$currentReg = $tablereg->findByAnd(component, $regcomponent, table_name, $compo_table);
	$currentReg = $currentReg->current();
	if ($currentReg == "0") {
		$tablereg->save(array(
			'component' => $regcomponent,
			'table_name' => $compo_table,
			'date' => $tgl_sekarang
		));
	}

	// Finish all step
	echo "<li class='list-group-item'>- SUCCESSFULLY GENERATE NEW COMPONENT</li>";
?>
                    </ul>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-sm btn-primary" href="../../admin.php?mod=<?=$compo_name;?>">Go To <?=$ucompo_name;?> Component</a>
                    <a class="btn btn-sm btn-danger pull-right" href="../../admin.php?mod=cogen">Back To CompoGen</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}

}
?>