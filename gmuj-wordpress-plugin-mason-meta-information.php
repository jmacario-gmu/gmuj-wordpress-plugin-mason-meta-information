<?php

/**
 * Plugin Name:       Mason WordPress: Mason Meta Information
 * Plugin URI:        https://github.com/jmacario-gmu/gmuj-wordpress-plugin-mason-meta-information
 * Description:       Mason WordPress plugin which implements the addition of Mason-related website meta information into the website's HTML meta tags.
 * Version:           0.0.1
 */

// Exit if this file is not called directly.
	if (!defined('WPINC')) {
		die;
	}

// add sub-level administrative menu
function gmuj_mmi_add_sublevel_menu() {
	
	/*
	
	add_submenu_page(
		string   $parent_slug,
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug, 
		callable $function = ''
	);
	
	*/
	
	add_submenu_page(
		'options-general.php',
		'Mason Meta Information',
		'Mason Meta',
		'manage_options',
		'mason_meta',
		'gmuj_mmi_display_settings_page'
	);
	
}
add_action( 'admin_menu', 'gmuj_mmi_add_sublevel_menu' );

// display the plugin settings page
function gmuj_mmi_display_settings_page() {
	
	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;
	
	?>
	
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			
			<?php
			
			// output security fields
			settings_fields( 'gmuj_mmi_options' );
			
			// output setting sections
			do_settings_sections( 'gmuj_mmi' );
			
			// submit button
			submit_button();
			
			?>
			
		</form>
	</div>
	
	<?php
	
}

// register plugin settings
function gmuj_mmi_register_settings() {
	
	/*
	
	register_setting( 
		string   $option_group, 
		string   $option_name, 
		callable $sanitize_callback = ''
	);
	
	*/
	
	register_setting( 
		'gmuj_mmi_options', 
		'gmuj_mmi_options', 
		'gmuj_mmi_callback_validate_options' 
	); 
	
	/*
	
	add_settings_section( 
		string   $id, 
		string   $title, 
		callable $callback, 
		string   $page
	);
	
	*/
	
	add_settings_section( 
		'gmuj_mmi_section_settings', 
		'General Settings', 
		'gmuj_mmi_callback_section_settings', 
		'gmuj_mmi'
	);
	
	/*
	
	add_settings_field(
    	string   $id, 
		string   $title, 
		callable $callback, 
		string   $page, 
		string   $section = 'default', 
		array    $args = []
	);
	
	*/
	
	add_settings_field(
		'custom_field',
		'Custom Field',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi', 
		'gmuj_mmi_section_settings', 
		[ 'id' => 'custom_field', 'label' => 'Custom meta field' ]
	);
	
} 
add_action( 'admin_init', 'gmuj_mmi_register_settings' );

// callback: settings section
function gmuj_mmi_callback_section_settings() {
	
	echo '<p>'. 'These settings enable you to customize the meta tags.' .'</p>';
	
}

// callback: text field
function gmuj_mmi_callback_field_text( $args ) {
	
	$options = get_option( 'gmuj_mmi_options', gmuj_mmi_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	echo '<input id="gmuj_mmi_options_'. $id .'" name="gmuj_mmi_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="gmuj_mmi_options_'. $id .'">'. $label .'</label>';
	
}


// default plugin options
function gmuj_mmi_options_default() {

	return array(
		'custom_field'   => 'custom data'
	);

}

// callback: validate options
function gmuj_mmi_callback_validate_options( $input ) {
	
	// custom title
	if ( isset( $input['custom_field'] ) ) {
		
		$input['custom_field'] = sanitize_text_field( $input['custom_field'] );
		
	}
	
	return $input;
	
}

// output meta tags
function gmuj_mmi_add_meta_tags() {
	
	echo '<meta name="test" content="test">';
	
}
add_action('wp_head', 'gmuj_mmi_add_meta_tags', 99);