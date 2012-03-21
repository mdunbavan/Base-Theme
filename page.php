<?php get_header(); ?>

</head>
<body <?php body_class(); ?>>
<?php base_header(); ?>

<?php get_template_part( 'branding' ); ?>

<div id="content" class="inner clearfix">

	<div id="content-main">
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<h1><?php the_title(); ?></h1>
		<div class="entry clearfix">
			<?php the_content();?>
		</div><!--// end #entry -->
		
		<?php endwhile; else: ?>
		
		<h2>Oops</h2>
		<p>Looks like something is missing...</p>
		
		<?php endif; ?>
	
	</div><!-- end #content-main -->
	
		<div id="content-sub">
		<?php get_sidebar(); ?>
		</div><!--// end ##content-sub -->

</div><!-- end #content -->

<?php get_footer(); ?>
