<?php
/**
 * Plugin Name: Unwanted
 * Plugin URI:  https://github.com/rockingaryan/unwanted
 * Description: Remove Unwanted Features from WordPress.
 * Author:      Aryan Raj
 * Author URI:  https://www.aryanraj.com/
 * Version:     1.0.0
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Unwanted
 */
 
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Disable XML-RPC RSD link
remove_action ('wp_head', 'rsd_link');

// Remove wlwmanifest link
remove_action( 'wp_head', 'wlwmanifest_link');

// Remove WordPress version number
remove_action('wp_head', 'wp_generator');

add_filter('the_generator', 'gk_remove_wp_version');
function gk_remove_wp_version() {
	return '';
}

// Remove shortlink
//remove_action( 'wp_head', 'wp_shortlink_wp_head');

// Disable Embeds

//Remove the REST API endpoint.
remove_action('rest_api_init', 'wp_oembed_register_route');
 
// Turn off oEmbed auto discovery.
add_filter( 'embed_oembed_discover', '__return_false' );
 
//Don't filter oEmbed results.
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
 
//Remove oEmbed discovery links.
remove_action('wp_head', 'wp_oembed_add_discovery_links');
 
//Remove oEmbed JavaScript from the front-end and back-end.
remove_action('wp_head', 'wp_oembed_add_host_js');



// Disable the emoji's
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter('emoji_svg_url', '__return_false');

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