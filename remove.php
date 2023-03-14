<?php
/**
 * Plugin Name: Unwanted
 * Plugin URI:  https://www.aryanraj.com/
 * Description: Remove Unwanted Features from WordPress.
 * Author:      Aryan Raj
 * Author URI:  https://www.aryanraj.com/
 * Version:     0.0.2
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Unwanted
 */

//* If this file is called directly, exit.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Disable Emojis
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter('emoji_svg_url', '__return_false');

// Disable Dashicons
add_action( 'wp_enqueue_scripts', 'dequeue_dashicon' );
function dequeue_dashicon() {
    if ( current_user_can( 'update_core' ) ) { // is_user_logged_in()
        return;
    }
    wp_deregister_style( 'dashicons' );
}

// Disable Embeds
//Remove the REST API endpoint.
remove_action('rest_api_init', 'wp_oembed_register_route');

// Turn off oEmbed auto discovery.
add_filter( 'embed_oembed_discover', '__return_false' );

// Don't filter oEmbed results.
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

//Remove oEmbed discovery links.
remove_action('wp_head', 'wp_oembed_add_discovery_links');

//Remove oEmbed JavaScript from the front-end and back-end.
remove_action('wp_head', 'wp_oembed_add_host_js');


// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');
add_filter('pings_open', '__return_false', 9999);
add_filter('pre_update_option_enable_xmlrpc', '__return_false');
add_filter('pre_option_enable_xmlrpc', '__return_zero');


// Disable XML-RPC RSD Link
remove_action ('wp_head', 'rsd_link');

// Remove wlwmanifest Link
remove_action( 'wp_head', 'wlwmanifest_link');

// Remove shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head');

// Remove WordPress version
remove_action('wp_head', 'wp_generator');

add_filter('the_generator', 'remove_wp_version');
function remove_wp_version() {
    return '';
}

// Query Strings from Static Sources
function remove_query_strings() {
    if(!is_admin()) {
        add_filter('script_loader_src', 'remove_query_strings_split', 15);
        add_filter('style_loader_src', 'remove_query_strings_split', 15);
    }
}

function remove_query_strings_split($src){
    $output = preg_split("/(&ver|\?ver)/", $src);
    return $output[0];
}
add_action('init', 'remove_query_strings');


//* Media
// Disable srcset on frontend
function disable_wp_responsive_images() {
    return 1;
}
add_filter('max_srcset_image_width', 'disable_wp_responsive_images');

// Disable 768px image generation
function disable_wp_responsive_image_sizes($sizes) {
    unset($sizes['medium_large']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'disable_wp_responsive_image_sizes');

// Disable image scaling in WP.5.3+
add_filter( 'big_image_size_threshold', '__return_false' );
