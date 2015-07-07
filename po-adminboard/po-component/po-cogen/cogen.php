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
	header('location:404.php');
}else{
$aksi="po-component/po-cogen/proses.php";
?>
<?php if ($_SESSION[leveluser]=='1'){ ?>
	<div class="content-header">
		<div class="header-section"><h1>PopojiCMS Generator</h1></div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
		<li>PopojiCMS Generator</li>
	</ul>
<?php
switch($_GET[act]){
	default:
?>
	<div class="block full">
		<div class="block-title"><h2>Generator</h2></div>
		<div class="row">
			<div class="col-md-4">
				<div class="widget">
					<div class="widget-advanced">
						<div class="widget-header text-center" style="background:url('po-component/po-cogen/compogen-bg.jpg'); background-size:cover;">
							<h3 class="widget-content-light clearfix">Compo<strong>Gen</strong></h3>
						</div>
						<div class="widget-main" style="border-left:1px solid #ecf0f1;border-right:1px solid #ecf0f1;border-bottom:1px solid #ecf0f1;">
							<a href="admin.php?mod=cogen&act=compogen" class="widget-image-container animation-hatch">
								<span class="widget-icon themed-background"><i class="gi gi-coffee_cup"></i></span>
							</a>
							<h3 class="text-center animation-fadeIn"><small>Buat component PopojiCMS dengan generator ini tanpa perlu menuliskan code apapun. Buat component semudah menjentikkan jari.</small></h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p style="width:100%; height:200px;">&nbsp;</p>
<?php
    break;

	case "compogen":
?>
	<div class="block full">
		<div class="block-title">
			<h2>CompoGen</h2>
			<div class="block-options pull-right">
				<a data-original-title="Back To Main" href="admin.php?mod=cogen" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Back To Main"><i class="fa fa-reply"></i></a>
			</div>
		</div>
		<form id="compogen-wizard" action="<?=$aksi;?>" method="post" class="form-horizontal form-bordered" autocomplete="off">
			<input type="hidden" name="mod" value="cogen">
			<input type="hidden" name="act" value="compogen">
			<input type="hidden" id="totalfield" name="totalfield" value="4">
			<div id="first" class="step">
				<div class="wizard-steps">
					<div class="row">
						<div class="col-xs-4 active"><span>General</span></div>
						<div class="col-xs-4"><span>Database</span></div>
						<div class="col-xs-4"><span>Finish</span></div>
					</div>
				</div>
				<div class="col-md-12">
					<h3><small>Lengkapi data umum berikut mengenai component yang akan dibuat!</small></h3>
					<div class="form-group">
						<label class="col-md-4" for="compo_name">Component Name <span class="text-danger">*</span></label>
						<div class="col-md-8">
							<div class="input-group">
								<input type="text" id="compo_name" name="compo_name" class="form-control" placeholder="Type component name here..." required="" />
								<span class="input-group-addon"><i class="gi gi-ok_2"></i></span>
							</div>
							<div id="label-check"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4" for="compo_desc">Component Descriptions</label>
						<div class="col-md-8">
							<textarea id="compo_desc" name="compo_desc" class="form-control" placeholder="Type component descriptions here..."></textarea>
						</div>
					</div>
				</div>
			</div>
			<div id="second" class="step">
				<div class="wizard-steps">
					<div class="row">
						<div class="col-xs-4 done"><span>General</span></div>
						<div class="col-xs-4 active"><span>Database</span></div>
						<div class="col-xs-4"><span>Finish</span></div>
					</div>
				</div>
				<div class="col-md-12">
					<h3><small>Lengkapi data table dan field di bawah ini! Ingat, field harus lebih dari 3 (tiga).</small></h3>
					<div class="form-group">
						<label class="col-md-4" for="compo_table">Component Table <span class="text-danger">*</span></label>
						<div class="col-md-8">
							<div class="input-group">
								<input type="text" id="compo_table" name="compo_table" class="form-control" placeholder="Type component table here..." required="" />
								<span class="input-group-addon"><i class="gi gi-ok_2"></i></span>
							</div>
							<div id="label-check-table"></div>
						</div>
					</div>
					<div class="col-md-12" style="margin-top:10px;">
						<label>Field 1 <span class="text-danger">* <i>field pertama akan dijadikan sebagai primary key (auto increment)</i></span></label>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="compo_field_name_1">Field Name <span class="text-danger">*</span></label>
									<input type="text" id="compo_field_name_1" name="compo_field_name_1" class="form-control" placeholder="Type field name here..." required="" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="compo_field_type_1">Field Type</label>
									<select id="compo_field_type_1" name="compo_field_type_1" class="form-control" placeholder="Type field type here...">
										<option value="int">INTEGER</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="compo_field_length_value_1">Field Length / Values <span class="text-danger">*</span></label>
									<input type="text" id="compo_field_length_value_1" name="compo_field_length_value_1" class="form-control" placeholder="Type field length / value here..." required="" />
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12" style="margin-top:10px;">
						<label>Field 2 <span class="text-danger">*</span></label>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_name_2">Field Name <span class="text-danger">*</span></label>
									<input type="text" id="compo_field_name_2" name="ifield[2][compo_field_name]" class="form-control" placeholder="Type field name here..." required="" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_type_2">Field Type</label>
									<select id="compo_field_type_2" name="ifield[2][compo_field_type]" class="form-control" placeholder="Type field type here...">
										<option value="int">INTEGER</option>
										<option value="varchar">VARCHAR</option>
										<option value="text">TEXT</option>
										<option value="date">DATE</option>
										<option value="time">TIME</option>
										<option value="datetime">DATETIME</option>
										<option value="enum">ENUM</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_length_value_2">Field Length / Values</label>
									<input type="text" id="compo_field_length_value_2" name="ifield[2][compo_field_length_value]" class="form-control" placeholder="Type field length / value here..." />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_default_value_2">Field Default Values</label>
									<input type="text" id="compo_field_default_value_2" name="ifield[2][compo_field_default_value]" class="form-control" placeholder="Type field default / value here..." />
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12" style="margin-top:10px;">
						<label>Field 3 <span class="text-danger">*</span></label>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_name_3">Field Name <span class="text-danger">*</span></label>
									<input type="text" id="compo_field_name_3" name="ifield[3][compo_field_name]" class="form-control" placeholder="Type field name here..." required="" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_type_3">Field Type</label>
									<select id="compo_field_type_3" name="ifield[3][compo_field_type]" class="form-control" placeholder="Type field type here...">
										<option value="int">INTEGER</option>
										<option value="varchar">VARCHAR</option>
										<option value="text">TEXT</option>
										<option value="date">DATE</option>
										<option value="time">TIME</option>
										<option value="datetime">DATETIME</option>
										<option value="enum">ENUM</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_length_value_3">Field Length / Values</label>
									<input type="text" id="compo_field_length_value_3" name="ifield[3][compo_field_length_value]" class="form-control" placeholder="Type field length / value here..." />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_default_value_3">Field Default Values</label>
									<input type="text" id="compo_field_default_value_3" name="ifield[3][compo_field_default_value]" class="form-control" placeholder="Type field default / value here..." />
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12" style="margin-top:10px;">
						<label>Field 4 <span class="text-danger">*</span></label>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_name_4">Field Name <span class="text-danger">*</span></label>
									<input type="text" id="compo_field_name_4" name="ifield[4][compo_field_name]" class="form-control" placeholder="Type field name here..." required="" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_type_4">Field Type</label>
									<select id="compo_field_type_4" name="ifield[4][compo_field_type]" class="form-control" placeholder="Type field type here...">
										<option value="int">INTEGER</option>
										<option value="varchar">VARCHAR</option>
										<option value="text">TEXT</option>
										<option value="date">DATE</option>
										<option value="time">TIME</option>
										<option value="datetime">DATETIME</option>
										<option value="enum">ENUM</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_length_value_4">Field Length / Values</label>
									<input type="text" id="compo_field_length_value_4" name="ifield[4][compo_field_length_value]" class="form-control" placeholder="Type field length / value here..." />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="compo_field_default_value_4">Field Default Values</label>
									<input type="text" id="compo_field_default_value_4" name="ifield[4][compo_field_default_value]" class="form-control" placeholder="Type field default / value here..." />
								</div>
							</div>
						</div>
					</div>
					<div id="append-add-field"></div>
					<div class="col-md-12 text-center" style="margin-top:10px;">
						<a class="btn btn-sm btn-success btn-add-field" id="5">Add New Field</a>
					</div>
				</div>
			</div>
			<div id="third" class="step">
				<div class="wizard-steps">
					<div class="row">
						<div class="col-xs-4 done"><span>General</span></div>
						<div class="col-xs-4 done"><span>Database</span></div>
						<div class="col-xs-4 active"><span>Finish</span></div>
					</div>
				</div>
				<div class="col-md-12">
					<h3><small>Lengkapi tahap terakhir! Pada bagian action tentukan action apa saja yang ingin ada dalam component.</small></h3>
					<div class="form-group">
						<label class="col-md-4" for="compo_action">Component Action <span class="text-danger">*</span></label>
						<div class="col-md-8">
							<select id="compo_action" name="compo_action" class="form-control" placeholder="Select component action here...">
								<option value="0">All</option>
								<option value="1">Only Add</option>
								<option value="2">Only Edit</option>
								<option value="3">Only Delete</option>
								<option value="4">Add and Edit</option>
								<option value="5">Add and Delete</option>
								<option value="6">Edit and Delete</option>
								<option value="7">None</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4" for="compo_seourl">Field For Seo URL</label>
						<div class="col-md-8">
							<input type="text" id="compo_seourl" name="compo_seourl" class="form-control" placeholder="Type field for seo url..." />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4" for="compo_browse">Field For Browse File / Picture</label>
						<div class="col-md-8">
							<input type="text" id="compo_browse" name="compo_browse" class="form-control" placeholder="Type field for browse file / picture..." />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4"><a href="#modal-terms" data-toggle="modal">Terms and Conditions</a> <span class="text-danger">*</span></label>
						<div class="col-md-8">
							<label class="switch switch-primary" for="compo_accept">
								<input type="checkbox" id="compo_accept" name="compo_accept" value="1" />
								<span data-toggle="tooltip" title="I agree to the terms and conditions!"></span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group form-actions">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<input type="reset" class="btn btn-sm btn-warning" id="back2" value="Back Step" />
					<input type="submit" class="btn btn-sm btn-primary" id="next2" value="Next Step" />
				</div>
			</div>
		</form>
	</div>
	<div id="modal-terms" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title"><i class="gi gi-pen"></i> Terms and Conditions</h3>
				</div>
				<div class="modal-body">
					<p>
						<ol>
							<li>Pastikan sebelum menggunakan CompoGen semua file web dan database telah dibackup. Karena kami tidak bertanggungjawab jika terjadi kesalahan dalam proses generator nantinya.</li>
							<li>CompoGen akan membuat component standart secara otomatis. Component yang digenerate dari CompoGen adalah component untuk proses CRUD (Create Read Update Delete) data biasa. Untuk customize lebih lanjut kami serahkan ke developer.</li>
							<li>Cara kerja CompoGen adalah akan membuat file component baru dengan otomatis mengenerate table baru di database. Setelah itu akan langsung menginstal component baru ini ke daftar component sehingga dapat langsung dipakai.</li>
						</ol>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Ok, I've read them!</button>
				</div>
			</div>
		</div>
	</div>
	<p style="width:100%; height:100px;">&nbsp;</p>
<?php
	break;
}
?>
<?php
	}else{
?>
    <div class="content-header">
        <div class="header-section">
            <h1><i class="gi gi-warning_sign"></i>404<small> <?=$langpagenotfound1;?></small><br /><br /></h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="admin.php?mod=home"><?=$langmenu1;?></a></li>
        <li>Error</li>
    </ul>
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
}
?>