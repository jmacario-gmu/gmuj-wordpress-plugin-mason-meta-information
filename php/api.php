<?php

/**
 * Summary: php file which implements the plugin custom API
 */

add_action('rest_api_init', 'gmuj_mmi_register_routes');

function gmuj_mmi_register_routes() {

	// Provide site organizational and contact info
	register_rest_route('gmuj-mmi', 'mason-site-info', array(
			'methods' => 'GET',
			'callback' => 'gmuj_mmi_get_mason_site_info',
		)
	);

}

function gmuj_mmi_get_mason_site_info() {

	// Get plugin options
	$gmuj_mmi_options = get_option('gmuj_mmi_options');

	// Get return data
	$return_data = array(
        'unit' => $gmuj_mmi_options['website_mason_unit'],
        'department' => $gmuj_mmi_options['website_mason_department'],
        'technical_contact' => $gmuj_mmi_options['website_contact_technical'],
        'content_contact' => $gmuj_mmi_options['website_contact_content'],
    );

	// Return value
	return $return_data;

}
