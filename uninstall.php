<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
// delete options
$options = array(
'swal_cf7_title_success',
'swal_cf7_duration_success',
'swal_cf7_title_error',
'swal_cf7_duration_error',
);
foreach ($options as $option) {
if (get_option($option)) delete_option($option);
}
?>
