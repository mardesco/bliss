<?php
//tag.php

//display a page for a tag.
//see http://codex.wordpress.org/Tag_Templates
//included automatically
//delete this page to default to archive.php (or index.php) instead


get_header();
?><h1>Items tagged: <?php
single_tag_title();//title of the post 
?></h1>

		<div id="breadcrumbs">
			<div class="content">
				You are here: 
				<?php 
				// this one constructor does the whole thing.  
				$crumbs = new simple_breadcrumb(); 
			?>
			</div>
		</div>


<?php
if (have_posts()) :
   while (have_posts()) :
      the_post();
?>
<article>
<h3>
<?php
// our custom function outputs the title within a permalink, all properly escaped to prevent XSS attacks. 
// see http://codex.wordpress.org/Theme_Development#Untrusted_Data
bliss_clean_title_link();
?>
</h3>
<?php
//you probably want to show an excerpt of every post that has this tag.
//for that you can use:

the_excerpt();
//doesn't require a read more link at the bottom, 
//because I've built those into the_excerpt from functions.php

?>

</article>
<?php
   endwhile;
   
   else:
   
   _e("Sorry, no articles found with this tag.", 'bliss');
   
endif;

paginate(); //blog archive pagination!

get_sidebar();
get_footer(); 

?>