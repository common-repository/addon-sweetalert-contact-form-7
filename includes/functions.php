<?php
if (! defined('ABSPATH') ) {
		exit; // Exit if accessed directly
}
function swal_cf7_scripts_method() {
	wp_enqueue_script('swal-cf7-script', plugin_dir_url( __FILE__ ) . '../lib/sweet-alert/js/sweetalert2.min.js', true);
	wp_enqueue_style('swal-cf7-styles', plugin_dir_url( __FILE__ ) . '../lib/sweet-alert/css/sweetalert2.min.css', false );

//ie support
	global $is_IE;
		if ( $is_IE ) {
 			// wp_enqueue_script( 'swal-cf7-promiseie', 'https://cdn.jsdelivr.net/npm/promise-polyfill@7.1.2/dist/promise.min.js', true);
			wp_enqueue_script('swal-cf7-promiseie', plugin_dir_url( __FILE__ ) . '../lib/sweet-alert/ie/promise.min.js', false);
			wp_enqueue_script( 'swal-cf7-promiseie' );

		}
}
add_action('wp_enqueue_scripts', 'swal_cf7_scripts_method');

//defer script
add_filter( 'script_loader_tag', 'swal_cf7_scripts_defer', 10, 3 );
function swal_cf7_scripts_defer( $tag, $handle, $src ) {
	if ( $handle !== 'swal-cf7-script' ) {
		return $tag;
	}
	return "<script src='$src' defer></script>";
}



?>
