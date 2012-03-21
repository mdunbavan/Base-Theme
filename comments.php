<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		wp_die('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<div class="comments-area">

<?php if ( have_comments() ) : ?>

	<h2 id="comments-title"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to <strong>&#8220;<?php the_title(); ?>&#8221;</strong></h2>

	<ol class="commentlist">
		<?php wp_list_comments('callback=base_threaded_comment'); ?>
	</ol>

	<?php if( get_comments_number() > get_option('comments_per_page') ): ?>
	<ul class="navigation clearfix">
		<li class="alignleft"><?php previous_comments_link() ?></li>
		<li class="alignright"><?php next_comments_link() ?></li>
	</ul>
	<?php endif; ?>
	
<?php else : // this is displayed if there are no comments so far ?>

	<h2 id="comments-title"><span>Comments</span></h2>
	
	<?php if ('open' == $post->comment_status) : ?>
	<p>No comments have been added yet.</p>
	
	<?php else : // comments are closed ?>
	<p class="nocomments">Comments are closed.</p>
	
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<h2 id="reply"><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?> <?php cancel_comment_reply_link('Cancel Reply'); ?></h2>

<?php 
if ( get_option('comment_registration') && !$user_ID ) : 
	global $post;
?>

<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink($post->ID)); ?>">logged in</a> to post a comment.</p>

<?php else : ?>

<div id="commentsform">
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php comment_id_fields(); ?>

<?php if ( $user_ID ) : ?>

	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink($post->ID)); ?>" title="Log out of this account">Logout&hellip;</a></p>

<?php else : ?>

	<p>
		<label for="author">Name <small class="required">*</small></label>
		<input type="text" name="author" id="s1" value="<?php echo $comment_author; ?>" size="40" tabindex="1" class="required" />
	</p>
	<p>
		<label for="email">Mail <em class="notice">(will not be published)</em> <small class="required">*</small></label>
		<input type="text" name="email" id="s2" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" class="required email" />
	</p>
	<p>
		<label for="url">Website</label>
		<input type="text" name="url" id="s3" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
	</p>

<?php endif; ?>

	<p>
		<label for="s4">Comment <small class="required">*</small></label>
		<textarea name="comment" id="s4" rows="10" tabindex="4" class="required"></textarea>
	</p>

	<p class="comment-disclaimer">By submitting a comment here you grant <strong><?php bloginfo('name'); ?></strong> a perpetual license to reproduce your words and name/web site in attribution. Inappropriate comments will be removed at admin's discretion.</p>

	<input name="submit" type="submit" id="sbutt" tabindex="5" value="Submit Comment" />
	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />

<?php do_action('comment_form', $post->ID); ?>

</form>
</div><!-- end #commentsform -->

</div><!-- end #respond -->

</div><!--// end .comments-area -->

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
