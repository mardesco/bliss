<?php
//front-page.php

// Trying to use a custom homepage?  Can't get it to change or update?  
// try editing this file instead.

// When a front-page.php is present, WordPress presents unexpected behavior:
// The front-page template overrides all other templates, but the body class will give the other template's name!


get_header();

 

if (have_posts()) :
   while (have_posts()) :
      the_post();
	  
	  // display the slideshow, if one has been attached to the home page.
	  // NOTE: when using the default homepage, slideshow1 is included automatically, if it exists.

	  
?>
<article>

<?php
		// recommended by ThemeCheck.
		// via http://codex.wordpress.org/Function_Reference/add_theme_support
		if ( has_post_thumbnail() ) {
			echo '<div class="center featured-image-container">';
			the_post_thumbnail();
			echo '</div>';	
		}
?>


    
    <?php
    
	if(is_home()){
		// if your front page is a blogroll:
		?>
		<h1>
		<?php bliss_clean_title_link();//title of the post, with link
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
		
		the_excerpt();
	}else{
		// if your front page is a proper static homepage:
		?>
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
		the_content();//full post content
	}
    
    ?>
</article>
<?php
   endwhile;
endif;

paginate();

get_sidebar();
get_footer(); 


?>

