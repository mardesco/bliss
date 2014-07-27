<?php
//page.php

/*
Template Name: Default
*/

//display an individual page

//loop: query a single page, and display it.




get_header();
if (have_posts()) :
   while (have_posts()) :
      the_post();
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
/* post_class is required by ThemeCheck */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
    <h1>
    <?php the_title();//title of the post 
    ?></h1>
	
    <?php
	$subtitle = bliss_get_subtitle();
	if($subtitle){
	    echo '<p class="subtitle">' . $subtitle . '</p>';
		}

	?>	

	
    <?php
		// recommended by ThemeCheck.
		// via http://codex.wordpress.org/Function_Reference/add_theme_support
		if ( has_post_thumbnail() ) {
			echo '<div class="center featured-image-container">';
			the_post_thumbnail();
			echo '</div>';	
		}
	
    the_content();//full post content
    
    ?>
</article>
<?php
   endwhile;
endif;
get_sidebar();
get_footer(); 

?>