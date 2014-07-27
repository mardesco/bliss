<?php
/*
Plugin Name: Simple Breadcrumb Navigation
Plugin URI: http://www.kriesi.at/archives/wordpress-plugin-simple-breadcrumb-navigation
Description: A simple and very lightweight breadcrumb navigation that covers nested pages and categories
Version: 1.2
Author: Christian "Kriesi" Budschedl
Author URI: http://www.kriesi.at/
Notes: Minor modifications by Jesse Smith for Mardesco, and by Denzel for Karma.
License: GPLv3
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


class simple_breadcrumb{
	var $options;
	var $_markup;
	
function simple_breadcrumb(){
	$this->options = array( 	//change this array if you want another output scheme
	'before' => ' ',
	'after' => ' ',
	'delimiter' => '&gt;'
	);
	
	$markup = $this->options['before'].$this->options['delimiter'].$this->options['after'];
	$this->_markup = $markup;
	
	global $post;
	echo '<a href="'.home_url().'">';
		
		echo 'Home';

	
		echo "</a>";
		if(!is_front_page() ){//&& !is_home()
			echo $markup; 
				
			$output = $this->simple_breadcrumb_case($post);
			
			if ( is_page() || is_single()) {	
				if($output != ''){
					echo $output;
					echo $markup; 
				}
				echo '<span class="current_crumb">';
				the_title();
				echo ' </span>';
			}else{
				if($output != ''){
					echo '<span class="current_crumb">';
					echo $output;
					echo ' </span>';
					}
			}
		}
}

	
function simple_breadcrumb_case($der_post){

	$markup = $this->_markup;

	if (is_page()){
		 if($der_post->post_parent) {
			 $my_query = get_post($der_post->post_parent);			 
			 $this->simple_breadcrumb_case($my_query);
			 $link = '<a href="';
			 $link .= get_permalink($my_query->ID);
			 $link .= '">';
			 // including $markup in this next line was causing duplicate spacers in some scenarios. 
			 $link .= ''. get_the_title($my_query->ID) . '</a>';
			 return $link;
		  }	
	return '';			 	
	} 

	
			
	if(is_single()){
		
		$category = get_the_category();
		if (is_attachment()){
		
			$my_query = get_post($der_post->post_parent);			 
			$category = get_the_category($my_query->ID);
			$ID = $category[0]->cat_ID;

			if($der_post->post_parent !== 0){
			echo get_category_parents($ID, TRUE, $markup, FALSE );
			previous_post_link("%link $markup");
			return '';
			}
			
		
		}else{
			if (!empty($category)) { 
				$catlink = get_category_link( $category[0]->cat_ID );
				return '<a href="'.esc_url($catlink).'">'.esc_html($category[0]->cat_name).'</a>';
				}else{
					//there is no category.  show the "posts" blogroll page in its stead.
					
					//unless it's a portfolio page.
					if(get_post_type() == 'work'){
						return '<a href="'. esc_url(get_site_url() . "/portfolio/") . '">Portfolio</a>';
					}
					
					$link = '<a href="';
					 
					 $page_for_posts_id = get_option('page_for_posts'); //saved by wordpress.
					 $bliss_blog_page = get_permalink($page_for_posts_id);
					 
					 $link .= $bliss_blog_page;
					 $link .= '">';
					 $link .= ''. get_the_title() . '</a>';  
					 return $link;					
				}
			}				 

	return '';
	}// end if is_single
	
	if(is_category()){
		$category = get_the_category(); 
		$i = $category[0]->cat_ID;
		$parent = $category[0]-> category_parent;
		
		if($parent > 0 && $category[0]->cat_name == single_cat_title("", false)){
			echo get_category_parents($parent, TRUE, $markup, FALSE);
		}
	return single_cat_title('',FALSE);
	}
	

	if(is_author()){
		
		global $wp_query;
		$curauth = $wp_query->get_queried_object();
		
		return esc_html('Posts by ','bliss') . ' ' . $curauth->nickname;
	}
	
	if( is_tag() ) { 
		$value = esc_html('Posts Tagged &quot;','bliss');
		$value .= esc_html( single_tag_title("", false), 'bliss' );
		$value .= esc_html('&quot;: ', 'bliss');
		return  $value;
		}
	
	
	
	
	if(is_404()){ return esc_html('404 Not Found', 'bliss'); }
	
	if(is_home()){ return esc_html(get_option( 'blogname', '') . ' Blog', 'bliss'); }
	
	if(is_search()){ 
		return esc_html('Search results for ','bliss') . esc_html( get_search_query(), 'bliss') ;
	}	

	
	if(is_year()){ return get_the_time('Y'); }
	
	if(is_month()){
		$current_year = get_the_time('Y');
		echo "<a href='".get_year_link($current_year)."'>".$current_year."</a>".$markup;
		return get_the_time('F'); 
	}
	
	if(is_day() || is_time()){
	
		$current_year = get_the_time('Y');
		$current_month = get_the_time('m');
		$current_month_display = get_the_time('F');
		echo "<a href='".get_year_link($current_year)."'>".$current_year."</a>".$markup;
		echo "<a href='".get_month_link($current_year, $current_month)."'>".$current_month_display."</a>".$markup;
		return get_the_time('jS (l)'); 
	}
	
	
	if(is_post_type_archive('work')){
		return 'Portfolio';
	}
	
}// end simple_breadcrumb_case

}
?>