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
			$title = $val->validasi($_GET['idp'],'xss');
			$tablepag = new PoTable('pages');
			$currentPag = $tablepag->findByAnd(seotitle, $title, active, 'Y');
			$currentPag = $currentPag->current();
			$idpag = $currentPag->id_pages;
			$content = $currentPag->content;
			$content = html_entity_decode($content);
		?>
		<?php if ($currentPag != "0"){ ?>
		<!-- **Main - Starts** --> 
		<div id="main">
        	<div class="breadcrumb-wrapper type2">
            	<div class="container">
                	<div class="main-title">
                    	<h1><?=$currentPag->title;?></h1>
                        <div class="breadcrumb">
                            <a href="<?=$website_url;?>">Home</a>
                            <span class="fa fa-angle-right"></span>
                            <span class="current"><?=$currentPag->title;?></span>
                        </div>
                    </div>
                </div>
            </div>
			<!-- **Full-width-section - Starts** -->       
			<div class="full-width-section">
				<div class="dt-sc-margin70"></div> 
                <div class="container">
					<div class="hr-title dt-sc-hr-invisible-small">
						<h3><?=$currentPag->title;?></h3>
						<div class="title-sep"></div>
                    </div>
                    <!-- **column - Starts** -->
                    <article class="blog-post">
						<div class="entry-body">
							<?=$content;?>
						</div>
					</article>
				</div>
			</div> <!-- **container - Starts** -->
            <div class="dt-sc-margin30"></div>

			<?php
			if ($idpag == '2') {
			?>
            <div class="full-width-section">
                <div class="container">
                    <h2 class="aligncenter">Jejak Sejarah</h2>
                    <div class="dt-sc-hr-invisible-small"></div>
                    <div class="dt-sc-timeline-wrapper">
                        <div class="dt-sc-timeline-team right">
                            <div class="column dt-sc-one-half first">
                                <div class="dt-sc-hr-invisible"></div>
                            </div>
                            <div class="column dt-sc-one-half">
                                <div class="dt-sc-hr-invisible"></div>
                                <!-- **dt-sc-team - Starts** -->
                                <div class="dt-sc-team type4">
									<div class="image"><img src="<?=$website_url;?>/po-content/<?=$folder;?>/images/2008.jpg" alt="2008"/></div>
                                    <!-- **team-details - Starts** -->
                                    <div class="team-details">
                                        <h6>6 Februari 2008</h6>
                                        <p>Pertemuan di salah satu Café di kemang yang di hadiri antara lain oleh Sonny Arlianto Kurniawan dan Rama Yurindra</p>
                                    </div> <!-- **team-details - Ends** -->
                                </div><!-- **dt-sc-team - Ends** -->
                            </div>
                        </div> <!-- **dt-sc-timeline-team right - Ends** -->
                        
                        <div class="dt-sc-timeline-team left">
                            <div class="column dt-sc-one-half first">
                                <!-- **dt-sc-team - Starts** -->
                                <div class="dt-sc-team type4">
									<div class="image"><img src="<?=$website_url;?>/po-content/<?=$folder;?>/images/2008.jpg" alt="2008"/></div>
                                    <!-- **team-details - Starts** -->
                                    <div class="team-details">
                                        <h6>8 Februari 2008</h6>
                                        <p>Membentuk Group diskusi online di facebook yang dibuat pada tanggal 8 Februari 2008 oleh Sonny Arlianto Kurniawan, atas usulan Rama Yurindra</p>
                                    </div> <!-- **team-details - Ends** -->
                                </div><!-- **dt-sc-team - Ends** -->
                            </div>
                            <div class="column dt-sc-one-half">
                                <div class="dt-sc-hr-invisible"></div>
                            </div>
                        </div> <!-- **dt-sc-timeline-team left - Ends** -->
                        
                        <div class="dt-sc-timeline-team right">
                            <div class="column dt-sc-one-half first">
                                <div class="dt-sc-hr-invisible"></div>
                            </div>
                            <div class="column dt-sc-one-half">
                                <!-- **dt-sc-team - Starts** -->
                                <div class="dt-sc-team type4">
                                    <div class="image"><img src="<?=$website_url;?>/po-content/<?=$folder;?>/images/2012.jpg" alt="2012"/></div>
                                    <!-- **team-details - Starts** -->
                                    <div class="team-details">
                                        <h6>31 Maret 2012</h6>
                                        <p>Bertempat di Auditorium PT Microsoft Gedung BEJ II lt 19, Jakarta, diadakan Gathering anggota untuk menyusun struktur organisasi dan membentuk perwakilan di tiap daerah</p>
                                    </div> <!-- **team-details - Ends** -->
                                </div><!-- **dt-sc-team - Ends** -->
                            </div>
                        </div> <!-- **dt-sc-timeline-team right - Ends** -->
                        
                        <div class="dt-sc-timeline-team left">
                            <div class="column dt-sc-one-half first">
                                <!-- **dt-sc-team - Starts** -->
                                <div class="dt-sc-team type4">
                                    <div class="image"><img src="<?=$website_url;?>/po-content/<?=$folder;?>/images/2015.jpg" alt="2015"/></div>
                                    <!-- **team-details - Starts** -->
                                    <div class="team-details">
                                        <h6>2015 Sekarang</h6>
                                        <p>PHP Indonesia telah memiliki member sebanyak 81.000 dengan perwakilan di 14 Provinsi</p>
                                    </div> <!-- **team-details - Ends** -->
                                </div><!-- **dt-sc-team - Ends** -->
                            </div>
                            <div class="column dt-sc-one-half">
                                <div class="dt-sc-hr-invisible"></div>
                            </div>
                        </div> <!-- **dt-sc-timeline-team left - Ends** -->
                    </div> <!-- **dt-sc-timeline-wrapper - Ends** -->
                </div> <!-- **container - Ends** -->
            </div>
            <div class="dt-sc-margin90"></div>
			<?php } ?>
		</div>
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