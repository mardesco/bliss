<?php
//header.php

//using the wordpress language_attributes function instead of hard-coding lang="en" for i18n...
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php 
		$bliss_display_name = esc_attr(get_bloginfo('name'));
	?>
	
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">	

    <!-- begin wp_head -->
    <?php
	wp_head();
	?>
    <!-- end wp_head -->

</head>

<body <?php body_class(); ?>>

<a href="#contentLink" class="visuallyhidden">Skip navigation</a>

<div id="bliss_container" class="shadow <?php
	// a future release will upgrade to object-oriented programming, to arrest the propagation of global variables.
	global $bliss_corner_style;
	$bliss_corner_style = of_get_option('bliss_corner_style', 'square');
	if($bliss_corner_style == 'rounded'){
		_e( ' rounded', 'bliss');
	}
?>">

	<header class="site-header clearfix <?php 

		// header navigation menu style.
		$bliss_header_nav_style = of_get_option('bliss_header_nav_style', 'full_width');//full_width
		
		if($bliss_header_nav_style == 'full_width'){
			_e(' no-button-nav', 'bliss');
		}
	
	?>">
    	
            <h1 class="logo">
                <a href="<?php 
                    echo home_url('/');//appends a trailing slash
                    ?>" title="<?php printf( '%s : %s', esc_attr( get_bloginfo( 'name' ) ), esc_attr( get_bloginfo('description') ) ); ?>">
                <?php 
				

				
				// logo to display here, if you have one.  
				$logo = of_get_option('bliss_logo');
				
				if($logo){
				
					printf('<img src="%s" alt="%s" />', esc_url($logo), $bliss_display_name);
				
				}else{
					//otherwise:				
					printf('<span class="logotext">%s</span>', $bliss_display_name);
				}
                ?>
                </a>
            </h1>
            <!-- optional tagline display. -->
			<?php
			$site_slogan = of_get_option('bliss_slogan');
			
			if($site_slogan){
				$site_slogan = esc_html($site_slogan);
			}else{
				$site_slogan = esc_html(get_bloginfo('description'));
			}
			
			printf('
            <h2 class="site-slogan">
				%s
            </h2>', $site_slogan);
            ?>			

        
        
        <?php
		// the search form.
		get_search_form();//you could move this to the sidebar, but you'd have to modify the CSS to prevent it from overflowing.
		

		
		
		if($bliss_header_nav_style == 'button'){
		
			// the button-style nav menu is within the header element.
		
		?>
        
<!-- primary navigation menu. -->

		<div id="headerNavWrap" class="bliss-header-nav">
			<?php

			wp_nav_menu(array(
				'theme_location' => 'header-nav',
				'container' => 'nav',
				'container_id' => 'headerNav'
				));

			?>
		</div>
		
	</header>
	
	<?php
	
	}else{
	
		// the full-width style nav menu is below the header element.
	
	?>
	
	</header>
	
		<div id="headerNavWrap" class="bliss-header-nav bliss-full-wrap">
			<?php

			wp_nav_menu(array(
				'theme_location' => 'header-nav',
				'container' => 'nav',
				'container_id' => 'headerNav',
				'container_class' => 'clearfix bliss-full-width-nav'
				));

			?>
		</div>	
	
	<?php
	
	}
	
	
	
	  // display the slideshow, if one has been attached to the current page.
	  bliss_slideshow();
	?>		

<div id="wrapper">

    <div id="bliss_main" role="main">
		
		<a id="contentLink" class="visuallyhidden">&nbsp;</a>
		
	
		