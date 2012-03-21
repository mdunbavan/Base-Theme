<?php get_header(); ?>
</head>
<body <?php body_class(); ?>>
<?php base_header(); ?>

<?php get_template_part( 'branding' ); ?>

<div id="content" class="inner clearfix">

	<div id="content-main">
		<?php the_post(); ?>
		<?php get_template_part( 'post' ); ?>
		
		<?php comments_template(); ?>
	</div><!-- end #content-main -->
	
	<div id="content-sub">
		<?php get_sidebar(); ?>
	</div><!--// end ##content-sub -->

</div><!-- end #content -->

<?php get_footer(); ?>
