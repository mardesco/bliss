<?php
//search.php

//display search results

//loop: query a single page, and display it.

//note: be careful to use functions that clean user input before browser output!!!


get_header();
?>
<h1>Search results for
<?php 
	the_search_query();//sanitized search query.  NEVER just echo get['s']!!!
?>
</h1>
		<div id="breadcrumbs">
			<div class="content">
				You are here: 
				<?php 
				// this one constructor does the whole thing.  
				$crumbs = new simple_breadcrumb(); 
			?>
			</div>
		</div>	
<?php
if (have_posts()) :
   while (have_posts()) :
      the_post();
?>
<article>

	<h2><?php bliss_clean_title_link(); ?></h2>


<?php

the_excerpt();//with "read more link" via functions.php
?>
</article>
<?php
   endwhile;
   else: ?>
        <p><?php _e('We&#039;re sorry, but your search did not match any resources.', 'bliss'); ?></p>

    <?php
endif;
get_sidebar();//page-specific sidebars?
get_footer(); 

?>