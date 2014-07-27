<?php
//category.php

//included automatically
//delete to default to archive.php (or index.php) instead

get_header();
?>
<h1>Category: <?php single_cat_title(); ?></h1>
    <p>All posts filed under <?php single_cat_title();?></p>
	
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
	  
/* post_class is required by ThemeCheck */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
<h3>
	<?php
	// our custom function outputs the title within a permalink, all properly escaped to prevent XSS attacks. 
	// see http://codex.wordpress.org/Theme_Development#Untrusted_Data
	bliss_clean_title_link();
	?>
</h3>
<?php
		// recommended by ThemeCheck.
		// via http://codex.wordpress.org/Function_Reference/add_theme_support
		if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		}

the_excerpt();
//doesn't require a read more link at the bottom, 
//because I've built those into the_excerpt from functions.php
?>

</article>
<?php
   endwhile;
   
   else:
   
   _e("Sorry, no articles found in this category.", 'bliss');
   
   
endif;

paginate(); //blog archive pagination!

get_sidebar();
get_footer(); 

?>