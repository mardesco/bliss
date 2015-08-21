<?php
//sidebar.php


// now using the options framework to determine which sidebars the website admin has selected.

$sidebars = bliss_get_sidebar_selection();



?>

    
    </div><!-- end main -->

</div><!-- end wrapper -->



<!-- if your design includes a right hand side bar -->

<?php

// determine if this page has sidebars in the first place
if(!is_front_page() && !is_page_template('page-full-width.php')){


if( $sidebars == 'right' || $sidebars == 'both'){
?>
<nav class="rightSideNav">

<?php

//what would you like in the right-hand sidebar?

	
// maybe some widgets.
dynamic_sidebar('sideNavRight');


//perhaps a navigation menu of selected pages.

if(has_nav_menu('right-nav')){

// custom menu name 
// as suggested by jkrill at https://wordpress.org/support/topic/getting-menu-name-in-a-given-location
// but it doesn't seem to work when I call this:
// $nav_menu = wp_get_nav_menu_object('right-nav');

// so instead:
$locations = get_nav_menu_locations();
$menu_id = $locations[ 'right-nav' ] ;
$nav_menu = wp_get_nav_menu_object($menu_id);

// then echo the name of the menu
$menu_title = $nav_menu->name ? esc_html($nav_menu->name) : 'Selected Pages';

	printf('<h2>%s</h2>', $menu_title);

	wp_nav_menu(array(
		'theme_location' => 'right-nav',
		'container' => 'nav',
		'container_class' => 'rightSideNavMenu'
		));
	
}
	
/*
// Archives should be added via a widget.
// So they can remove if they don't want it.

// or your blog archives.
_e('<h2>' . __('Blog Archives', "bliss") . '</h2>');
// have lots of posts?  you can limit the archive list by adding: array( 'limit'=> 15 ) 
// as an argument to the following function.  
// for details see http://codex.wordpress.org/Template_Tags/wp_get_archives
wp_get_archives(  );


// perhaps you just want to list a category menu.
_e('<h2>' . __('Categories', "bliss") . '</h2>');
wp_list_categories( 'title_li=' );	
*/
?>
</nav>
<?php
}// end right-hand sidebar

// left sidebar
 if($sidebars == 'left' || $sidebars == 'both'){
?>

<nav class="leftSideNav">
<?php

//what would you like in the left-hand sidebar?  (or below your content, for smaller screens?)

// maybe some widgets.
dynamic_sidebar('sideNavLeft');

// perhaps a navigation menu.
if(has_nav_menu('left-nav')){

	$locations = get_nav_menu_locations();
	$menu_id = $locations[ 'left-nav' ] ;
	$nav_menu = wp_get_nav_menu_object($menu_id);

	// then echo the name of the menu
	$menu_title = $nav_menu->name ? esc_html($nav_menu->name) : 'Selected Pages';

	printf('<h2>%s</h2>', $menu_title);

	
	wp_nav_menu(array(
		'theme_location' => 'left-nav',
		'container' => 'nav',
		'container_id' => 'leftSideNavMenu',
		'container_class' => 'leftSideNavMenu'
		));
}	
?>
</nav>
<?php
}
}// end test to determine if sidebars should be shown.
?>