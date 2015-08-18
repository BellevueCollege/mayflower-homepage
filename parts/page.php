<div class="content-padding">
	<?php if ( intval($post->post_parent) > 0 ) { ?>
		<h1><?php the_title(); ?></h1>
	<?php } ?>
</div>
<div class="content-padding">
	<?php the_content(); ?>
</div>
