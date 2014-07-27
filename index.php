<?php
//index.php

//per the documentation:
//"The main template. If your Theme provides its own templates, index.php must be present. "


get_header();

//this is "The Loop"

if (have_posts()) :
   while (have_posts()) :
      the_post();	//makes the current item available for use...
	  ?>

<?php
/* post_class is required by ThemeCheck */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
		
	<h1><?php the_title(); ?></h1>	
		<div id="breadcrumbs">
			<div class="content">
				You are here: 
				<?php 
				// this one constructor does the whole thing.  
				$crumbs = new simple_breadcrumb(); 
			?>
			</div>
		</div>			
	
	<section class="content">
	<?php
		// recommended by ThemeCheck.
		// via http://codex.wordpress.org/Function_Reference/add_theme_support
		if ( has_post_thumbnail() ) {
			echo '<div class="center featured-image-container">';
			the_post_thumbnail();
			echo '</div>';	
		}
		
		
      the_content();
	 ?>

	</section>  
	  
</article>  

<?php

   endwhile;
endif;

//end of "The Loop"

// pagination
paginate();


get_sidebar();
get_footer(); 

?>