<?php get_header(); ?>
</head>
<body <?php body_class(); ?>>
<?php base_header(); ?>

<?php get_template_part( 'branding' ); ?>

<div id="content" class="inner clearfix">

<div id="content-main">
	<?php get_template_part( 'loop' ); ?>
</div><!-- end #content-main -->

<div id="content-sub">
	<?php get_sidebar(); ?>
</div><!--// end ##content-sub -->

</div><!-- end #content -->

<?php get_footer(); ?>
