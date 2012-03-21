<?php $post_ID = get_the_ID(); ?>
<div id="post-<?php _e($post_ID); ?>" <?php post_class('post clearfix'); ?>>
	<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	
	<div class="content clearfix">
		<div class="post-info clearfix">
			<span class="post-date"><?php the_time( get_option('date_format') ); ?></span>
			<span class="post-author"> by <strong><?php the_author_posts_link(); ?></strong></span>
			<span class="post-comments"><?php comments_popup_link( __('No Comments'), __('1 Comment'), __('% Comments') ); ?></span>
		</div><!--// end .post-info -->
		
		<div class="entry">
			<?php the_content( __('Continue Reading&hellip;') ); ?>
		</div><!--// end .entry -->
		
		<?php if( function_exists('base_social_sharing_widgets') ) base_social_sharing_widgets( $post_ID ); ?>
	</div><!--// end .content -->
</div><!--// end #post-XX -->