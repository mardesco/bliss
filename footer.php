<?php
//footer.php
?>

	<footer class="site-footer small">
    	<div class="content">
        <!--  <p>This is the footer.</p> -->
        
            <?php
			  wp_nav_menu(array(
				  'theme_location' => 'footer-nav',
				  'container' => 'nav',
				  'container_id' => 'footerNav',
				  'container_class' => 'clearfix'
				  ));
            ?>
            <p class="credit spacer">
				<?php
				printf(
				__( 'Copyright &#169; %d by %s. Powered by <a rel="nofollow" href="%s">Bliss</a> for <a rel="nofollow" href="%s">WordPress</a>', 'bliss' ),
				date('Y'), esc_attr(get_bloginfo('name')), 'http://www.mardesco.com/themes/bliss/', 'http://www.wordpress.org' );
            	?>
            </p>
		</div>    

		<?php wp_footer(); ?>
		
	</footer>
</div> <!--! end of #container -->
        
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
        
    </body>
</html>