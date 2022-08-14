<?php

/**
 * Main plugin file for the Mason WordPress: Mason Meta Information plugin
 */

/**
 * Plugin Name:       Mason WordPress: Mason Meta Information
 * Author:            Jan Macario
 * Plugin URI:        https://github.com/jmacario-gmu/gmuj-wordpress-plugin-mason-meta-information
 * Description:       Mason WordPress plugin which implements the addition of Mason-related website meta information into the website's HTML meta tags.
 * Version:           1.1
 */


// Exit if this file is not called directly.
	if (!defined('WPINC')) {
		die;
	}

// Set up auto-updates
	require 'plugin-update-checker/plugin-update-checker.php';
	$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/jmacario-gmu/gmuj-wordpress-plugin-mason-meta-information/',
	__FILE__,
	'gmuj-wordpress-plugin-mason-meta-information'
	);

// Include files
	// Branding
		include('php/fnsBranding.php');
	// Admin menu
		include('php/admin-menu.php');
	// Admin page
		include('php/admin-page.php');
	// Plugin settings
		include('php/settings.php');
	// Output
		include('php/output.php');
