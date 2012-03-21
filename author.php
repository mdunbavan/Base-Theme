<?php 
get_header();
$author_id = $post->post_author;
$author_info = get_userdata($author_id);
$description = get_the_author_meta( 'description', $author_id );
?>
</head>
<body <?php body_class(); ?>>
<?php base_header(); ?>

<?php get_template_part( 'branding' ); ?>

<div id="content" class="inner clearfix">

<div id="content-main">
	<h1 class="archive-title">Articles by &ldquo;<?php echo apply_filters('the_title', $author_info->user_nicename); ?>&rdquo;</h1>
	
<?php if ( $description ): ?>
<div class="author-bio clearfix">
	<h2 class="caps-title">About The Author</h2>
	<?php if ( function_exists('get_avatar') ) echo get_avatar($author_id, '100'); ?>
	<div class="entry">
		<?php echo $description; ?>
	</div>
</div>
<?php endif; ?>
		
	<?php get_template_part( 'loop' ); ?>
</div><!-- end #content-main -->

<div id="content-sub">
	<?php get_sidebar(); ?>
</div><!--// end ##content-sub -->

</div><!-- end #content -->

<?php get_footer(); ?>