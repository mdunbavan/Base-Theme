<?php
/**
 * Theme Options Class
 *
 * A modular class for building WordPress theme options pages
 *
 * PHP 5
 *
 * LICENSE: This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @package    WordPress
 * @author     Kevin Leary <info@kevinleary.net>
 * @version    1.51
 * @see        add_options_page(), get_option(), do_settings_sections(), 
 *					settings_fields(), register_setting(), add_settings_error()
 */
class BaseThemeOptions
{
	// Settings
	public $page_title = 'Base Theme Options';
	public $menu_title = 'Theme Options';
	public $capability = 'manage_options';
	public $parent_page = 'themes.php';
	public $namespace = 'base_theme';
	public $option_group;
	public $field_count = 0;
	public $upload_field = false;
	
	/**
	 * Setup the class
	 */
	public function __construct() {
		add_action( 'admin_menu', array($this, 'register_settings') );
		$this->option_group = $this->namespace . '_options';
	}
	
	/**
	 * Register the settings
	 *
	 * http://codex.wordpress.org/Function_Reference/register_setting
	 */
	public function register_settings() {
		// Register settings in database
		register_setting(
			$base_options->option_group, // $this->option_group
			$base_options->option_group, // $option_name
			array($base_options, 'validate_options') // $sanitize_callback
		);
	}
	
	/**
	 * Get option values from the database
	 */
	public function get_options() 
	{
		return get_option( $this->option_group );
	}

	/**
	 * Add Menu Page
	 *
	 * Add a submenu for our option page under "Appearance"
	 * http://codex.wordpress.org/Function_Reference/add_submenu_page
	 */
	public function add_page() 
	{
		add_submenu_page( $this->parent_page, $this->page_title, $this->menu_title, $this->capability, $this->option_group, array($this, 'option_page') );
	}
	
	// Draw the option page
	public function option_page() 
	{
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e($this->page_title); ?></h2>
			<form action="options.php" method="post">
				<?php 
				settings_fields( $this->option_group );
				do_settings_sections( esc_attr($_GET['page']) );
				?>
				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes">
				</p>
			</form>
		</div>
		<?php
	}
	
	// Social Media Settings
	public function social_media() 
	{
		echo '<p>Social media settings.</p>';
	}
	
	// Text field
	public function setting_field( $args ) 
	{
		$this->field_count++;
		
		// Get arguments
		$defaults = array(
			'type' => 'text', // Default to text fields
			'id' => 'field_' . $this->field_count, // If not ID is given generate a unique one
			'rows' => 8, // The number of rows used for textareas and editors
			'required' => false // Not programmed yet
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args, EXTR_SKIP );
		
		// Get options from DB
		$options = $this->get_options();
		
		if ( isset($_GET['test']) && strip_tags($_GET['test']) == 'yes' ) {
			echo '<pre>';
			print_r($options);
			echo '</pre>';
		}
		
		// Different cases for each form field type
		switch ( $type ) {
		
			// Single line text field
			case "text":
				// Sanitize
				$value = ( isset($options[$id]) && !empty($options[$id]) ) ? esc_attr($options[$id]) : '';
				
				// HTML
				$field = '<input id="' . $this->namespace . '_' . $id . '" name="' . $this->namespace . '_options[' . $id . ']" type="text" value="' . $value . '" />';
				break;
			
			// Content block textarea
			case "textarea":
				// Sanitize
				$value = ( isset($options[$id]) && !empty($options[$id]) ) ? esc_textarea($options[$id]) : '';
				
				// HTML
				$field = '<textarea rows="' . $rows . '" id="' . $this->namespace . '_' . $id . '" name="' . $this->namespace . '_options[' . $id . ']" class="large-text">' . $value . '</textarea>';
				break;
			
			// Multiple choice radio buttons
			case "radio":
			case "checkbox":
				// Sanitize
				if ( !is_array($options[$id]) )
					$value = ( isset($options[$id]) && !empty($options[$id]) ) ? esc_attr($options[$id]) : '';
				else
					$value = $options[$id];
					
				// HTML
				if ( isset($choices) && !empty($choices) ) {
					$field = '';
					$last_choice = end($choices);
					$multistorage = ( $type == 'checkbox' ) ? '[]' : '';
					foreach ( $choices as $label => $fieldval ) {
						// Get checked status, handle a special case for checkboxes with multiple values stored as array
						if ( is_array($value) )
							$checked = ( in_array($fieldval, $value) ) ? 'checked="checked"' : '';
						else	
							$checked = checked( $fieldval, $value, false );
							
						$field .= '<label>
							<input type="' . $type . '" name="' . $this->namespace . '_options[' . $id . ']' . $multistorage . '" value="' . $fieldval . '" ' . $checked . ' />
							<span>' . $label . '</span>
						</label>';
						
						if ( $fieldval != $last_choice )
							$field .= '<br />';
					}
				}
				break;
			
			// Dropdown select box
			case "select":
				// Sanitize
				$value = ( isset($options[$id]) && !empty($options[$id]) ) ? esc_attr($options[$id]) : '';
				// HTML
				if ( isset($choices) && !empty($choices) ) {
					$field = '<select name="' . $this->namespace . '_options[' . $id . ']" id="' . $this->namespace . '_options[' . $id . ']">';
					$field .= '<option value="" ' . selected( $value, '', false ) . '>' . $label . '</option>';
					foreach ( $choices as $label => $fieldval ) {
						$field .= '<option value="' . $fieldval . '" ' . selected( $value, $fieldval, false ) . '>' . $label . '</option>';
					}
					$field .= '</select>';
				}
				break;
				
			// Visual editor (TinyMCE)
			case "tinymce":
				// Sanitize
				$id = 'tinymce_' . $id;
				$value = ( isset($options[$id]) && !empty($options[$id]) ) ? $options[$id] : '';
				
				// Add TinyMCE visual editor
				wp_editor( $value, $this->namespace . '_options[' . $id . ']', array(
					'textarea_rows' => $rows,
					'editor_class' => 'settings-tinymce'
				) );
				
				break;
				
			// Media upload button
			case "upload":	
				// Queue JS for uploader
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
					
				// Sanitize
				$id = 'upload_' . $id;
				$value = ( isset($options[$id]) && !empty($options[$id]) ) ? esc_url($options[$id]) : '';
				$field = '<p class="upload-field">
					<input name="' . $this->namespace . '_options[' . $id . ']' . '" id="' . $this->namespace . '_options[' . $id . ']' . '" type="text" value="' . $value . '" size="40" />
					<input type="button" class="button-secondary media-library-upload" rel="' . $this->namespace . '_options[' . $id . ']' . '" alt="Add Media" value="Add Media" />
					<input type="button" class="button-secondary media-library-remove" rel="' . $this->namespace . '_options[' . $id . ']' . '" value="Remove Media" />
				</p>';
				
				if ( !empty($value) )
					$field .= '<p><img src="' . $value . '" class="upload-image-preview" /></p>';
				
				break;
		}
		
		// Print the form field
		if ( isset($field) && !empty($field) ) 
			_e( $field );
		
		// Description
		if ( $description )
			_e( '<p class="description">' . $description . '</p>' );
	}
	
	// Validate user input (we want text only)
	public function validate_options( $input ) 
	{
		// Escape text input
		array_walk( $input, function( $val, $key ) use( &$input ) { 
			// Special case for media uploads
			if ( strstr($key, 'upload_') ) {
				$input[$key] = esc_url($val);
			}
			// Don't validate TinyMCE data or checkbox arrays
			else if ( !strstr($key, 'tinymce_') && !is_array($val) ) {
				$input[$key] = esc_attr($val);
			}
		} );
			
		return $input;
	}
}