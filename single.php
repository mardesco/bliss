<?php
//single.php

//display an individual post
//delete this file to use the index.php layout for single post display

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
	    printf( '<p class="subtitle">%s</p>', $subtitle );
		}
	?>	
    
	<p class="attribution">Posted by <?php the_author();?> on <?php the_date();?></p>   	
	
	
	
    <?php
		// recommended by ThemeCheck.
		// via http://codex.wordpress.org/Function_Reference/add_theme_support
		if ( has_post_thumbnail() ) {
			echo '<div class="center featured-image-container">';
			the_post_thumbnail();
			echo '</div>';	
		}
	
    the_content();//full post content

	$categoryList = get_the_category();
	$separator = ' ';
	$output = '';
	if($categoryList){
		
		$output .= '<p class="category-list">Filed under ';
		
		foreach($categoryList as $category) {
			$output .= '<a href="'.get_category_link($category->term_id ).'" title="' . esc_attr( sprintf( __( "All posts filed under %s", 'bliss' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
		}
	printf('%s</p>', trim($output, $separator) );
	}


	the_tags('<p class="tag-list">Tagged ', ', ', '</p>');
	
	// wp_link_pages is required by ThemeCheck.
	// only does anything if this is a multi-page post.
	wp_link_pages();
	
	// prev. and next links
	$next_post = get_next_post_link('%link');
	if($next_post){
		echo '<p class="right small">' . $next_post .'</p>';
	}
	
	$previous_post = get_previous_post_link('%link');
	if($previous_post){
		echo '<p class="left small">'. $previous_post . '</p>';
	}
	
	
    
    ?>
</article>
<?php

	// and now... comments.
	// if you like comments.  
	// Personally, I find that if your blog is small like mine, then most of the comments you recieve are total spam, and the world is a better place without them.
	// So feel free to delete this next line.
	comments_template( '', true ); 
	
   endwhile;
endif;
get_sidebar();//page-specific sidebars?
get_footer(); 

?>