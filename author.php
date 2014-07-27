<?php
//author.php

//included automatically if there is no Category page (or if this is an archive lookup)
//delete to default to index.php instead

//display an author page
//see http://codex.wordpress.org/Author_Templates


//link to this page by calling the_author_posts_link()  

/*
 * 
 * to get more specific you could also make versions of this page, 
 * with php files named after the associated query term, eg:
 * 
 * author-{id}.php
 * or
 * author-{nicename}.php
 * 
 */



$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));


get_header();
?>
<h1>Posts by 
<?php 
//the_title();//title of the post 


$curauth->first_name .' ';

if($curauth->nickname && $curauth->nickname != ''){
echo '&quot;';
$curauth->nickname;
echo '&quot; ';//note the extra space...
}

$curauth->last_name;

//as usual, many more available...
?>
</h1>
		<div id="breadcrumbs">
			<div class="content">
				You are here: 
				<?php 
				// this one constructor does the whole thing.  
				$crumbs = new simple_breadcrumb(); 
			?>
			</div>
		</div>	
<ul class="author-post-list">
<?php
if (have_posts()) :
   while (have_posts()) :
      the_post();
	  
/* post_class is required by ThemeCheck */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
<?php
	//ThemeCheck complains that I'm not using get_option('date_format') instead of the_time() here:
	?>
        <li>
            <?php
			// our custom function outputs the title within a permalink, all properly escaped to prevent XSS attacks. 
			// see http://codex.wordpress.org/Theme_Development#Untrusted_Data
			bliss_clean_title_link();
			?>, posted 
            <?php 
			// ThemeCheck just really can't stand this line:
			//the_time('d M Y'); 
			
			// instead, it wants me to call:
			get_option('d M Y');
			
			?> in <?php the_category('&');?>
        </li>


</article>
<?php
   endwhile;
   else: ?>
        <p><?php _e('No posts by this author.', 'bliss'); ?></p>

    <?php 
endif;
?>
</ul>
<?php

get_sidebar();//author-specific sidebars?
get_footer(); 

?>