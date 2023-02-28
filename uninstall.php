<?php 

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb,$table_prefix;
$wp_stock_overview = $table_prefix.'stock_overview';

$qry1 = "DROP TABLE $wp_stock_overview";
$wpdb->query($qry1);

 ?>