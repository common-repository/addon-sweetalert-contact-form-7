<?php
/**
 * Plugin Name: Add-on SweetAlert Contact Form 7
 * Plugin URI:  https://wordpress.org/plugins/addon-sweetalert-contact-form-7/
 * Description: Add SweetAlert2 script in Contact Form 7 submission process.
 * Version:     1.1.1
 * Author:      Camilo
 * Author URI:  https://camilowp.com/
 * Text Domain: addon-sweetalert-contact-form-7
 * Domain Path: /languages
 * License:     GPL3
 */
 defined( 'ABSPATH' ) or exit;
 // Contact form 7 is active
 add_action('admin_init', 'swal_cf7_validation_has_parent_plugin');

function swal_cf7_validation_has_parent_plugin() {
         if (is_admin() && current_user_can("activate_plugins") && !is_plugin_active("contact-form-7/wp-contact-form-7.php")) {
             add_action('admin_notices', 'swal_cf7_validation_nocf7_notice');
             deactivate_plugins(plugin_basename(__FILE__));
             $flag = (int) $_GET['activate'];
             if (isset($flag)) {
                 unset($_GET['activate']);
             }
         }
     }

function swal_cf7_validation_nocf7_notice() {
  if ( is_admin() ) {
         $plugin_URL =  esc_url( admin_url('plugin-install.php?tab=search&s=contact+form+7') );
         ?>
         <div class="error">
             <p>
                 <?php
                 printf( __('%s must be installed and activated for the Add-on SweetAlert Contact Form 7 Check plugin to work', 'addon-sweetalert-contact-form-7'), '<a href="' . $plugin_URL . '">Contact Form 7</a>'
                 );
                 ?>
             </p>
         </div>
         <?php
     }
   }
//settings
function swal_cf7_links( $links ) {
     $plugin_links = array(
         '<a href="' . esc_url(admin_url( 'admin.php?page=sweetalert-cf7' )) . '">' . esc_html__( 'Settings', 'addon-sweetalert-contact-form-7' ) . '</a>'
     );
     return array_merge( $plugin_links, $links );
   }
 add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'swal_cf7_links' );


//improve wpo
function swal_cf7_improve_wpo() {
    $load_scripts = false;
    if( is_singular() ) {
     $post = get_post();
 		/** add jevelin and Businext theme support **/
     if( has_shortcode($post->post_content, 'vcj_contact_form_7') or has_shortcode($post->post_content, 'contact-form-7') or has_shortcode($post->post_content, 'tm_contact_form_7')) {
         $load_scripts = true;

         //load css
         add_action( 'wp_head', 'swal_cf7_load_style' );
         function swal_cf7_load_style() {
            echo '<style>
         div.wpcf7 div.wpcf7-response-output {
         	display:none;
         	border:none;
         	opacity:0;
         	font-size:0;
         }
         .swal2-popup {
             font-size: 15px;
         }
           </style>';
         }

         // load script
         function swal_cf7_scripts() {
         $title_success = get_option('swal_cf7_title_success');
         $duration_success = get_option('swal_cf7_duration_success');
         $title_error = get_option('swal_cf7_title_error');
         $duration_error = get_option('swal_cf7_duration_error');
         ?>
         <script>
         jQuery(function($) {
         	$(".wpcf7-submit").click(function(event) {
         		var messageOutput = $(this).closest("form").children(".wpcf7-response-output");
         		$(document).ajaxComplete(function() {
         			var message = $(messageOutput).html();
         			var validMessage = function(){
         				Swal.fire({
         					icon: "success",
         					title: "<?php echo esc_attr(strtoupper($title_success)); ?>",
         					text: message,
         					timer: <?php if(empty($duration_success)) { echo '3000'; } else { echo esc_attr($duration_success); } ?>,
         					showConfirmButton: false
         				});
         			};
         			var errorMessage = function(){
         				Swal.fire({
         					icon: "warning",
         					title: "<?php echo esc_attr(strtoupper($title_error)); ?>",
         					text: message,
         					timer: <?php if(empty($duration_error)) { echo '3000'; } else { echo esc_attr($duration_error); } ?>,
         					showConfirmButton: false
         				});
         			};
              setSwal = $("form.wpcf7-form").hasClass("invalid") ? "alert" : "success";
         			if ( setSwal === "alert" ) { errorMessage() };
         			if ( setSwal === "success" ) { validMessage() };
         		});
         	});
         });
         </script>
         <?php
         }
         add_action( 'wp_footer', 'swal_cf7_scripts' );
     }
    }

    if( ! $load_scripts ) {
		wp_dequeue_style( 'swal-cf7-styles' );
		wp_dequeue_script( 'swal-cf7-script' );
    wp_dequeue_script( 'swal-cf7-promiseie' );
    }
}
add_action( 'wp_enqueue_scripts', 'swal_cf7_improve_wpo', 99 );



//load admin styles only in plugins settings
add_action( 'admin_enqueue_scripts', 'load_swal_cf7_wp_admin_style' );
function load_swal_cf7_wp_admin_style($hook) {
		global $swal_cf7_menu;
		if( $hook != $swal_cf7_menu )
		return;
   echo '<style>
.swal-cf7__container {
	position:relative;
}
.swal-cf7__container form {
	width:70%;
	max-width:450px;
	float:left;
}
.swal-cf7__container sidebar {
	width:20%;
	float:right;
	margin-right:5%;
	text-align:right;
}
.swal-cf7__container header {
	position:absolute;
	top:20px;
	right:5%;
	text-align:right;
}
  </style>';
}

// Call swal_cf7_duration_menu function to load plugin menu in dashboard
add_action( 'admin_menu', 'swal_cf7_duration_menu' );

// Create WordPress admin menu
if( !function_exists("swal_cf7_duration_menu") ){

function swal_cf7_duration_menu(){

  $subcf7  	  = 'wpcf7';
  $page_title = 'SweetAlert2 for CF7';
  $menu_title = 'SweetAlert2 for CF7';
  $capability = 'manage_options';
  $menu_slug  = 'sweetalert-cf7';
  $function   = 'swal_cf7_settings_page';

 global $swal_cf7_menu;
	$swal_cf7_menu =  add_submenu_page(
				$subcf7,
				$page_title,
        $menu_title,
        $capability,
        $menu_slug,
        $function );

  // Call update_swal_cf7_duration function to update database
  add_action( 'admin_init', 'update_swal_cf7_duration' );
}
}

// Create function to register plugin settings in the database
if( !function_exists("update_swal_cf7_duration") )
{
function update_swal_cf7_duration() {
  register_setting( 'swal-cf7-info-settings', 'swal_cf7_duration_success' );
  register_setting( 'swal-cf7-info-settings', 'swal_cf7_duration_error' );
  register_setting( 'swal-cf7-info-settings', 'swal_cf7_title_success' );
  register_setting( 'swal-cf7-info-settings', 'swal_cf7_title_error' );
}
}
//transalte
function swal_cf7_load_plugin_textdomain() {
      load_plugin_textdomain('addon-sweetalert-contact-form-7', false, basename(dirname(__FILE__)) . '/languages');
}
add_action( 'plugins_loaded', 'swal_cf7_load_plugin_textdomain' );

// Create WordPress plugin page
if( !function_exists("swal_cf7_settings_page") )
{
function swal_cf7_settings_page(){
?>
<div class="swal-cf7__container">
  <h2>SweetAlert2 for CF7 | <?php _e( 'Settings', 'addon-sweetalert-contact-form-7' ); ?></h2>
  <form method="post" action="options.php">
    <?php settings_fields( 'swal-cf7-info-settings' ); ?>
    <?php do_settings_sections( 'swal-cf7-info-settings' ); ?>
	  <h4><?php _e( 'Success Alert', 'addon-sweetalert-contact-form-7' ); ?></h4>
      <p><?php _e( 'Timer (default: 3000ms)', 'addon-sweetalert-contact-form-7' ); ?>: <input type="number" max="50000" name="swal_cf7_duration_success" value="<?php echo sanitize_text_field(get_option('swal_cf7_duration_success')); ?>"/></p>
	  <p><?php _e( 'Title (default: none)', 'addon-sweetalert-contact-form-7' ); ?>: <input type="text" maxlength="27" name="swal_cf7_title_success" value="<?php echo sanitize_title(sanitize_text_field(get_option('swal_cf7_title_success'))); ?>"/></p>
	  <hr />
	  <h4><?php _e( 'Error Alert', 'addon-sweetalert-contact-form-7' ); ?></h4>
      <p><?php _e( 'Timer (default: 3000ms)', 'addon-sweetalert-contact-form-7' ); ?>: <input type="number" max="50000" name="swal_cf7_duration_error" value="<?php echo sanitize_text_field(get_option('swal_cf7_duration_error')); ?>"/></p>
	  <p><?php _e( 'Title (default: none)', 'addon-sweetalert-contact-form-7' ); ?>: <input type="text" maxlength="27" name="swal_cf7_title_error" value="<?php echo sanitize_title(sanitize_text_field(get_option('swal_cf7_title_error'))); ?>"/></p>
  <?php submit_button(); ?>
  </form>
  <sidebar>
	<p>This plugin adds the <a href="https://sweetalert2.github.io" target="_blank" rel="noopener noreferrer">SweetAlert2</a> script into Contact Form 7 wordpress plugin submission process.</p>
	<p>This plugin requires the <a href="https://wordpress.org/plugins/contact-form-7/" target="_blank" rel="noopener noreferrer">Contact Form 7</a> plugin to work.</p>
	<p><?php _e( 'Just activate it to replace CF7 default submission output by a SweetAlert2 pop up. The add-on will display the Contact Form 7 messages in the pop up.', 'addon-sweetalert-contact-form-7' ); ?></p>
	<p><?php _e( 'You also can customize duration and title of success/error alert.', 'cf7-sweetalert' ); ?></p>
	<a class="button button-primary" href="https://wordpress.org/support/plugin/addon-sweetalert-contact-form-7/reviews/" target="_blank" rel="noopener noreferrer"><?php _e( 'Rate this plugin', 'addon-sweetalert-contact-form-7' ); ?></a>
  </sidebar>
</div>
<?php
}
}

require 'includes/functions.php'; /* customs scripts */

?>
