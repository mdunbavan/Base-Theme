<div id="wrapper">

<div id="header">

	<div id="branding" class="inner clearfix">
		<div class="logo">
			<a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
		</div>
		
		<p class="tagline"><?php bloginfo('description'); ?></p>
		
		<ul class="signup clearfix">
			<li id="email"><a href="http://feedburner.google.com/fb/a/mailverify?uri=cfs-resources&amp;loc=en_US" title="Signup for Email Updates">Email</a></li>
			<li id="rss"><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to RSS">RSS</a></li>
		</ul>
		
		<div class="searchbox">
			<?php include ( get_stylesheet_directory() . '/inc/searchform.php'); ?>
		</div>
	</div>

	<div id="primary-navigation" class="clearfix">
		<div class="inner clearfix">
			<ul class="clearfix">
				<?php main_navigation(); ?>
			</ul>
		</div>
	</div>
	
</div><!--// end #header -->
