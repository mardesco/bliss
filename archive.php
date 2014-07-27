<?php
//archive.php

//included automatically if there is no Category page (or if this is an archive lookup)
//delete to default to index.php instead

//display an archive page


/*
 * From the documentation:
 * "    Display archive title (tag, category, date-based,
 * or author archives).

 * Display a list of posts in excerpt or full-length form.
 * 

 *  Include wp_link_pages() to support navigation links within posts. "
 */
 ?>


<?php
get_header();
?>
<article>
	<h1>Archives</h1>
		<div id="breadcrumbs">
			<div class="content">
				You are here: 
				<?php 
				// this one constructor does the whole thing.  
				$crumbs = new simple_breadcrumb(); 
			?>
			</div>
		</div>		
</article>
<?php
if (have_posts()) :
   while (have_posts()) :
      the_post();

/* post_class is required by ThemeCheck */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
<h2>
<?php
// our custom function outputs the title within a permalink, all properly escaped to prevent XSS attacks. 
// see http://codex.wordpress.org/Theme_Development#Untrusted_Data
bliss_clean_title_link();
?>
</h2>

<?php
		// recommended by ThemeCheck.
		// via http://codex.wordpress.org/Function_Reference/add_theme_support
		if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		}

//the_content();//full post content
the_excerpt();
//doesn't require a read more link at the bottom, 
//because I've built those into the_excerpt from functions.php
?>

</article>
<?php
   endwhile;
   
   else:
   
   _e("Sorry, no articles matched your search.", 'bliss');
   
   
endif;

paginate(); //blog archive pagination!

get_sidebar();
get_footer(); 

?>