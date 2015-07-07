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
                    	<h1>Kontak</h1>
                        <div class="breadcrumb">
                            <a href="<?=$website_url;?>">Home</a>
                            <span class="fa fa-angle-right"></span>
                            <span class="current">Kontak</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Primary Starts -->
            <section id="primary" class="content-full-width">
				<div class="dt-sc-margin50"></div>
                <div class="container">
                    <div class="column dt-sc-three-fourth first">
                        <div class="hr-title">
                            <h3>Tinggalkan Pesan</h3>
                            <div class="title-sep">
                            </div>
                        </div>
                        <form method="post" class="dt-sc-contact-form" action="<?=$website_url;?>/contact.php" name="frmcontact">
                            <div class="column dt-sc-one-third first">
                                <p><span><input type="text" placeholder="Nama *" name="name_contact" value="" required /></span></p>
                            </div>
                            <div class="column dt-sc-one-third">
                                <p><span><input type="email" placeholder="Email *" name="email_contact" value="" required /></span></p>
                            </div>
                            <div class="column dt-sc-one-third">
                                <p><span><input type="text" placeholder="Subjek *" name="subject_contact" value="" required /></span></p>
                            </div>
                            <p><textarea placeholder="Pesan *" name="message_contact" required ></textarea></p>
                            <p><input type="submit" value="Kirim Pesan" name="submit" /></p>
                        </form>
                        <div id="ajax_contact_msg"></div>
                    </div>

                    <div class="column dt-sc-one-fourth">
                        <div class="hr-title">
                            <h3>Kontak Info</h3>
                            <div class="title-sep"></div>
                        </div>
                        <p class="dt-sc-contact-detail">PHP Indonesia Community : Sekretariat Jakarta</p>
                        <!-- **dt-sc-contact-info - Starts** -->
                        <div class="dt-sc-contact-info">
                            <p><i class="fa fa-location-arrow"></i> Jl. Cempaka Putih Timur XiV No.11.<br />Jakarta Pusat 10510</p>
                            <p><i class="fa fa-globe"></i><a href="http://www.phpindonesia.or.id">www.phpindonesia.or.id</a></p>
                            <p><i class="fa fa-envelope"></i><a href="#">info[at]phpindonesia.or.id</a></p>
                        </div> <!-- **dt-sc-contact-info - Ends** -->
                    </div>
                </div>
				<div class="dt-sc-margin80"></div>
			</section>
        </div> <!-- **Main - Ends** -->


<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php include_once "po-content/$folder/footer.php"; ?>
<?php } ?>