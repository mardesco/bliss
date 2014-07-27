<?php
//home.php

// this template will be overridden by front-page.php !!!
// If you're trying to change your site's homepage, that's the template to edit.
// This file determines the style of your BLOG home.

//per the wp codex:
//"The home page template, which is the front page by default. If you use a static front page this is the template for the page with the latest posts. "
//-http://codex.wordpress.org/Theme_Development


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