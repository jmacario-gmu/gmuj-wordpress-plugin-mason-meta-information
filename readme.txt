=== Mason WordPress: Mason Meta Information ===
Contributors: Jan Macario
Requires at least: 4.7
Tested up to: 5.6
Requires PHP: 7.0
Stable tag: 1.0

Mason WordPress plugin which implements the addition of Mason-related website meta information as website HTML meta tags.

== Description ==

This plugin creates a new WordPress top-level admin menu item, called Mason Meta Information. This links to a plugin settings page, which allow the user to set four settings:

* Mason unit
* Mason department
* Website technical contact
* Website content contact

The first two settings help to identify the 'owner' of the website. The second two settings identify the appropriate website contacts. It is useful to have this information available in a consistent, machine-readable format.

These settings are read by a function which fires with the wp_head action hook, which then outputs these values in meta tags in the HTML header.