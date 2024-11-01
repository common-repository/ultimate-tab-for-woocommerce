<?php
/*
 * Plugin Name:       Ultimate Tab for WooCommerce
 * Plugin URI:        http://wpgog.com
 * Description:       Ultimate Tab for WooCommerce is a plugins ultimate tab in WooCommerce
 * Version:           1.0
 * Author:            wpgog
 * Author URI:        http://wpgog.com
 * Text Domain:       ultimate-tab-for-woocommerce
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define('WPGOG_TAB_DIR_URL', plugin_dir_url(__FILE__));
define('WPGOG_TAB_DIR_PATH', plugin_dir_path(__FILE__));

// language
add_action( 'init', 'wpgog_tab_language_load' );
function wpgog_tab_language_load(){
		$plugin_dir = basename(dirname(__FILE__))."/languages/";
		load_plugin_textdomain( 'ultimate-tab-for-woocommerce', false, $plugin_dir );
}

// CSS & JS Assets add
add_action('admin_enqueue_scripts', 'wpgog_enqueue_admin_script');
function wpgog_enqueue_admin_script(){
    wp_enqueue_script( 'wpgog-scripts', WPGOG_TAB_DIR_URL .'assets/js/wpgog.js', array('jquery'), '', true );
    wp_register_style( 'wpgog-css', WPGOG_TAB_DIR_URL .'assets/css/wpgog.css', false, '' );
    wp_enqueue_style( 'wpgog-css' );
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once WPGOG_TAB_DIR_PATH.'lib/backend-field.php';
	require_once WPGOG_TAB_DIR_PATH.'lib/frontend-field.php';
}else{
	add_action('admin_notices', 'wpgog_no_vendor_notice' );
}

// Admin Notice
function wpgog_no_vendor_notice(){
		echo '<div class="notice notice-error is-dismissible">';
		    echo '<p>'.__('Please install & activate WooCommerce for WP WooCommerce Tab plugin.', 'ultimate-tab-for-woocommerce').'</p>';
		echo '</div>';
}
