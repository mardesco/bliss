<?php
//footer.php
?>

	<footer class="site-footer">
    	<div class="content">
       
            <?php
			  wp_nav_menu(array(
				  'theme_location' => 'footer-nav',
				  'container' => 'nav',
				  'container_id' => 'footerNav',
				  'container_class' => 'clearfix small'
				  ));
            ?>			
			
			<?php 
			// version 0.1.5 introduces widget areas for the footer.
			if(is_active_sidebar('footer-widget') || is_active_sidebar('footer-widget-2') || is_active_sidebar('footer-widget-3')){
				?>
				<section class="thirds clear clearfix spacer small">
				<?php 
				// footer widgets here.
				if(is_active_sidebar('footer-widget')){
					dynamic_sidebar('footer-widget');
				}
				if(is_active_sidebar('footer-widget-2')){
					dynamic_sidebar('footer-widget-2');
				}
				if(is_active_sidebar('footer-widget-3')){
					dynamic_sidebar('footer-widget-3');
				}				
				?>
				</section>
				<?php 
			}
			?>
			
            <?php
			if(has_nav_menu('social-menu')){

			  wp_nav_menu(array(
				  'theme_location' => 'social-menu',
				  'container' => 'nav',
				  'container_id' => 'social',
				  'container_class' => 'right social social-menu clearfix',//hidden-text

				  ));
			}
            ?>			
			
            <p class="credit spacer small">
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