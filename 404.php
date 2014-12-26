<?php
/* 
 * 404
 *
 *
 */

get_header();

?>
	<h1>Error 404 - Page Not Found</h1>
		<div id="breadcrumbs">
			<div class="content">
				You are here: Lost.
			</div>
		</div>	
        <p>We're sorry, but the content you were searching for was unavailable.  Please try again.</p>
		
		<?php
		
		
		// as of version 0.1.1, 404 notification emails are now optional.
		
		$bliss_notification = of_get_option('bliss_404_notification', 'no');
		
		if($bliss_notification == 'yes'){
		
			/*		
			 * If selected, notify the webmaster when this page is called.
			 * include the referring page and the user's IP address in the notification
			 * because this page will usually be triggered either by bad links or hackers.
			 * sometimes, occasionally, a genuine mistake.
			 * and genuine mistakes are an opportunity to create a more intuitive UI.		
			 */
			
			
			if(isset($_SERVER['HTTP_REFERER'])){
				$referrer = esc_url($_SERVER['HTTP_REFERER']);
			}else{
				$referrer = 'Not set.';
			}	
			$requested = esc_url($_SERVER['REQUEST_URI']);
			$ip = esc_attr($_SERVER['REMOTE_ADDR']);
			// get the administrator's email address.
			if(function_exists('is_multisite') && is_multisite()){
					$to = get_site_option('admin_email');
				}else{
					$to = get_option('admin_email');
				}
				
			$subject = "Page Not Found on " . $_SERVER['SERVER_NAME'];

				$message = "A visitor to your website received a 404 error.  This visitor attempted to access nonexistent content on your website.  They may have followed a bad link, or they may have been attempting something malicious.  Either way, it could be something for you to look into.
				
				Visitor IP address:  $ip

				Requested page: $requested
				
				";
				if(isset($referrer) && $referrer){
					$message .= "They say they were referred by:  $referrer";
				}else{
					$message .= "This visitor's browser did not supply referral data.";
				}
				
			wp_mail($to, $subject, $message);			
			
		}	

 get_sidebar(); ?>

<?php get_footer(); ?>
