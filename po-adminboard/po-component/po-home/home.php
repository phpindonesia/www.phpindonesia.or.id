<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])) {
	header('location:404.php');
} else {
	if ($_SESSION[leveluser] == '1' OR $_SESSION[leveluser] == '2') {
		$table1  = new PoTable('post');
		$total1  = $table1->numRow();
		$table2  = new PoTable('category');
		$total2  = $table2->numRow();
		$table3  = new PoTable('tag');
		$total3  = $table3->numRow();
		$table4  = new PoTable('media');
		$total4  = $table4->numRow();
		$table5  = new PoTable('pages');
		$total5  = $table5->numRow();
		$table6  = new PoTable('component');
		$total6  = $table6->numRow();
		$table7  = new PoTable('users');
		$total7  = $table7->numRow();
		$table8  = new PoTable('comment');
		$total8  = $table8->numRowBy(status, 'N');
		$table9  = new PoTable('contact');
		$total9  = $table9->numRowBy(status, 'N');
		$total10 = mysql_query("SELECT * FROM post,users WHERE users.id_user = post.editor AND users.level = '3' AND post.active = 'N'");
		$total10 = mysql_num_rows($total10);
		include "po-component/po-home/traffic.php";
		$visitorc = $currentStat3 + $currentStat4 + $currentStat5 + $currentStat6;
		$hitsc    = $sql_hits3 + $sql_hits4 + $sql_hits5 + $sql_hits6;
?>
	<div class="content-header">
		<div class="header-section">
			<div class="row">
				<div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
					<h1><?=$langhome1;?>
					<small><?=$langhome2;?></small></h1>
				</div>
				<div class="col-md-8 col-lg-6"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<?php if ($total8 != "0") { ?>
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=comment" class="widget-icon pull-left themed-background-default animation-fadeIn"><i class="fa fa-comments"></i></a>
					<h3><?=$langhome17;?> <a href="admin.php?mod=comment" class="alert-link"><?=$total8;?> <?=$langhome18;?>!</a></h3>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if ($total9 != "0") { ?>
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=contact" class="widget-icon pull-left themed-background-default animation-fadeIn"><i class="fa fa-envelope"></i></a>
					<h3><?=$langhome17;?> <a href="admin.php?mod=contact" class="alert-link"><?=$total9;?> <?=$langhome19;?>!</a></h3>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if ($total10 != "0") { ?>
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=post" class="widget-icon pull-left themed-background-default animation-fadeIn"><i class="fa fa-book"></i></a>
					<h3><?=$langhome17;?> <a href="admin.php?mod=post" class="alert-link"><?=$total10;?> <?=$langhome23;?>!</a></h3>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="col-sm-6 col-lg-3">
			<div class="widget">
				<div class="widget-simple">
					<a href="#" class="widget-icon pull-left themed-background-default animation-fadeIn"><i class="fa fa-signal"></i></a>
					<h3 class="widget-content text-right animation-pullDown"><?=$hitsc;?> <strong><?=$langhome14;?></strong><small><?=$visitorc;?> <?=$langhome13;?></small></h3>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=post" class="widget-icon pull-left themed-background-fire animation-fadeIn"><i class="fa fa-book"></i></a>
					<h3 class="widget-content text-right animation-pullDown"><strong><?=$total1;?></strong><small><?=$langhome4;?></small></h3>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=category" class="widget-icon pull-left themed-background-amethyst animation-fadeIn"><i class="fa fa-tasks"></i></a>
					<h3 class="widget-content text-right animation-pullDown"><strong><?=$total2;?></strong><small><?=$langhome5;?></small></h3>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=tag" class="widget-icon pull-left themed-background-modern animation-fadeIn"><i class="fa fa-tags"></i></a>
					<h3 class="widget-content text-right animation-pullDown"><strong><?=$total3;?></strong><small><?=$langhome6;?></small></h3>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=library" class="widget-icon pull-left themed-background-autumn animation-fadeIn"><i class="fa fa-picture-o"></i></a>
					<h3 class="widget-content text-right animation-pullDown"><strong><?=$total4;?></strong><small><?=$langhome7;?></small></h3>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=pages" class="widget-icon pull-left themed-background-flatie animation-fadeIn"><i class="fa fa-file-text"></i></a>
					<h3 class="widget-content text-right animation-pullDown"><strong><?=$total5;?></strong><small><?=$langhome8;?></small></h3>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=component" class="widget-icon pull-left themed-background-spring animation-fadeIn"><i class="fa fa-puzzle-piece"></i></a>
					<h3 class="widget-content text-right animation-pullDown"><strong><?=$total6;?></strong><small><?=$langhome9;?></small></h3>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<div class="widget">
				<div class="widget-simple">
					<a href="admin.php?mod=user" class="widget-icon pull-left themed-background-fancy animation-fadeIn"><i class="fa fa-users"></i></a>
					<h3 class="widget-content text-right animation-pullDown"><strong><?=$total7;?></strong><small><?=$langhome10;?></small></h3>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
		<?php
			$selectlangid = ($localLang == 'indonesia') ? 'selected' : '';
			$selectlangen = ($localLang == 'english') ? 'selected' : '';
		?>
			<div class="block">
				<div class="block-title"><h2><?=$langhome20;?></h2></div>
				<form action="admin.php?mod=home" method="post" class="form-horizontal form-bordered">
					<div class="form-group">
						<p>&nbsp;</p>
						<label class="col-md-4 control-label" for="example-chosen"><?=$langhome16;?></label>
						<div class="col-md-6">
							<select id="example-chosen" class="select-chosen" name="Lang" onChange="submit()">
								<option value="indonesia" <?=$selectlangid;?>>Indonesia</option>
								<option value="english" <?=$selectlangen;?>>English</option>
							</select>
							&nbsp;
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-9 col-md-offset-3" style="height:33px;"></div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-6">
			<div class="block">
				<div class="block-title"><h2><?=$langhome21;?></h2></div>
				<form id="form-validation" action="po-component/po-home/proses.php" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
					<div class="form-group">
						<label class="col-md-4 control-label" for="example-chosen">One Click Backup DB :</label>
						<div class="col-md-6">
							<a href="po-component/po-home/proses.php?mod=home&act=backup" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Backup DB</a>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="example-chosen">One Click Restore DB :</label>
						<div class="col-md-6">
							<input type="hidden" name="mod" value="home">
							<input type="hidden" name="act" value="restore">
							<input type="file" id="example-file-input" name="fupload" required>
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-9 col-md-offset-3">
							<button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-upload"></i> Restore DB</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="block full">
				<div class="block-title">
					<h2><?=$langhome11;?></h2>
				</div>
				<div id="chart-classic" class="chart"></div>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="content-header content-header-media">
		<div class="header-section">
			<div class="row">
				<div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
					<h1><?=$langhome1;?>
					<small><?=$langhome22;?></small></h1>
				</div>
				<div class="col-md-8 col-lg-6"></div>
			</div>
		</div>
		<img src="images/dashboard_header.jpg" alt="Header Image" class="animation-pulseSlow" />
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<div class="widget">
								<div class="widget-simple">
									<a href="admin.php?mod=post" class="widget-icon pull-left themed-background-fire animation-fadeIn"><i class="fa fa-book"></i></a>
									<h3 class="widget-content text-right animation-pullDown"><strong><?=$langhome4;?></strong></h3>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="widget">
								<div class="widget-simple">
									<a href="admin.php?mod=category" class="widget-icon pull-left themed-background-amethyst animation-fadeIn"><i class="fa fa-tasks"></i></a>
									<h3 class="widget-content text-right animation-pullDown"><strong><?=$langhome5;?></strong></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<div class="widget">
								<div class="widget-simple">
									<a href="admin.php?mod=tag" class="widget-icon pull-left themed-background-modern animation-fadeIn"><i class="fa fa-tags"></i></a>
									<h3 class="widget-content text-right animation-pullDown"><strong><?=$langhome6;?></strong></h3>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="widget">
								<div class="widget-simple">
									<a href="admin.php?mod=user" class="widget-icon pull-left themed-background-fancy animation-fadeIn"><i class="fa fa-users"></i></a>
									<h3 class="widget-content text-right animation-pullDown"><strong><?=$langmenu27;?></strong></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
		<?php
			$selectlangid = ($localLang == 'indonesia') ? 'selected' : '';
			$selectlangen = ($localLang == 'english') ? 'selected' : '';
		?>
			<div class="block">
				<div class="block-title"><h2><?=$langhome20;?></h2></div>
				<form action="admin.php?mod=home" method="post" class="form-horizontal form-bordered">
					<div class="form-group">
						<p>&nbsp;</p>
						<label class="col-md-4 control-label" for="example-chosen"><?=$langhome16;?></label>
						<div class="col-md-6">
							<select id="example-chosen" class="select-chosen" name="Lang" onChange="submit()">
								<option value="indonesia" <?=$selectlangid;?>>Indonesia</option>
								<option value="english" <?=$selectlangen;?>>English</option>
							</select>
							&nbsp;
						</div>
					</div>
					<div class="form-group form-actions">
						<div class="col-md-9 col-md-offset-3" style="height:8px;"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	}
}
?>