<?php
//metaboxes.php

/*
@package metaboxes
@contributors Rilwis, Justin Tadlock, and Jesse Smith
@license GPLv2
@description Custom fields for page subtitles or product meta data, and the input boxes to define them.  

@notes
This feature is based on the work shared by Rilwis at
http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html 
and informed by Justin Tadlock's tutorial on Smashing Magazine, posted at
http://wp.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
as well as additional tinkering by Jesse Smith for Mardesco.

@notes
I see that Rilwis has released an updated version of the script as a stand-alone plugin at http://wordpress.org/plugins/meta-box/
which is probably more suitable for general purposes
but THIS version of the script is fully integrated into the present theme design.  
*/

if(is_admin() === true){
	// within the admin area, we want to add the input field to the editor.
	
$prefix = 'bliss_';

		$slideshow_options = array(
			'none' => __('No slideshow', 'bliss'),
			'uses_slideshow_1' => __('Display Slideshow 1', 'bliss'),
			'uses_slideshow_2' => __('Display Slideshow 2', 'bliss'),
			'uses_slideshow_3' => __('Display Slideshow 3', 'bliss')
		);

		$slideshow_options = array(
			__('No slideshow', 'bliss') => 'none',
			__('Display Slideshow 1', 'bliss') => 'uses_slideshow_1',
			__('Display Slideshow 2', 'bliss') => 'uses_slideshow_2',
			__('Display Slideshow 3', 'bliss') => 'uses_slideshow_3'
		);

		
$meta_box = array(
    'id' => 'bliss-meta-box',
    'title' => 'Your custom inputs',
    'page' => 'page',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
	//a default value goes under 'std' if you want one there
        array(
            'name' => 'Subtitle',
            'desc' => 'Enter the subtitle to be displayed by the page.',
            'id' => $prefix . 'subtitle',
            'type' => 'text',
            'std' => ''
        ),

		array(
            'name' => __('Slideshow Options', 'bliss'),
            'desc' => __('If this page/post will display a slideshow, select it from the dropdown menu.', 'bliss'),
			'std' => 'none',
			'type' => 'select',
			'options' => $slideshow_options,
            'id' => $prefix . 'slideshow'
		)	

		//add more fields as you like.  Don't forget to add them to the retrieve_post_meta function.
    )
);

add_action('admin_menu', 'bliss_add_box');
// Add meta box
function bliss_add_box() {
    global $meta_box;
    add_meta_box($meta_box['id'], $meta_box['title'], 'bliss_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function bliss_show_box() {
    global $meta_box, $post;
	
    // Use nonce for verification
    echo '<input type="hidden" name="bliss_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    echo '<table class="form-table">';
    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option=>$value) {
                    echo '<option value="'.$value.'" ', $meta == $value ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" value="true" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo     '</td><td>',
            '</td></tr>';
    }
    echo '</table>';
}

add_action('save_post', 'bliss_save_data');
// Save data from meta box
function bliss_save_data($post_id) {
    global $meta_box;
    // verify nonce
	
	if(!isset($_POST['bliss_meta_box_nonce'])){
	
		//because the save_post action is called when you save the nav menus, which do NOT have a bliss_meta_box_nonce and throw an error
		return false;
	}
	
    if (!wp_verify_nonce($_POST['bliss_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
			// the wp function update_post_meta calls update_metadata, which strips slashes then runs the data through a call to sanitize_meta
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
	

	}else{//else we're not in the admin area.
	
		// when displaying the page to a viewer:
		
		//add a subtitle and other custom text fields to your posts.
		
		// you can write a custom feature to format the array returned by this function.

		function bliss_retrieve_post_meta($id) { 
		
			// add more fields as you like.  we begin with a subtitle.
			$keys = array(
				$prefix . 'subtitle',
				$prefix . 'uses_slideshow_1',
				$prefix . 'uses_slideshow_2',
				$prefix . 'uses_slideshow_3'
			);
		
			$data = array();
			global $post;
			 
			/* Get the current post ID. */ 
			$post_id = $post->ID;  
			
			/* If we have a post ID, proceed. */ 
			if ( !empty( $post_id ) ) {
			
			foreach($keys as $key){
			
				/* Get the custom post meta. */ 
				
				$tmp = get_post_meta( $post_id, $key, true );  
				
				$data[$key] = esc_html($tmp);
				}  
			}
			
			return $data; 
			}	
		
		}
		
		//ThemeCheck complains if you use the internationalization translation function with the escaping of these variables.
		
		
		// a getter method just for subtitle post meta.
		function bliss_get_subtitle(){
			global $post;
			
			/* Get the current post ID. */ 
			$post_id = $post->ID;  
			$key = 'bliss_subtitle';
			$subtitle = get_post_meta( $post_id, $key, true );  
			if($subtitle && $subtitle != ''){
				return esc_html($subtitle);
				}else{
					return false;
					}
			
			}

			

/* end custom text fields. */


?>