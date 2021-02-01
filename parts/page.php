<?php
/**
 * Page Template Part
 *
 * @package Mayflower-Homepage
 */

?>
<article>
	<?php the_content(); ?>
	<div class="clearfix"></div>
	<p id="modified-date" class="text-right"><small>
	<?php
	esc_attr_e( 'Last Updated ', 'mayflower' );
	the_modified_date();
	?>
	</small></p>
</article>
