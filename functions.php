<?php
//functions.php


// first, a little security.
// prevent direct script access
if(__FILE__ == $_SERVER['SCRIPT_FILENAME']){
    die("This file cannot be executed directly");
}



# Begin Options #

/* 
theme options panel via the Options Framework 
courtesy of Devin Price : http://wptheming.com/options-framework-theme/
*/
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/options/' );
require_once dirname( __FILE__ ) . '/options/options-framework.php';

/*
 * 
 * Show / hide the slideshow option when a checkbox is clicked.
 *
 * 
 */

function bliss_toggle_slideshow_options() { ?>

	<script type="text/javascript">
		jQuery(document).ready(function() {

			// slideshow 1
			jQuery('#bliss_slideshow1_showhidden').click(function() {
				jQuery('.bliss-slideshow-1').fadeToggle(400);
			});

			if (jQuery('#bliss_slideshow1_showhidden:checked').val() !== undefined) {
				jQuery('.bliss-slideshow-1').show();
			}
			
			// slideshow 2
			jQuery('#bliss_slideshow2_showhidden').click(function() {
				jQuery('.bliss-slideshow-2').fadeToggle(400);
			});

			if (jQuery('#bliss_slideshow2_showhidden:checked').val() !== undefined) {
				jQuery('.bliss-slideshow-2').show();
			}

			// slideshow 3
			jQuery('#bliss_slideshow3_showhidden').click(function() {
				jQuery('.bliss-slideshow-3').fadeToggle(400);
			});

			if (jQuery('#bliss_slideshow3_showhidden:checked').val() !== undefined) {
				jQuery('.bliss-slideshow-3').show();
			}	

		});
	</script>

<?php
}
add_action( 'optionsframework_custom_scripts', 'bliss_toggle_slideshow_options' );

# END OPTIONS #


# Theme Styles #

function bliss_style_links(){
	$modernizr_url = get_template_directory_uri() . "/js/modernizr-2.6.1.min.js";
	wp_enqueue_script('modernizr', $modernizr_url, array(), '2.6.1', false);
	
	// disallowed by theme review: get_template_directory_uri() . "/style.css";
	// required: use get_stylesheet_uri() 
	$main_stylesheet  = get_stylesheet_uri();
	wp_enqueue_style( 'bliss_style', $main_stylesheet, false );
	
	// as of version 0.1.1 the font url is now a relative protocol.
	$font_url = '//fonts.googleapis.com/css?family=Merriweather:700italic';
	wp_enqueue_style( 'Merriweather', $font_url, false);
	
}
add_action( 'wp_enqueue_scripts', 'bliss_style_links', 2 );


	/* default value for $content_width, required by ThemeCheck. */
	// it turns out, intended use of $content_width global is NOT the same
	// as intended use of: (int) of_get_option('bliss_max_width')
	
	// if not overriden by a plugin, must be set equal to the rendered content area of the theme.
	
	// required: define content_width global via after_setup_theme callback
	function bliss_global_width(){
	
		// Note: this variable will not accurately reflect the size of the display area on a mobile device screen.
	
		global $content_width;
         if ( ! isset( $content_width ) ){
				// Default for $content_width is the width of the content area on a page with a single sidebar at the theme's default container width.
               $content_width = 735;
			   
			   // but that's not necessarily accurate for the current page, is it.
			   // The size of the content area will depend on the user settings.
			   // retrieving those settings requires an extra database call.
			   // TODO: set global vars for all user settings, to reduce the number of database lookups required.
			   
				$width = (int) esc_attr(of_get_option('bliss_max_width', '1024'));		
				if($width === 0){
					// 100% width display. 
					// size of content area can only be determined by JavaScript.
					// use the default setting from above, and do nothing here.
				}else{
				
					// determine if this page has sidebars in the first place
					if(is_front_page() || is_page_template('page-full-width.php')){

						/*
						style.css line 1155 says:
						#main{padding:2.9%;}
						
						2.9 * 2 = 5.8%
						100-5.8 = 94.2
						*/
						$content_width = $width * 0.942;	
					
					}else{
						// check sidebar status.
						$sidebars = bliss_get_sidebar_selection();
						switch($sidebars){
							// "left" and "right" both get the same treatment.
							case 'left':
							case 'right':
							
								/* 
								see stylesheet (eg .hasRightNav #main on line 1210)
								the use of a single sidebar reduces the width of the content area by 22.45%
								
								5.8 + 22.45 = 28.25
								100 - 28.25 = 71.75
								*/
								$content_width = $width * 0.7175;
							
							
							break;
							case 'both':
								
								// 22.45 * 2 = 44.9
								// 44.9 + 5.8 = 50.7
								// 100 - 50.7 = 49.3
								$content_width = $width * 0.493;
								
								
							break;
							case 'none':
								// same as the full width layouts above
								$content_width = $width * 0.942;
							break;
							default:
								// use the default, set above.
								// do nothing.
							break;
						}
					}

				}			   
         }
	}
	add_action('after_setup_theme', 'bliss_global_width');


function bliss_user_customizations(){
	
	// user-specified width setting goes AFTER the theme's primary stylesheet.
	$width = (int) esc_attr(of_get_option('bliss_max_width', '1024'));
	if($width && is_int($width) && $width != 0){
	$breakpoint = $width -1;

	printf('
		<style type="text/css">
			#container{width:%dpx;}
			@media screen and (max-width:%dpx){
				#container{width:100%%;}
			}			
		</style>', $width, $breakpoint);
	}else{
		if(isset($width) && $width === 0){
			echo '<style type="text/css">#container{width:100%}</style>';
		}
	}
	$header_background = get_header_image();
	
	// feature support for custom-header image.
	if($header_background && $header_background != ''){
		printf('
			<style type="text/css">
				.site-header{
					background:transparent url("%s") center center no-repeat;
					background-size:cover;
				}
			
			</style>
		', esc_url($header_background));
	}
	

}
add_action('wp_head', 'bliss_user_customizations', 100);// a low priority so these styles will be called last.

/* color scheme selection via theme options */
function bliss_color_scheme($classes){
	// get the user-selected color scheme. Defaults to light grey.
	// other options: blue, green, or maroon.
	$color = esc_attr(of_get_option('bliss_colors', 'light'));
	if($color){
		// add the color as a class name to the $classes array
		$classes[] = $color;
		}
	return $classes;
	}
add_filter('body_class', 'bliss_color_scheme');


function bliss_font_in_footer(){
	echo '
	<style type="text/css">
		h1,h2,h3{font-family: "Merriweather", serif;font-style:italic;font-weight:700}
	</style>
	';
}
add_action('wp_footer', 'bliss_font_in_footer', 100);// we'll execute that last, in hopes the font file will have loaded.

# end theme styles #


# theme functions #

// per http://codex.wordpress.org/Theme_Development#Untrusted_Data
// define a custom function for cleaning titles, when they are output within an html attribute.
// BUT functions defined in the global scope must be prefixed with the unique theme name!  
// Thanks to nitkr for pointing this out.
function bliss_clean_title_link(){
	//http://codex.wordpress.org/Function_Reference/the_title_attribute
	printf(	'<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
}

// as per http://codex.wordpress.org/Function_Reference/wp_title#Covering_Homepage
function bliss_homepage_title($title){
	if( empty( $title ) && ( is_home() || is_front_page() ) ) {
		return __( esc_attr( get_bloginfo( 'name' ) ), 'bliss' ) . ' | ' . get_bloginfo( 'description' );
	  }
	  return $title;
	
}
add_filter( 'wp_title', 'bliss_homepage_title');

// per theme review:
// these calls to add_editor_style and add_theme_support
// MUST be hooked to after_setup_theme
function bliss_add_editor_styles() {
	/* Editor styles, recommended by ThemeCheck. */
	// http://codex.wordpress.org/Function_Reference/add_editor_style
    add_editor_style( 'css/admin.css' );
	
	/* theme support, as recommended by ThemeCheck: */
	add_theme_support('post-thumbnails');
	add_theme_support('custom-header');
	add_theme_support('custom-background');
	add_theme_support('title-tag');// since WordPress 4.1


	/* theme support, as REQUIRED by ThemeCheck */
	add_theme_support('automatic-feed-links');	
	
}
add_action( 'after_setup_theme', 'bliss_add_editor_styles' );





function bliss_collapsing_nav_menu(){
	$path = get_template_directory_uri() . '/js/collapsing-nav-menu.js';
	wp_enqueue_script('collapsing_nav', $path, array(), '1', true);
}
add_action('wp_enqueue_scripts', 'bliss_collapsing_nav_menu');



// next, we include formatting.php
// which is concerned with menus, sidebars, and the "Read More" link.
require_once('includes/formatting.php');


// custom meta boxes.
require_once('includes/metaboxes.php');


// Sliders to go with those meta boxes.
require_once('includes/slideshows.php');


// pagination.
require_once('includes/pagination.php');


/* breadcrumbs  */
require_once('includes/breadcrumbs.php');

?>