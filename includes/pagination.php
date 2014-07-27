<?php
//pagination.php


/* 
blog archive pagination
Original function courtesy of this tutorial by C. Bavota
http://bavotasan.com/2011/simple-pagination-for-wordpress/
licensed under the GPL per his Tweet to me on 6-3-2014
*/

function paginate() {
	
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	
	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => true,
		'type' => 'list',
		'next_text' => '&raquo;',
		'prev_text' => '&laquo;'
		);
	
	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	
	if( !empty($wp_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	
	echo paginate_links( $pagination );
}




// a custom modification of the above by Jesse Smith, to deal with blogroll pagination.

function paginate_blogroll($pb_query = false) {

	if(!is_object($pb_query)){
		return '';
	}

	global $wp_rewrite;
	$pb_query->query_vars['paged'] > 1 ? $current = $pb_query->query_vars['paged'] : $current = 1;
	
	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $pb_query->max_num_pages,
		'current' => $current,
		'show_all' => true,
		'type' => 'list',
		'next_text' => '&raquo;',
		'prev_text' => '&laquo;'
		);
		
	if( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	
	if( !empty($pb_query->query_vars['s']) )
		$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
		
	echo paginate_links( $pagination );
}



?>