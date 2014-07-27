<?php
//blogroll.php

/*
	Template Name: Blogroll
*/

// Optional custom blog home page template
// allows the user to preface the blogroll with customized introductory content (such as text, featured image, or slideshow).

// Does not override home.php
// Is not affected by site's Reading settings. 
// To use this template, select a page from the content editor, and choose Blogroll as the page template.

get_header();

//this is "The Loop"

if (have_posts()) :
   while (have_posts()) :
      the_post();	//makes the current item available for use...
	
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
	
	// proper blogroll functionality requires a sub-loop.
	// could eg. use query_var to get the current page & paginate
	// then calll query_posts to retrieve the posts.
	
	//query_posts();
	
	// however, Ben Gillbanks says that's no longer a best practice.  
	//http://www.binarymoon.co.uk/2010/03/5-wordpress-queryposts-tips/
	// instead, use a sub-loop with a new WP_Query object.  
	

	// don't forget the pagination...
	// with help from http://codex.wordpress.org/Class_Reference/WP_Query#Post_.26_Page_Parameters	
	
	// if you want to use "blogroll" as a static front page, you have to change 'paged' to 'page' in get_query_var on this next line:
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	
$query = array (
    'posts_per_page' => 5,
	'paged' => $paged
	);// add query params as needed.

$innerLoop = new WP_Query($query);


		// I'm placing pagination at both the top and the bottom of the inner loop itself.  
		// an instance of the WP_Query object is required by this version of the pagination function.	
		paginate_blogroll($innerLoop); //blog archive pagination!	


// The Loop...
if ($innerLoop->have_posts()) {
	while ($innerLoop->have_posts()) {
		$innerLoop->the_post();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
	<hgroup class="post-meta">
		<h2><?php 
			bliss_clean_title_link(); //includes post title wrapped in permalink with escaped title attribute
			?></h2>
		<p class="author-credit">Posted by <?php the_author(); ?> on <?php the_date(); ?></p>
	</hgroup>
	
	<section class="content">
	<?php
		// recommended by ThemeCheck.
		// via http://codex.wordpress.org/Function_Reference/add_theme_support
		if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		}
		
		the_excerpt();// complete with readmore link via functions.php
      //the_content();
	 ?>
	  <p class="tags">Tagged under <?php the_tags(); ?></p>
	  <p class="categories">Filed under <?php the_category(', ');?>
	</section>  
	  
</article>  





<?php
	}//end while
	

	
}else{//end if
?>
	<h1>Nothing to see here</h1>
	<p>Check back later to see if we&#039;ve posted anything.  </p>
<?php
}//end inner loop.
	
		// an instance of the WP_Query object is required by this version of the pagination function.	
		paginate_blogroll($innerLoop); //blog archive pagination!	

		// after the inner loop:
		// recommended by http://codex.wordpress.org/Class_Reference/WP_Query
		wp_reset_postdata();
		
		// end outer loop
   endwhile;
endif;

//end of "The Loop"



get_sidebar();
get_footer(); 

?>