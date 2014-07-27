<?php
// slideshows.php

// requires metaboxes.php

/**
@filename slideshows.php
@dependency metaboxes.php

@package Bliss

@author Jesse Smith for Mardesco
@copyright 2014
@license GPLv2

@description Retrieves data stored by the theme options, correlated with data stored in the post_meta, to display a slideshow.

@implements The slideshow feature uses the "Cycle2" jQuery plugin by M. Alsup: http://jquery.malsup.com/cycle2/  Please consider sending him a donation via PayPal to thank him for his great work!

*/

			
function bliss_get_slideshow_id(){

	if(is_front_page() && is_home()){
		return 1;
	}
	
	if(is_404() || is_search()){
		return false;
	}			

	global $post;
	
	/* Get the current post ID. */ 
	$post_id = $post->ID;  
	$key = 'bliss_slideshow';
	$slideshow = get_post_meta( $post_id, $key, true );  
	if($slideshow && $slideshow != '' && $slideshow != 'none'){
				
		$trim = strlen('uses_slideshow_');

		$id = substr($slideshow, $trim, 1 );

		return (int) esc_attr($id);
	
	}else{
		return false;
	}
}			
			
function bliss_display_slideshow(){
	$id = bliss_get_slideshow_id();// this function is defined in metaboxes.php
	
	
	if(!$id || $id == ''){
		return '';
	}
	
	// retrieve slide data from db.

	// see http://jquery.malsup.com/cycle2/api/
	// for information about adding captions etc.

// TODO: triggers via prev and next. Use the glyphicons to implement:
// data-cycle-next=".next, .cycle-slideshow" data-cycle-prev=".prev"
// but will require adding prev and next elements to the slider
	
	$string =  '<div id="bliss_slideshow" class="slider cycle-slideshow" data-cycle-slides="div" data-cycle-speed="600" data-cycle-timeout="3500" data-cycle-fx="tileSlide" data-cycle-tile-vertical="false" data-cycle-tile-count="12" data-cycle-swipe="true" data-cycle-pause-on-hover="true">';
	
	for($i = 1; $i <= 5; $i++){
		$slide = of_get_option('slideshow_'.$id.'_slide_'.$i);
		if($slide){
			
			$string .= sprintf('<div class="slide"><img src="%s" alt="slide" /></div>', esc_url($slide) );
			
		}
	}
	
	$string .= '</div>';
	
	return $string;
	
}

// this is the function you actually call, to display a slideshow on the page.
function bliss_slideshow(){
	  $slider = bliss_display_slideshow();
	  
	  if($slider && $slider != ''){
		printf('<div id="bliss_slideshow_container">%s</div>', $slider);
		$cycle_path = get_template_directory_uri() . '/js/jquery.cycle2.min.js';
		wp_enqueue_script('cycle2', $cycle_path, array('jquery'), '2.1.4',true);
		
		// provide "swipe" functionality to slideshow for mobile/touchscreen users
		$swipe_path = get_template_directory_uri() . '/js/jquery.cycle2.swipe.min.js';
		wp_enqueue_script('cycleswipe', $swipe_path, array('cycle2'), 'v20140128', true);
		
		// TODO: implement slideshow options, let the user select the animation type.
		// then only enqueue this next script if they're using the "tile" animation effect.
		$tile_path = get_template_directory_uri() . '/js/jquery.cycle2.tile.min.js';
		wp_enqueue_script('cycletile', $tile_path, array('cycle2'), '20140128', true);
	  }
	}	

?>