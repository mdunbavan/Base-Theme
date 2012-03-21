<?php $post_ID = get_the_ID(); ?>
<div id="post-<?php _e($post_ID); ?>" <?php post_class('post clearfix'); ?>>
	<h1 class="post-title"><?php the_title(); ?></h2>
	
	<div class="content clearfix">
		<div class="post-info clearfix">
			<span class="post-date"><?php the_time( get_option('date_format') ); ?></span>
			<span class="post-comments"><?php comments_popup_link( __('No Comments'), __('1 Comment'), __('% Comments') ); ?></span>
			<?php if( function_exists('base_social_sharing_widgets') ) base_social_sharing_widgets( $post_ID ); ?>
		</div><!--// end .post-info -->
		
		<div class="entry">
			<?php the_content(); ?>
		</div><!--// end .entry -->
	</div><!--// end .content -->
</div><!--// end #post-XX -->