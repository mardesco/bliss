<?php
//formatting.php

// this file is concerned with sidebars, menus, widgets, and the "read more" link

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
		'footer-nav' => __('Footer navigation menu', 'bliss'),
		'social-menu' => __('Social navigation menu', 'bliss')
		));
	}
add_action( 'after_setup_theme', 'bliss_menu_registration' );

$sidebar_selection = of_get_option('bliss_sidebars', 'right');
function bliss_get_sidebar_selection(){
	// this way you only have to query the database once, but can access the answer repeatedly.
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
	
	
	// as of version 0.1.5, "Bliss" also includes widget areas in the footer.
	register_sidebars(
		3,
		array(
			'name' => __('Footer widget %d', 'bliss'),
			'id' => 'footer-widget',
			'description' => 'Widget area in the footer',
			'before_widget' => '<div id="%1$s" class="one-third widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widgettitle">',
			'after_title' => '</h2>' 
			
		)
	);

	
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


// http://codex.wordpress.org/Function_Reference/wp_nav_menu
add_filter( 'wp_nav_menu_objects', 'bliss_social_menu_icons', 10, 2 );
function bliss_social_menu_icons($items, $args){

	if($args->theme_location == 'social-menu'){
	// override $item->title output for the social menu: replace with Font Awesome icons.
	
		foreach($items as $item){

			if(stripos($item->url, 'behance') !== false){
				// not doing it this way.
				// $item->classes[] = 'fa fa-lg fa-behance-square';
				
				$icon_wrap = '<span class="fa fa-lg fa-behance-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}		
			if(stripos($item->url, 'facebook') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-facebook-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}		
			
			if(stripos($item->url, 'github') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-github-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'plus.google') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-google-plus-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'instagram') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-instagram">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'jsfiddle') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-jsfiddle">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}			
			if(stripos($item->url, 'linkedin') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-linkedin-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'pinterest') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-pinterest-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'reddit') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-reddit-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'skype') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-skype">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'tumblr') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-tumblr-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'twitter') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-twitter-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'wordpress') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-wordpress">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'weibo') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-weibo">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'yelp') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-yelp">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'youtube') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-youtube-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'vimeo') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-vimeo-square">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'vine') !== false){
				$icon_wrap = '<span class="fa fa-lg fa-vine">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'wechat') !== false){				
				$icon_wrap = '<span class="fa fa-lg fa-wechat">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'stackexchange') !== false){		
				$icon_wrap = '<span class="fa fa-lg fa-stack-exchange">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'stackoverflow' !== false)){		
				$icon_wrap = '<span class="fa fa-lg fa-stack-overflow">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}
			if(stripos($item->url, 'stumbleupon') !== false){			
				$icon_wrap = '<span class="fa fa-lg fa-stumbleupon-circle">&nbsp;</span><span class="block visuallyhidden">'.$item->title.'</span>';
				$item->title = $icon_wrap;
			}		
		
		}
	}
	
	return $items;
}
?>