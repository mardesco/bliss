<?php
//woocommerce.php

// The popular e-commerce plugin gets its very own version of page.php 
// per instructions at http://docs.woothemes.com/document/third-party-custom-theme-compatibility/

get_header();

if(function_exists('woocommerce_content')){
	// the lazy man's way...
	woocommerce_content();
}else{
	__('<h1>Sorry</h1><p>No matching posts were found.</p>', 'bliss');
}

get_sidebar();
get_footer(); 

?>