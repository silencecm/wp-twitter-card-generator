<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Seo Generator
 * @author    Riley MacDonald <riley_macdonald@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://rileymacdonald.ca
 * @copyright 2013 Riley MacDonald
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Define uninstall functionality here