<?php get_header(); ?>

</head>
<body <?php body_class(); ?>>
<?php base_header(); ?>

<?php get_template_part( 'branding' ); ?>

<div id="content" class="inner clearfix">

<div id="content-main">

	<h1><?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; echo $count . ' Search Results Found for <span class="search-terms">&ldquo;' . $key . '&rdquo;</span>'; wp_reset_query(); ?></h1>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="entry">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<div class="entry-summary">
			<?php // Relevanssi search
			if (function_exists('relevanssi_the_excerpt')) { 
				relevanssi_the_excerpt(); 
			} else { 
				the_excerpt();
			} ?>
			<p class="permalink"><a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></p>
		</div><!-- .entry-summary -->
	</div>
 
<?php endwhile; ?>
		
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
	<div class="navigation clearfix">
		<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
		<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
	</div>
	<?php } ?>

<?php else: ?>

	<h2>Sorry, nothing matched your search criteria.</h2>
	<p>Please feel free to try again!<p/>
	<p><?php include( get_stylesheet_directory_uri() . '/inc/searchform.php' ); ?></p>
 
<?php endif; ?>
	
</div><!-- end #content-main -->

<div id="content-sub">
	<?php get_sidebar(); ?>
</div><!--// end ##content-sub -->

</div><!-- end #content -->

<?php get_footer(); ?>
