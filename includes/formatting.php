<?php
//formatting.php

/* Next: a better "Read More" link. */

//make the "read more" link in the_excerpt link to the post
//from http://codex.wordpress.org/Function_Reference/the_excerpt#Make_the_.22read_more.22_link_to_the_post
function bliss_excerpt_more($more) {
    global $post;
	return ' <a href="'. get_permalink($post->ID) . '">(...Read More)</a>';
}
add_filter('excerpt_more', 'bliss_excerpt_more');

// next: Menus!
function bliss_menu_registration(){
	register_nav_menus(array(
		'header-nav' => __('Navigation menu for the headerbar', 'bliss'),
		'left-nav' => __('Left-hand sidebar navigation menu', 'bliss'),
		'right-nav' => __('Right-hand sidebar navigation menu', 'bliss'),
		'footer-nav' => __('Footer navigation menu', 'bliss')
		));
	}
add_action( 'after_setup_theme', 'bliss_menu_registration' );

$sidebar_selection = of_get_option('bliss_sidebars', 'right');
function bliss_get_sidebar_selection(){
	// an object-oriented MVC would be a better solution... but this is far simpler.
	global $sidebar_selection;

	return $sidebar_selection;
}

// Enable widgetable sidebar
function bliss_sidebar_registration(){

	global $sidebar_selection;

	$sidebars = $sidebar_selection;
	
	if($sidebars == 'left' || $sidebars == 'both'){
		register_sidebar(array(
			'id' => 'sideNavLeft',
			'name' => __('sideNavLeft', 'bliss'),
			'class' => 'sideNavLeftWidget',
			'before_widget' => '<aside class="widget">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));		
	}

	if($sidebars == 'right' || $sidebars == 'both'){
		register_sidebar(array(
			'id' => 'sideNavRight',
			'name' => __('sideNavRight', 'bliss'),
			'class' => 'sideNavRightWidget',
			'before_widget' => '<aside class="widget">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));		
	}
	
	}
add_action( 'widgets_init', 'bliss_sidebar_registration' );



//this adds a css class to the body element.  
// derived from the function via http://www.wpfunction.me/
function bliss_has_sidebar($classes) {

	// determine if this page has sidebars in the first place
	if(!is_front_page() && !is_page_template('page-full-width.php')){
		global $sidebar_selection;

		$sidebars = $sidebar_selection;
		
		
		if($sidebars == 'right' || $sidebars == 'both'){
			$classes[] = 'hasRightNav';
			}
		if($sidebars == 'left' || $sidebars == 'both'){
			$classes[] = 'hasLeftNav';
			}

	}// end if has sidebars (not front page or full width template)
	
    // return the $classes array
    return $classes;
}
add_filter('body_class','bliss_has_sidebar');


?>