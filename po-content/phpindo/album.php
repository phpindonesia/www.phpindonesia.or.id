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
		<!-- **Main - Starts** -->
		<div id="main">
        	<div class="breadcrumb-wrapper type2">
            	<div class="container">
                	<div class="main-title">
                    	<h1>Galeri Photo</h1>
                        <div class="breadcrumb">
                            <a href="<?=$website_url;?>">Home</a>
                            <span class="fa fa-angle-right"></span>
                            <span class="current">Galeri Photo</span>
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
							$batas = 8;
							$posisi = $p->cariPosisi($batas);
							$tablealb = new PoTable('album');
							$dataalbs = $tablealb->findAllLimit(id_album, "DESC", "$posisi,$batas");
							foreach ($dataalbs as $dataalb) {
								$tablegal = new PoTable('gallery');
								$datagals = $tablegal->findByDESC(id_album, $dataalb->id_album, id_gallery);
								$datagal = $datagals->current();
						?>
						<div class="portfolio dt-sc-one-third column with-space">
                            <!-- **portfolio-thumb - Starts** -->
                            <div class="portfolio-thumb">
                                <img src="<?=$website_url;?>/po-content/po-upload/medium/medium_<?=$datagal->picture;?>" alt="<?=$dataalb->title;?>" />
                                <div class="image-overlay">
                                    <a class="link" href="<?=$website_url;?>/gallery/<?=$dataalb->seotitle;?>"><span class="fa fa-link"></span></a>
                                </div>
                            </div> <!-- **portfolio-thumb - Ends** -->
                            <!-- **portfolio-detail - Starts** -->
                            <div class="portfolio-detail">
                                <div class="views"><span class="fa fa-image"></span></div>
                                <div class="portfolio-title" style="padding: 13px 10px 15px 75px;">
                                    <h5><a href="<?=$website_url;?>/gallery/<?=$dataalb->seotitle;?>"><?=$dataalb->title;?></a></h5>
                                </div>
                            </div> <!-- **portfolio-detail - Ends** -->
                        </div>
						<?php } ?>
					</div> <!-- **portfolio-container - Ends** -->
                	<!-- **pagination - Starts** -->  
                    <div class="pagination">
                        <ul>
                        	<?php
								$getpage = $val->validasi($_GET['page'],'sql');
								$jmldata = $tablealb->numRow();
								$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
								$linkHalaman = $p->navHalaman($getpage, $jmlhalaman, $website_url, "album", "page", "1");
								echo "$linkHalaman";
							?>
                        </ul>
                    </div> <!-- **pagination - Ends** -->
                	<div class="dt-sc-margin50"></div>
                </section>
            </div> <!-- **container - Ends** -->
        </div> <!-- **Main - Ends** -->


<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php include_once "po-content/$folder/footer.php"; ?>
<?php } ?>