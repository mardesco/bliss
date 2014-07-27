<?php
//image.php

//used for displaying a single image.
//delete this page to default to using attachment.php
//


get_header();
if (have_posts()) :
   while (have_posts()) :
      the_post();
?>
<article>
<h1>
<?php the_title();//title of the post 
?></h1>

<?php
the_content();//full post content -- doesn't output diddly squat on an image page.

echo wp_get_attachment_image( $post->ID, 'full' );// this is how you display the image.
// see the documentation at http://codex.wordpress.org/Function_Reference/wp_get_attachment_image
?>

</article>
<?php
   endwhile;
endif;
get_sidebar();
get_footer(); 

?>