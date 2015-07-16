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
			$title = $val->validasi($_GET['ide'],'xss');
			$tableevt = new PoTable('event');
			$currentEvt = $tableevt->findByAnd(seotitle, $title, active, 'Y');
			$currentEvt = $currentEvt->current();
			$idevt = $currentEvt->id_event;
			$content = $currentEvt->content;
			$content = html_entity_decode($content);
			$startevt = $currentEvt->startevt;
			$startevt = explode(' ', $startevt);
			$endevt = $currentEvt->endevt;
			$endevt = explode(' ', $endevt);
		?>
		<?php if ($currentEvt != "0"){ ?>
		<!-- **Main - Starts** -->
		<div id="main">
        	<div class="breadcrumb-wrapper type2">
            	<div class="container">
                	<div class="main-title">
                    	<h1><?=$currentEvt->title;?></h1>
                        <div class="breadcrumb">
                            <a href="<?=$website_url;?>">Home</a>
                            <span class="fa fa-angle-right"></span>
                            <a href="<?=$website_url;?>/listevent">Event</a>
                            <span class="fa fa-angle-right"></span>
                            <span class="current">Detail Event</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dt-sc-margin70"></div>
			<!-- Container starts-->
			<div class="container">
                <!-- Primary Starts -->
				<section id="primary" class="content-full-width">
					<article class="blog-post">
						<div class="entry-body">
							<?=nl2br($content);?>
						</div>
					</article>
				</section>
            </div> <!-- **container - Ends** -->
			<div class="dt-sc-margin30"></div>

			<div class="intro-text type2">
            	<div class="container">
                    <div class="column dt-sc-two-third first">
                    	<div class="dt-sc-margin15"></div>
                        <div class="intro-content">
                        	<span class="fa fa-calendar"></span>
                        	<h3 class="dt-sc-margin30">Lihat Event-Event Lainnya dari PHP Indonesia</h3>
                        </div>
                    </div>
                    <div class="column dt-sc-one-third">
                    	<div class="dt-sc-margin10"></div>
                        <a href="<?=$website_url;?>/listevent" class="dt-sc-button large">Event Lainnya<span class="fa fa-angle-right"></span></a> 
                    </div>
                </div>
            </div>
        	<div class="dt-sc-margin50"></div>
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