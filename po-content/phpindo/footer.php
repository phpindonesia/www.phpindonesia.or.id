<?php if ($mod==""){
	header('location:../../404.php');
}else{
?>
		<!-- **Footer** -->
        <footer id="footer">
			<div class="full-width-section grey">	  
            	<div class="dt-sc-margin30"></div>
                <div class="container">
                    <div class="newsletter-container">                                            
                        <div class="dt-sc-one-half column first">
                            <div class="newsletter-content">
                            	<span class="fa fa-envelope"></span>
                        		<h3>Newsletter Subscription</h3>
                            </div>
                        </div>
                        <div class="dt-sc-one-half column">
                            <form method="post" class="newsletter-form" name="frmNewsletterContent" action="<?=$website_url;?>/subscribe.php">
                                <input required="" placeholder="Enter Your Email ID" name="email_address" type="email">
                                <input value="Submit" class="button" name="submit" type="submit">
                            </form>
                            <div id="ajax_newsletter_msg_content"></div>
                        </div>
                    </div> 
                </div>
                <div class="dt-sc-margin30"></div>
            </div>

        	<div class="footer-widgets-wrapper type2">
                <div class="container">
                    <div class="column dt-sc-one-fourth first">
                        <aside class="widget widget_contact">
                        	<h3 class="widget-title" style="padding:0px;">PHP Indonesia</h3> 
                            <div class="textwidget">
                                <p>PHP Indonesia is a community for everyone that loves PHP. Our focus is in the PHP world but our topics encompass the entire LAMP stack. Topics include PHP coding, to memcached handling, db optimizations, server stack, web server tuning, code deploying, hosting options and much much more.</p>
                            </div>
                        </aside>
                    </div>

                    <div class="column dt-sc-one-fourth">
                        <aside class="widget widget_links">
                            <h3 class="widget-title"><span class="fa fa-sitemap"></span>Sitemap</h3> 
                            <ul>
                            	<li><a href="<?=$website_url;?>/pages/sejarah">Sejarah</a></li>
								<li><a href="<?=$website_url;?>/pages/struktur-organisasi">Struktur Organisasi</a></li>
								<li><a href="<?=$website_url;?>/pages/kepengurusan">Kepengurusan</a></li>
								<li><a href="<?=$website_url;?>/pages/program-kerja">Program Kerja</a></li>
								<li><a href="<?=$website_url;?>/pages/ad-art">AD/ART</a></li>
								<li><a href="<?=$website_url;?>/pages/surat-keputusan">Surat Keputusan</a></li>
                            </ul>
                        </aside>
                    </div>

					<div class="column dt-sc-one-fourth">
                        <aside class="widget widget_links">
                            <h3 class="widget-title"><span class="fa fa-link"></span>Web Lainnya</h3> 
                            <ul>
								<li><a href="http://forum.phpindonesia.or.id" target="_blank">Forum</a></li>
                            	<li><a href="http://member.phpindonesia.or.id" target="_blank">Membership</a></li>
                                <li><a href="http://www.phpindonesia.net" target="_blank">Tutorial</a></li>
                            </ul>
                        </aside>
                    </div>

                    <div class="column dt-sc-one-fourth">
                        <aside class="widget widget_links">
                            <h3 class="widget-title"><span class="fa fa-photo"></span>Media</h3> 
                            <ul>
                            	<li><a href="<?=$website_url;?>/album">Photo</a></li>
                                <li><a href="<?=$website_url;?>/valbum">Video</a></li>
                                <li><a href="https://www.facebook.com/groups/35688476100" target="_blank">Facebook</a></li>
                                <li><a href="https://www.twitter.com/php_indonesia" target="_blank">Twitter</a></li>
                                <li><a href="http://www.youtube.com/user/OurPHPIndonesia" target="_blank">Youtube</a></li>
                            </ul>
                        </aside>
                    </div>
                </div>
        	</div><!-- **footer-widgets-wrapper - End** -->

            <div class="copyright type2">
            	<div class="container">
                	<p>PHP Indonesia Community &copy; 2015. <a href="<?=$website_url;?>/pages/developer">Design By PHP Indonesia Web Team</a></p>
                    <ul class="footer-links">
                    	<li>Web Hosted By <a href="<?=$website_url;?>/pages/hosted">Muhammad Saleh Hafizh Fajri</a></li>
                    </ul>
                </div>
            </div>
        </footer> <!-- **Footer - End** -->
	</div><!-- **inner-wrapper - End** -->
</div><!-- **Wrapper - End** -->

<!-- **jQuery** -->  
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/js/jquery-migrate.min.js"></script>
<script data-cfasync="false" type="text/javascript">var lsjQuery = jQuery;</script><script data-cfasync="false" type="text/javascript"> lsjQuery(document).ready(function() { if(typeof lsjQuery.fn.layerSlider == "undefined") { lsShowNotice('layerslider_9','jquery'); } else { lsjQuery("#layerslider_9").layerSlider({responsiveUnder: 1240, layersContainer: 1170, startInViewport: false, pauseOnHover: false, forceLoopNum: false, autoPlayVideos: false, skinsPath: '<?=$website_url;?>/po-content/<?=$folder;?>/js/layerslider/skins/'}) } }); </script>
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/js/twitter/jquery.tweet.min.js"></script>
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/js/jquery.donutchart.js"></script>
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/js/okzoom.min.js"></script>
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/js/plugins.js"></script>
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/js/custom.js"></script>
</body>
</html>
<?php } ?>