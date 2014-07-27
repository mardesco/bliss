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


//perhaps a menu of selected pages.
?>

<h2>Selected Pages</h2>
<?php
// perhaps a navigation menu.
wp_nav_menu(array(
	'theme_location' => 'right-nav',
	'container' => 'nav',
	'container_class' => 'rightSideNavMenu'
	));
	


// or your blog archives.
_e('<h2>' . __('Blog Archives', "bliss") . '</h2>');
// have lots of posts?  you can limit the archive list by adding: array( 'limit'=> 15 ) 
// as an argument to the following function.  
// for details see http://codex.wordpress.org/Template_Tags/wp_get_archives
wp_get_archives(  );


// perhaps you just want to list a category menu.
_e('<h2>' . __('Categories', "bliss") . '</h2>');
wp_list_categories( 'title_li=' );	
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
_e('<h2>' . __('Navigation', "bliss") . '</h2>');
wp_nav_menu(array(
	'theme_location' => 'left-nav',
	'container' => 'nav',
	'container_id' => 'leftSideNavMenu',
    'container_class' => 'leftSideNavMenu'
	));
?>
</nav>
<?php
}
}// end test to determine if sidebars should be shown.
?>