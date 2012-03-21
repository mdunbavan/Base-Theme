<?php
/**
 * Main navigation
 */
function main_navigation() {
	wp_list_pages('title_li=&sort_column=menu_order&depth=2');
}

/**
 * Footer navigation
 */
function footer_navigation() {
	wp_list_pages('title_li=&sort_column=menu_order&depth=0');
}

/**
 * Theme hooks
 */
function base_header() { do_action('base_header'); }
function base_footer() { do_action('base_footer'); }

/**
 * Admin CSS & JS customizations
 */
function base_admin_css() {
	wp_enqueue_style('base-admin-css', get_template_directory_uri() . '/css/admin.css', false, '1.0', 'all');
	wp_enqueue_script('base-admin', get_stylesheet_directory_uri() . '/js/admin.js', array('jquery'), '1.0', true);
}
add_action('admin_init', 'base_admin_css');

/**
 *  Load core JavaScript
 */
function base_head_javascript() {
	// Don't load in the admin (ever)
	if ( is_admin() ) 
		return false;
	
	// Load the latest version of jQuery
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, '');
	wp_enqueue_script('jquery');
	
	// Threaded comments with jQuery validation
	if ( is_singular() && comments_open() && ( get_option('thread_comments') == 1 ) ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script('jquery-validate', 'http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js', array('jquery'), '1.0');
	}
	
	// Remove translations
	wp_deregister_script('l10n');
	
	// Theme JS
	wp_enqueue_script( 'headjs', get_stylesheet_directory_uri() . '/js/head.load.min.js', false, filemtime( get_stylesheet_directory() . '/js/head.load.min.js' ), true );
	wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js/global.js', array('headjs', 'jquery'), filemtime( get_stylesheet_directory() . '/js/global.js' ), true );
}
add_action('wp_enqueue_scripts', 'base_head_javascript');

/**
 * Theme JavaScript
 */
function base_theme_init() {
	// Load all JavaScript in the footer
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);
	add_action('wp_footer', 'wp_print_scripts', 5);
	add_action('wp_footer', 'wp_enqueue_scripts', 5);
	add_action('wp_footer', 'wp_print_head_scripts', 5);
}
add_action('init', 'base_theme_init');

/**
 * Them Options Page
 *
 * Settings API builder class to rapidly create a theme options page
 */
function base_theme_options() {

	// Settings API builder class
	include_once( get_stylesheet_directory() . '/inc/settings.php' );
	$base_options = new BaseThemeOptions();
	
	// Create a section group: "Social Media" (begins with <h3> & description)
	add_settings_section(
		$base_options->namespace . '_section_social_media',
		'Social Media',
		array($base_options, 'social_media'),
		$base_options->option_group
	);
	
	// Twitter username
	add_settings_field(
		$base_options->namespace . '_twitter_username', // $id
		'Twitter Username',	// $title
		array($base_options, 'setting_field'), // $callback
		$base_options->option_group, // $page
		$base_options->namespace . '_section_social_media', // $section
		array(
			'type' => 'text', // The type of form field to create
			'id' => 'twitter_username', // The ID for the field: used for ID and NAME attributes
			'description' => 'A description or note for this field'
		) // $args
	);
	
	// Radio
	add_settings_field(			
		$base_options->namespace . '_radio_example', // $id
		'Multiple Choice', // $title
		array($base_options, 'setting_field'), // $callback
		$base_options->option_group, // $page
		$base_options->namespace . '_section_social_media', // $section
		array(
			'type' => 'radio', // The type of form field to create
			'id' => 'radio_example', // The ID for the field: used for ID and NAME attributes
			'choices' => array( // Radio, checkbox and select choices
				'Yes' => 'yes', // Label => Value
				'No' => 'no'
			),
			'description' => 'A description or note for this radio field'
		) // $args
	);
	
	// Checkboxes
	add_settings_field(			
		$base_options->namespace . '_checkbox_example', // $id
		'Checklist', // $title
		array($base_options, 'setting_field'), // $callback
		$base_options->option_group, // $page
		$base_options->namespace . '_section_social_media', // $section
		array(
			'type' => 'checkbox', // The type of form field to create
			'id' => 'checkbox_example', // The ID for the field: used for ID and NAME attributes
			'choices' => array( // Radio, checkbox and select choices
				'Option #1' => 1, // Label => Value
				'Option #2' => 2,
				'Option #3' => 3,
				'Option #4' => 4,
				'Option #5' => 5
			),
			'description' => 'A description or note for this checkbox field'
		) // $args
	);
	
	// Dropdown
	add_settings_field(			
		$base_options->namespace . '_dropdown_example', // $id
		'Dropdown', // $title
		array($base_options, 'setting_field'), // $callback for displaying form HTML
		$base_options->option_group, // $page
		$base_options->namespace . '_section_social_media', // $section
		array(
			'type' => 'select', // The type of form field to create
			'id' => 'dropdown_example', // The ID for the field: used for ID and NAME attributes
			'label' => 'Choose one&hellip;',
			'choices' => array( // Radio, checkbox and select choices
				'Option #1' => 1, // Label => Value
				'Option #2' => 2,
				'Option #3' => 3,
				'Option #4' => 4,
				'Option #5' => 5
			),
			'description' => 'A description or note for this dropdown field'
		) // $args
	);
	
	// Textarea
	add_settings_field(			
		$base_options->namespace . '_textarea_example', // $id
		'Multiline Text', // $title
		array($base_options, 'setting_field'), // $callback for displaying form HTML
		$base_options->option_group, // $page
		$base_options->namespace . '_section_social_media', // $section
		array(
			'type' => 'textarea', // The type of form field to create
			'id' => 'textarea_example', // The ID for the field: used for ID and NAME attributes
			'description' => 'A description or note for this textarea field'
		) // $args
	);
	
	// TinyMCE Visual Editor
	add_settings_field(			
		$base_options->namespace . '_tinymce_example', // $id
		'Visual Editor', // $title
		array($base_options, 'setting_field'), // $callback for displaying form HTML
		$base_options->option_group, // $page
		$base_options->namespace . '_section_social_media', // $section
		array(
			'type' => 'tinymce', // The type of form field to create
			'id' => 'visualeditor', // The ID for the field: used for ID and NAME attributes
			'rows' => 12,
			'description' => 'A description or note for this tinymce field'
		) // $args
	);
	
	// Media Upload Button
	add_settings_field(			
		$base_options->namespace . '_upload_example', // $id
		'Media Library Upload / Picker', // $title
		array($base_options, 'setting_field'), // $callback for displaying form HTML
		$base_options->option_group, // $page
		$base_options->namespace . '_section_social_media', // $section
		array(
			'type' => 'upload', // The type of form field to create
			'id' => 'medialibrary', // The ID for the field: used for ID and NAME attributes
			'description' => 'A description or note for this media library upload field'
		) // $args
	);
	
	// Action hooks
	$base_options->add_page();
}
add_action('admin_menu', 'base_theme_options');

/**
 * AJAX Social Sharing Widgets
 *
 * @global $post
 * @param $post_ID
 * @return Prints the HTML for the widgets: Twitter, Google+, Facebook, LinkedIn
 */
function base_social_sharing_widgets( $post_ID = NULL ) {
	if ( !$post_ID ) {
		global $post;
		$post_ID = $post->ID;
	}
	?>
	<div class="ajax-sharing-widgets clearfix" id="sharing-<?php echo $post_ID; ?>">
		<a href="<?php echo get_permalink($post_ID); ?>" class="ajax-sharing-link"><?php echo apply_filters('the_title', $post->post_title); ?></a>
		<div class="platform twitter" id="tweet-newshare-<?php echo $post_ID; ?>"></div>
		<div class="platform gplus"><span id="gplus-newshare-<?php echo $post_ID; ?>"></span></div>
		<div class="platform linkedin" id="linkedin-newshare-<?php echo $post_ID; ?>"></div>
		<div class="platform facebook" id="fb-newshare-<?php echo $post_ID; ?>"></div>
	</div>
	<?php
}

/**
 * Add Facebook root for sharing
 */
function base_add_fb_root() {
	_e('<div id="fb-root"></div>');
}
add_action('base_header', 'base_add_fb_root');

/**
 * Pass PHP to JS for AJAX Social Media Widgets
 */
function base_php_to_js() {
	$settings = array(
		// Google analytics
		'ga_ua' => 'UA-1979028-1',
		// AJAX sharing widgets
		'twitter_count' => 'horizontal',
		'twitter_via' => 'kevinlearynet',
		'twitter_related' => 'wpengineer',
		'facebook_layout' => 'button_count',
		'google_size' => 'medium',
		'linkedin_data_counter' => 'right'
	);
	wp_localize_script( 'global', 'base_settings', $settings );
}
add_action( 'wp_enqueue_scripts', 'base_php_to_js' );

/**
 * Open Graph Protocol & Google+ attributes for HTML tag
 *
 * http://ogp.me/
 * http://developers.facebook.com/docs/opengraph/
 * http://www.google.com/intl/en/webmasters/+1/button/index.html
 */
function base_social_rdfa_attrs($output) {
	return $output . ' xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'base_social_rdfa_attrs');

/**
 * Open graph protocol tags for social sharing
 *
 * These are added the the <head> section of your theme
 */
function base_open_graph_protocol() {
	global $post;

	// Use post thumbnail
	if ( current_theme_supports('post-thumbnails') && has_post_thumbnail($post->ID) ) {
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' ); // Default 300x300 px
	}
	
	// No post thumbnail set
	else {
		// If an attachment image has been found in the post use the first one
		$attachments = get_children( 'post_type=attachment&post_parent='. $post->ID );
		if ( isset($attachments) && !empty($attachments) ) {
			$image = current($attachments);
			$thumbnail = wp_get_attachment_image_src( $image->ID, 'medium' );  // Default 300x300 px
		}
	}
	
	// If no image then use a standard fallback logo
	$thumbnail = ( isset($thumbnail) && is_array($thumbnail) ) ? $thumbnail[0] : get_stylesheet_directory_uri() . '/images/kevin-leary-open-graph-logo.png';
	
	// Use the excerpt if it exists
	if ( isset($post->post_excerpt) && !empty($post->post_excerpt) ) {
		$description = esc_attr($post->post_excerpt);
	}
	// If no excerpt is found then trim the post content down to 115 characters, the Open Graph limit
	else {
		$content = strip_shortcodes( $post->post_content );
		$content = strip_tags( $content );
		$description = wp_trim_words( $content, 115, '&hellip;' );
	}
	
	// Type of resource
	$type = 'website'; // Full list of options: http://developers.facebook.com/docs/opengraph/#types
	?>
	<!-- Open Graph Protocol : OGP -->
	<meta property="og:title" content="<?php echo get_the_title($post->ID); ?>" />
	<meta property="og:type" content="<?php echo $type; ?>" />
	<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>" />
	<meta property="og:image" content="<?php echo $thumbnail; ?>" />
	<meta property="og:description" content="<?php echo $description; ?>" />
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
	<meta property="og:locale" content="<?php echo get_locale(); ?>" /><?php
}
add_action('wp_head', 'base_open_graph_protocol', 99);

/**
 * Register sidebar zones
 */
function base_theme_sidebars() {
	if ( function_exists('register_sidebar') ) {
		register_sidebar( array(
			'name'=>'Page',
			'before_widget' => '<div id="%1$s" class="callout %2$s">',
			'after_widget' => '</div><!--// end #%1$s -->',
			'before_title' => '<h2>',
			'after_title' => '</h2>'
		) );
		register_sidebar( array(
			'name'=>'Single',
			'before_widget' => '<div id="%1$s" class="callout %2$s">',
			'after_widget' => '</div><!--// end #%1$s -->',
			'before_title' => '<h2>',
			'after_title' => '</h2>'
		) );
		register_sidebar( array(
			'name'=>'Blog',
			'before_widget' => '<div id="%1$s" class="callout %2$s">',
			'after_widget' => '</div><!--// end #%1$s -->',
			'before_title' => '<h2>',
			'after_title' => '</h2>'
		) );
	}
}
add_action( 'init', 'base_theme_sidebars' );

/**
 * Listing title display
 */
function listing_title() {
	$query = get_queried_object();
	$listing_title = ( single_term_title() ) ? single_term_title() : apply_filters('the_title', $query->post_title);
	if ( $listing_title ) 
		echo $listing_title;
}

/**
 * Pagination for archive, taxonomy, category, tag and search results pages
 *
 * @global $wp_query http://codex.wordpress.org/Class_Reference/WP_Query
 * @return Prints the HTML for the pagination if a template is $paged
 */
function base_pagination() {
	global $wp_query;
	
	$big = 999999999; // This needs to be an unlikely integer
	
	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$paginate_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5
	) );
	
	// Display the pagination if more than one page is found
	if ( $paginate_links ) {
		echo '<div class="pagination">';
		echo $paginate_links;
		echo '</div><!--// end .pagination -->';
	}
}

/**
 * Setup threaded comments
 */
function base_threaded_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="author-data">
				<?php echo get_avatar($comment,$size='40',$default='<path_to_url>' ); ?>
				<?php printf(__('<h3 class="author">%s</h3>'), get_comment_author_link()) ?>
				<div class="comment-meta commentmetadata"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?> <?php edit_comment_link(__('(Edit)'),'  ','') ?></div>
			</div>
<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.') ?></em>
<?php endif; ?>
			<div class="comment-entry">
				<?php comment_text() ?>
			</div>
			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
		</div>
	</li>
<?php
}