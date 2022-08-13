<?php

/**
 * Summary: php file which implements the plugin WP admin page interface
 */


/**
 * Generates the plugin settings page
 */
function gmuj_mmi_display_settings_page() {
    
    // Only continue if this user has the 'manage options' capability
    if (!current_user_can('manage_options')) return;

    // Begin HTML output
    echo "<div class='wrap'>";

    // Page title
    echo "<h1>" . esc_html(get_admin_page_title()) . "</h1>";

    // Output basic plugin info
    echo "<p>This plugin allows you to provide Mason-specific organizational information which will be output as HTML meta tags on all public-facing pages of this website.</p>";
    echo "<p>This provides a consistent (and machine-readable) method for easily identifying Mason websites and their appropriate contact people, including in an automated way for search engine indexing, etc.</p>";

    // Begin form
    echo "<form action='options.php' method='post'>";

    // output settings fields - outputs required security fields - parameter specifes name of settings group
    settings_fields('gmuj_mmi_options');

    // output setting sections - parameter specifies name of menu slug
    do_settings_sections('gmuj_mmi');

    // submit button
    submit_button();

    // Close form
    echo "</form>";

    // Finish HTML output
    echo "</div>";
    
}

/**
 * Generates content for identity settings section
 */
function gmuj_mmi_callback_section_settings_identity() {

    echo '<p>Set the website identity meta tags.</p>';

}

/**
 * Generates content for contacts settings section
 */
function gmuj_mmi_callback_section_settings_contacts() {

    echo '<p>Set the website contacts meta tags.</p>';
    echo '<p><strong>Note: while these email addresses will not appear visibly on the website, they can be found in the HTML source code of public-facing pages of this website.</strong></p>';

}

/**
 * Generates text field for plugin settings option
 */
function gmuj_mmi_callback_field_text($args) {
    
    //Get array of options. If the specified option does not exist, get default options from a function
    $options = get_option('gmuj_mmi_options', gmuj_mmi_options_default());
    
    //Extract field id and label from arguments array
    $id    = isset($args['id'])    ? $args['id']    : '';
    $label = isset($args['label']) ? $args['label'] : '';
    
    //Get setting value
    $value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
    
    //Output field markup
    echo '<input id="gmuj_mmi_options_'. $id .'" name="gmuj_mmi_options['. $id .']" type="text" size="40" value="'. $value .'">';
    echo "<br />";
    echo '<label for="gmuj_mmi_options_'. $id .'">'. $label .'</label>';
    
}

/**
 * Sets default plugin options
 */
function gmuj_mmi_options_default() {

    return array(
        'website_mason_unit'   => '',
        'website_mason_department'   => '',
        'website_contact_technical'   => '',
        'website_contact_content'   => ''
    );

}

/**
 * Validate plugin options
 */
function gmuj_mmi_callback_validate_options($input) {
    
    // Mason unit
    if (isset($input['website_mason_unit'])) {
        $input['website_mason_unit'] = sanitize_text_field($input['website_mason_unit']);
    }
    // Mason department
    if (isset($input['website_mason_department'])) {
        $input['website_mason_department'] = sanitize_text_field($input['website_mason_department']);
    }

    // Technical contact field
    if (isset($input['website_contact_technical'])) {
        $input['website_contact_technical'] = sanitize_text_field($input['website_contact_technical']);
    }

    // Content contact field
    if (isset($input['website_contact_content'])) {
        $input['website_contact_content'] = sanitize_text_field($input['website_contact_content']);
    }

    return $input;
    
}
