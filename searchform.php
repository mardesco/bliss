<?php
//searchform.php

?>

<form role="search" method="get" id="searchform" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text visuallyhidden">Search for:</span>
		<input type="search" class="search-field <?php
		global $bliss_corner_style;
		if($bliss_corner_style == 'rounded'){
			_e( ' rounded', 'bliss');
		}
		?>" placeholder="Find your bliss." value="" name="s" title="Search for:" />
	</label>
	<button class="search-submit small <?php
		if($bliss_corner_style == 'rounded'){
			_e( ' rounded', 'bliss');
		}
		?>" ><span class="fa fa-search"></span></button>
</form>