<?php
//searchform.php

?>

<form role="search" method="get" id="searchform" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text visuallyhidden">Search for:</span>
		<input type="search" class="search-field rounded" placeholder="Find your bliss." value="" name="s" title="Search for:" />
	</label>
	<input type="submit" class="search-submit rounded" value="Search" />
</form>