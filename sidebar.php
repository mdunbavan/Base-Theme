<div id="sidebar">
<?php function showDefault() { // Default Sidebar Content ?>

	<div class="searchbox">
		<?php include (get_stylesheet_directory() . '/inc/searchform.php'); ?>
	</div>
	
	<div class="callout">
		<h2>Pages</h2>
		<ul>
			<?php wp_list_pages('title_li=' ); ?>
		</ul>
	</div>
	
	<div class="callout">
		<h2>Recent Posts</h2>
		<ul>
			<?php 
			wp_get_archives(array(
				'type' => 'postbypost',
				'limit' => 10
			)); 
			?>
		</ul>
	</div>
	
	<div class="callout">
		<h2>Monthly Archives</h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</div>
	
	<div class="callout">
		<h2>Categories</h2>
		<ul>
			<?php wp_list_categories('show_count=1&title_li='); ?>
		</ul>
	</div>
	
	<div class="callout">
		<?php wp_list_bookmarks(); ?>
	</div>

<?php } ?>
	
<?php 
// Load Dynamic Sidebars
if( !function_exists('dynamic_sidebar') ) 
{ 
	showDefault();
} 
else 
{ 
	if( is_page() ) {
		if( !dynamic_sidebar('Page') ) showDefault();
	}
	else if( is_single() ) {
		if( !dynamic_sidebar('Post') ) showDefault();
	}
	else if( is_home() || is_archive() ) {
		if( !dynamic_sidebar('Blog') ) showDefault();
	}
}
?>
</div><!-- end #sidebar -->