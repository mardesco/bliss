<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 */

function optionsframework_options() {


	$options = array();

	
	// Basic settings.
	
	$options[] = array(
		'name' => __('Basic Settings', 'bliss'),
		'type' => 'heading'
		);

		
	$options[] = array(
		'name' => __('Branding', 'bliss'),
		'desc' => __('These settings determine the display of your website&#039;s branding.', 'bliss'),
		'type' => 'info'
		);		
		

	// logo in headerbar.
	$options[] = array(
		'name' => __('Your Logo', 'bliss'),
		'desc' => __('Add your logo to the theme headerbar.', 'bliss'),
		'id' => 'bliss_logo',
		'type' => 'upload'
		);	
	
	
	// custom text in headerbar.
	$options[] = array(
		'name' => __('Slogan Text', 'bliss'),
		'desc' => __('Your phone number, company slogan, or call to action. Leave blank to default to your blog&#039;s tagline.', 'bliss'),
		'id' => 'bliss_slogan',
		'std' => '',
		'type' => 'text'
		);
		
	
	// selectable color scheme.
	$colors_array = array(
		'blue' => __('Blue', 'bliss'),
		'green' => __('Green', 'bliss'),
		'maroon' => __('Maroon', 'bliss'),
		'light' => __('Light Grey', 'bliss'),
		'dark' => __('Dark Grey', 'bliss')
	);	
	
	$options[] = array(
		'name' => __('Primary Color', 'bliss'),
		'desc' => __('What color should be emphasized most prominently in your website&#039;s design?', 'bliss'),
		'id' => 'bliss_colors',
		'std' => 'light',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $colors_array
		);		
	
	
	// Advanced settings.
	
	$options[] = array(
		'name' => __('Advanced Settings', 'bliss'),
		'type' => 'heading');	
	
	
	$options[] = array(
		'name' => __('Site Layout', 'bliss'),
		'desc' => __('These settings determine the overall layout and styling of your website.', 'bliss'),
		'type' => 'info'
		);	
	
	
	// select sidebar options.
	$sidebar_array = array(
		'left' => __('Left sidebar', 'bliss'),
		'right' => __('Right sidebar', 'bliss'),
		'both' => __('Both sidebars', 'bliss'),
		'neither' => __('No sidebars ever', 'bliss')
	);	
	
	$options[] = array(
		'name' => __('Sidebar Options', 'bliss'),
		'desc' => __('Which sidebars would you like to display by default on most pages and posts? (Does not apply to homepage or full-width pages.)', 'bliss'),
		'id' => 'bliss_sidebars',
		'std' => 'right',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $sidebar_array
		);	
	
	
	// set max container width.
	$options[] = array(
		'name' => __('Max container width', 'bliss'),
		'desc' => __('The maximum width of your site&#039;s container element, in pixels.  Do not enter a unit of measurement.  Set to 0 for a 100% width layout.', 'bliss'),
		'id' => 'bliss_max_width',
		'std' => '1024',
		'class' => 'mini',
		'type' => 'text'
		);	
	
	// Slideshow Settings
	
	$options[] = array(
		'name' => __('Slideshow Settings', 'bliss'),
		'type' => 'heading'
		);	
	
	
	$options[] = array(
		'name' => __('Use Slideshows', 'bliss'),
		'desc' => __('These settings allow you to create and manage up to 3 slideshows within your theme.', 'bliss'),
		'type' => 'info'
		);		
	
	// this is a bit cumbersome but it's good enough for now.
	// Someday I'll write a more elegant system.


	
	// Slideshow 1
	
	$options[] = array(
		'name' => __('Display Slideshow 1', 'bliss'),
		'desc' => __('Create and use Slideshow 1.', 'bliss'),
		'id' => 'bliss_slideshow1_showhidden',
		'type' => 'checkbox'
		);

	$options[] = array(
		'name' => __('Slideshow 1', 'bliss'),
		'desc' => __('Select the images that you want displayed in the Slideshow 1.  If you use the "Front page displays: your latest posts" option from Settings > Reading, then Slideshow 1 will display automatically on your site&#039;s homepage.  To use this slideshow in any other page or post, visit that page in the WordPress editor and select "Display Slideshow 1" from the "Slideshow Options" menu.', 'bliss'),
		'class' => 'hidden bliss-slideshow-1',
		'type' => 'info'
		);


	// slideshow 1 slide 1
	$options[] = array(
		'name' => __('Slide 1', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_1_slide_1',
		'class' => 'hidden bliss-slideshow-1',		
		'type' => 'upload'
		);

	// slideshow 1 slide 2
	$options[] = array(
		'name' => __('Slide 2', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_1_slide_2',
		'class' => 'hidden bliss-slideshow-1',		
		'type' => 'upload'
		);

	// slideshow 1 slide 3
	$options[] = array(
		'name' => __('Slide 3', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_1_slide_3',
		'class' => 'hidden bliss-slideshow-1',		
		'type' => 'upload'
		);		
		
	// slideshow 1 slide 4
	$options[] = array(
		'name' => __('Slide 4', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_1_slide_4',
		'class' => 'hidden bliss-slideshow-1',		
		'type' => 'upload'
		);		
		
		
	// slideshow 1 slide 5
	$options[] = array(
		'name' => __('Slide 5', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_1_slide_5',
		'class' => 'hidden bliss-slideshow-1',		
		'type' => 'upload'
		);		
		
		
		
	
	// Slideshow 2
	
	$options[] = array(
		'name' => __('Display Slideshow 2', 'bliss'),
		'desc' => __('Create and use Slideshow 2.', 'bliss'),
		'id' => 'bliss_slideshow2_showhidden',
		'type' => 'checkbox'
		);

	$options[] = array(
		'name' => __('Slideshow 2', 'bliss'),
		'desc' => __('Select the images that you want displayed in the Slideshow 2. To use this slideshow in any page or post, visit that page in the WordPress editor and select "Display Slideshow 2" from the "Slideshow Options" menu at the bottom.', 'bliss'),
		'class' => 'hidden bliss-slideshow-2',
		'type' => 'info'
		);


	// slideshow 2 slide 1
	$options[] = array(
		'name' => __('Slide 1', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_2_slide_1',
		'class' => 'hidden bliss-slideshow-2',		
		'type' => 'upload'
		);

	// slideshow 2 slide 2
	$options[] = array(
		'name' => __('Slide 2', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_2_slide_2',
		'class' => 'hidden bliss-slideshow-2',		
		'type' => 'upload'
		);

	// slideshow 2 slide 3
	$options[] = array(
		'name' => __('Slide 3', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_2_slide_3',
		'class' => 'hidden bliss-slideshow-2',		
		'type' => 'upload'
		);		
		
	// slideshow 2 slide 4
	$options[] = array(
		'name' => __('Slide 4', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_2_slide_4',
		'class' => 'hidden bliss-slideshow-2',		
		'type' => 'upload'
		);		
		
		
	// slideshow 2 slide 5
	$options[] = array(
		'name' => __('Slide 5', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_2_slide_5',
		'class' => 'hidden bliss-slideshow-2',		
		'type' => 'upload'
		);		
		

	
	// Slideshow 3
	
	$options[] = array(
		'name' => __('Display Slideshow 3', 'bliss'),
		'desc' => __('Create and use Slideshow 3.', 'bliss'),
		'id' => 'bliss_slideshow3_showhidden',
		'type' => 'checkbox'
		);

	$options[] = array(
		'name' => __('Slideshow 3', 'bliss'),
		'desc' => __('Select the images that you want displayed in the Slideshow 3.  To use this slideshow in any page or post, visit that page in the WordPress editor and select "Display Slideshow 3" from the "Slideshow Options" menu at the bottom.', 'bliss'),
		'class' => 'hidden bliss-slideshow-3',
		'type' => 'info'
		);


	// slideshow 1 slide 1
	$options[] = array(
		'name' => __('Slide 1', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_3_slide_1',
		'class' => 'hidden bliss-slideshow-3',		
		'type' => 'upload'
		);

	// slideshow 1 slide 2
	$options[] = array(
		'name' => __('Slide 2', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_3_slide_2',
		'class' => 'hidden bliss-slideshow-3',		
		'type' => 'upload'
		);

	// slideshow 1 slide 3
	$options[] = array(
		'name' => __('Slide 3', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_3_slide_3',
		'class' => 'hidden bliss-slideshow-3',		
		'type' => 'upload'
		);		
		
	// slideshow 1 slide 4
	$options[] = array(
		'name' => __('Slide 4', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_3_slide_4',
		'class' => 'hidden bliss-slideshow-3',		
		'type' => 'upload'
		);		
		
		
	// slideshow 1 slide 5
	$options[] = array(
		'name' => __('Slide 5', 'bliss'),
		'desc' => __('Select an image.', 'bliss'),
		'id' => 'slideshow_3_slide_5',
		'class' => 'hidden bliss-slideshow-3',		
		'type' => 'upload'
		);		
				
		
	return $options;
}