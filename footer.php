<div id="footer">
	<div id="site-info" class="inner clearfix">
		<ul class="footer-navigation">
			<?php footer_navigation(); ?>
		</ul><!--// end .footer-navigation -->
		
		<p>&copy; Copyright <?php echo date("Y") ?> <?php bloginfo('name'); ?>. Website by <a href="http://www.kevinleary.net">kevinleary.net</a> &ndash; <a href="<?php echo wp_login_url(); ?>" title="Login to WordPress">Login</a></p>
	</div><!--// end #site-info -->
	
	<?php base_footer(); ?>
</div><!--// end #footer -->

</div><!--// end #wrapper -->

<?php wp_footer(); ?>

</body>
</html>
