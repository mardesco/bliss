<?php
//template-full-width.php

/*
Template Name: Full Width Page
*/


get_header();
if (have_posts()) :
   while (have_posts()) :
      the_post();
/* post_class is required by ThemeCheck */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
    <h1>
    <?php 
	the_title();//title of the post 
    ?></h1>
    
    <?php
	$subtitle = bliss_get_subtitle();
	if($subtitle){
	    printf( '<p class="subtitle">%s</p>', $subtitle );
		}
	?>
	
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
		// recommended by ThemeCheck.
		// via http://codex.wordpress.org/Function_Reference/add_theme_support
		if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		}	
	
    the_content();//full post content
    
    
    ?>
</article>
<?php
   endwhile;
endif;
//FULL WIDTH!!!
//normally we would call:
//get_sidebar();//here
//but instead we're just going to close the two currently open divs.  
?>
	</div><!-- end left_col-->	
</div><!-- end content-->
<?php
get_footer(); 

?>