<?php if ($mod==""){
	header('location:../../404.php');
}else{
?>
<!-- 
*******************************************************
	Include Header Template
******************************************************* 
-->
<?php include_once "po-content/$folder/header.php"; ?>


<!-- 
*******************************************************
	Main Content Template
******************************************************* 
-->
		<div id="main">
        	<div class="breadcrumb-wrapper type2">
            	<div class="container">
                	<div class="main-title">
                    	<h1>Event</h1>
                        <div class="breadcrumb">
                            <a href="<?=$website_url;?>">Home</a>
                            <span class="fa fa-angle-right"></span>
                            <span class="current">Event PHP Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>
			<!-- **Full-width-section - Starts** -->
			<div class="full-width-section">
				<div class="dt-sc-margin70"></div>
				<section id="primary" class="content-full-width">
					<div class="container">
					<?php
						$p = new Paging;
						$nov = 1;
						$batas = 12;
						$posisi = $p->cariPosisi($batas);
						$tableevt = new PoTable('event');
						$dataevents = $tableevt->findAllLimit(startevt, "DESC", "$posisi,$batas");
						foreach ($dataevents as $dataevent) {
							$idevt = $dataevent->id_event;
							$startevt = $dataevent->startevt;
							$startevt = explode(' ', $startevt);
							$startsth = substr($startevt[0],0,4);
							$startshr = substr($startevt[0],8,2);
							$startbshr = substr(getBulan(substr($startevt[0],5,2)),0,3);
							$endevt = $dataevent->endevt;
							$endevt = explode(' ', $endevt);
					?>
						<?php if ($nov % 3 == 1) { ?>
						<div class="column dt-sc-one-third first">
						<?php } else { ?>
						<div class="column dt-sc-one-third">
						<?php } ?>
							<!-- **Blog-post - Starts** --> 
							<article class="blog-post">
								<!-- **entry-meta - Starts** -->
								<div class="entry-meta">
									<div class="date">
										<p><span><?=$startshr;?></span><br/><?=$startbshr;?></p>
									</div>
									<div class="post-comments" style="color:#fff;">
										<?=$startsth;?>
									</div>
								</div> <!-- **entry-meta - Ends** -->
								<div class="entry-post-content">
									<!-- **entry-detail - Starts** -->
									<div class="entry-detail">
										<div class="entry-title">
											<h4><a href="<?php echo "$website_url/event/$dataevent->seotitle"; ?>"><?=cuthighlight('title', $dataevent->title, '25');?>...</a></h4>
										</div>
										<div class="entry-body">
											<p style="font-size:10px; color:#478BCA; margin-bottom:5px; margin-top:5px;">
												<span class="fa fa-calendar"></span> <?=tgl_indo($startevt[0]);?> - <?=tgl_indo($endevt[0]);?> |
												<span class="fa fa-clock-o"></span> 
												<?php if($startevt[1] == "00:00:00"){ ?>
													Seharian
												<?php }else{ ?>
													<?=$startevt[1];?> - <?=$endevt[1];?>
												<?php } ?>
											</p>
											<p><?=cuthighlight('post', $dataevent->content, '150');?>...</p>
										</div>
									</div> <!-- **entry-detail - Ends** -->
								</div>
							</article> <!-- **Blog-post - Ends** -->
						</div>
						<?php $nov++; } ?>
						<!-- **pagination - Starts** -->  
						<div class="pagination">
							<ul>
								<?php
									$getpage = $val->validasi($_GET['page'],'sql');
									$jmldata = $tableevt->numRow();
									$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
									$linkHalaman = $p->navHalaman($getpage, $jmlhalaman, $website_url, "listevent", "page", "1");
									echo "$linkHalaman";
								?>
							</ul>
						</div> <!-- **pagination - Ends** -->
						<div class="dt-sc-margin50"></div>
					</div> <!-- **container - Ends** -->
				</section>
			</div>
        </div> <!-- **Main - Ends** -->


<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php include_once "po-content/$folder/footer.php"; ?>
<?php } ?>