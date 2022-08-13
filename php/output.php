<?php

/**
 * Summary: php file which implements the HTML output
 */


/**
 * Outputs meta tags to web page HTML head section
 */
add_action('wp_head', 'gmuj_mmi_add_meta_tags', 99); // Giving it a priority of 99 means it is typically called last in the wp_head action, so these meta tags appear right before the closing head tag
function gmuj_mmi_add_meta_tags() {

	// Get plugin options
		$gmuj_mmi_options = get_option('gmuj_mmi_options');

	// Begin output
		echo PHP_EOL;
		echo "<!-- Mason Meta Information Plugin Output -->".PHP_EOL;

	// Output meta tags, if values are not empty
		// Mason unit
		if (!empty($gmuj_mmi_options['website_mason_unit'])) {
			echo '<meta name="mason-unit" content="'.$gmuj_mmi_options['website_mason_unit'].'">'.PHP_EOL;
		}
		// Mason department
		if (!empty($gmuj_mmi_options['website_mason_department'])) {
			echo '<meta name="mason-department" content="'.$gmuj_mmi_options['website_mason_department'].'">'.PHP_EOL;
		}
		// Website technical contact
		if (!empty($gmuj_mmi_options['website_contact_technical'])) {
			echo '<meta name="mason-website-technical-contact" content="'.$gmuj_mmi_options['website_contact_technical'].'">'.PHP_EOL;
		}
		// Website content contact
		if (!empty($gmuj_mmi_options['website_contact_content'])) {
			echo '<meta name="mason-website-content-contact" content="'.$gmuj_mmi_options['website_contact_content'].'">'.PHP_EOL;
		}

	// Finish output
		echo "<!-- End Mason Meta Information Plugin Output -->".PHP_EOL;

}
