<?php
/**
 *
 * @package   Twitter_Card_Generator
 * @author    Riley MacDonald <riley_macdonald@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://www.theredspace.com/
 * @copyright 2013 theRedSpace
 *
 * @wordpress-plugin
 * Plugin Name: Twitter Card Generator
 * Plugin URI:  https://github.com/silencecm/wp-twitter-card-generator
 * Description: Generate Twitter Cards for tweets linking posts
 * Version:     1.0.1
 * Author:      theRedSpace
 * Author URI:  http://www.theredspace.com/
 * Text Domain: plugin-name-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-twitter-card-generator.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'Twitter_Card_Generator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Twitter_Card_Generator', 'deactivate' ) );

Twitter_Card_Generator::get_instance();