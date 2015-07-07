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
			$title = $val->validasi($_GET['ida'],'xss');
			$tablealb = new PoTable('album');
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
                    	<h1>Galeri Photo</h1>
                        <div class="breadcrumb">
                            <a href="<?=$website_url;?>">Home</a>
                            <span class="fa fa-angle-right"></span>
                            <a href="<?=$website_url;?>/album">Galeri Photo</a>
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
                    <!-- **portfolio-container - Starts** -->
                    <div class="portfolio-container">
					<?php
						$p = new Paging;
						$batas = 12;
						$posisi = $p->cariPosisi($batas);
						$tablegal = new PoTable('gallery');
						$gallerys = $tablegal->findAllLimitBy(id_gallery, id_album, $idalb, DESC, "$posisi,$batas");
						foreach($gallerys as $gallery){
							$idalb = $gallery->id_album;
							$tablecalb = new PoTable('album');
							$currentCalb = $tablecalb->findBy(id_album, $idalb);
							$currentCalb = $currentCalb->current();
							if ($currentCalb->active == 'Y'){
							?>
						<div class="portfolio dt-sc-one-fourth column with-space">
                            <!-- **portfolio-thumb - Starts** -->
                            <div class="portfolio-thumb">
                                <img src="<?=$website_url;?>/po-content/po-upload/medium/medium_<?=$gallery->picture;?>" alt="<?=$gallery->title;?>" />
                                <div class="image-overlay">
                                    <a class="zoom" href="<?=$website_url;?>/po-content/po-upload/<?=$gallery->picture;?>" data-gal="prettyPhoto[gallery]"><span class="fa fa-search"></span></a>
                                </div>
                            </div> <!-- **portfolio-thumb - Ends** -->
                            <!-- **portfolio-detail - Starts** -->
                            <div class="portfolio-detail">
                                <div class="views"><span class="fa fa-image"></span></div>
                                <div class="portfolio-title" style="padding: 13px 10px 15px 75px;">
                                    <h5><?=$gallery->title;?></h5>
                                </div>
                            </div> <!-- **portfolio-detail - Ends** -->
                        </div>
							<?php
							}
						}
					?>
					</div> <!-- **portfolio-container - Ends** -->
                	<!-- **pagination - Starts** -->  
                    <div class="pagination">
                        <ul>
                        	<?php
								$getpage = $val->validasi($_GET['page'],'sql');
								$jmldata = $tablegal->numRowBy(id_album, $idalb);
								$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
								$linkHalaman = $p->navHalaman($getpage, $jmlhalaman, $website_url, "gallery/$title", "page", "1");
								echo "$linkHalaman";
							?>
                        </ul>
                    </div> <!-- **pagination - Ends** -->
                	<div class="dt-sc-margin50"></div>
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