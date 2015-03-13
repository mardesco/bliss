<?php
//home.php

// this template will be overridden by front-page.php !!!
// If you're trying to change your site's static homepage, that's the template to edit.
// This file determines the style of your BLOG home.

get_header();

if (have_posts()) :
   while (have_posts()) :
      the_post();
?>
<article>
    <h1>
    <?php bliss_clean_title_link();//title of the post 
    ?></h1>
	
    <?php	
	
	// version 0.1.1 adds post thumbnails to blogroll
		if ( has_post_thumbnail() ) {
			echo '<div class="center featured-image-container">';
			printf('<a href="%s">', esc_attr(get_the_permalink()));
			the_post_thumbnail();
			echo '</a>
			</div>';	
		}	
	
	
	// this template will probably usually be used to display the content on the blog home page.
    the_excerpt();
    ?>
</article>
<?php
   endwhile;
endif;

// pagination
paginate();

get_sidebar();
get_footer(); 

?>