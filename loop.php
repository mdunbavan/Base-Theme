<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<?php get_template_part( 'post' ); ?>

<?php endwhile; ?>

	<?php if ( function_exists('base_pagination') ) { base_pagination(); } else if ( is_paged() ) { ?>
	<div class="navigation clearfix">
		<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
		<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
	</div>
	<?php } ?>
			
<?php else : ?>

	<h2 class="title">Nothing found</h2>
	<p>No posts have been found&hellip;</p>

<?php endif; ?>