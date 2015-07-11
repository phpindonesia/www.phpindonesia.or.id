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
		<?php
			$title = $val->validasi($_GET['idv'],'xss');
			$tablealb = new PoTable('valbum');
			$currentAlb = $tablealb->findByAnd(seotitle, $title, active, 'Y');
			$currentAlb = $currentAlb->current();
			$idalb = $currentAlb->id_album;
		?>
		<?php if ($currentAlb != "0"){ ?>
		<!-- **Main - Starts** -->
		<div id="main">
        	<div class="breadcrumb-wrapper type2">
            	<div class="container">
                	<div class="main-title">
                    	<h1>Galeri Video</h1>
                        <div class="breadcrumb">
                            <a href="<?=$website_url;?>">Home</a>
                            <span class="fa fa-angle-right"></span>
                            <a href="<?=$website_url;?>/valbum">Galeri Video</a>
                            <span class="fa fa-angle-right"></span>
                            <span class="current"><?=$currentAlb->title;?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dt-sc-margin100"></div>    
			<!-- Container starts-->
			<div class="container">
                <!-- Primary Starts -->
				<section id="primary" class="content-full-width">
					<article class="content">
                        <div class="column dt-sc-one-column first">
							<!-- **recent-gallery-container - Starts** -->
							<div class="recent-gallery-container">
								<!-- **recent-gallery - Starts** -->
								<ul class="recent-gallery">
								<?php
									$p = new Paging;
									$batas = 6;
									$posisi = $p->cariPosisi($batas);
									$tablevid = new PoTable('video');
									$videos = $tablevid->findAllLimitBy(id_video, id_album, $idalb, DESC, "$posisi,$batas");
									foreach($videos as $video){
								?>
										<li>
											<div class="video-container">
												<iframe width="560" height="315" src="<?=$video->url;?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
											</div>
										</li>
								<?php
									}
								?>
								</ul> <!-- **recent-gallery - Ends** -->
								<div class="dt-sc-margin10"></div>
								<!-- **bx-pager - Starts** -->
								<div id="bx-pager">
								<?php
									$p = new Paging;
									$nov = 1;
									$batas = 6;
									$posisi = $p->cariPosisi($batas);
									$tablevid = new PoTable('video');
									$videos = $tablevid->findAllLimitBy(id_video, id_album, $idalb, DESC, "$posisi,$batas");
									foreach($videos as $video){
								?>
										<a href="javascript:void(0);" data-slide-index="<?=$nov;?>"><img src="<?=$website_url;?>/po-content/po-thumbs/<?=$video->picture;?>" alt="<?=$video->title;?>" /></a>
								<?php
										$nov++;
									}
								?>
								</div> <!-- **bx-pager - Ends** -->	
							</div> <!-- **recent-gallery-container - Ends** -->
							<div class="dt-sc-margin30"></div>
							<!-- **pagination - Starts** -->  
							<div class="pagination">
								<ul>
									<?php
										$getpage = $val->validasi($_GET['page'],'sql');
										$jmldata = $tablevid->numRowBy(id_album, $idalb);
										$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
										$linkHalaman = $p->navHalaman($getpage, $jmlhalaman, $website_url, "video/$title", "page", "1");
										echo "$linkHalaman";
									?>
								</ul>
							</div> <!-- **pagination - Ends** -->
							<div class="dt-sc-margin50"></div>
						</div>
					</article>
                </section>
            </div> <!-- **container - Ends** -->
        </div> <!-- **Main - Ends** -->
		<?php
			}else{
				header('location:'.$website_url.'/404.php');
			}
		?>


<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php include_once "po-content/$folder/footer.php"; ?>
<?php } ?>