<?php 
/*

* Plugin Name: Stock Overview 
* Description: This is Custom Plugin for Stock Overview By Stock API
* Version: 1.0.0
* Author: GMS
* Author URI: http://localhost/wp_test/

*/

define('STX_PLUGINS_DIR_PATH',plugin_dir_path(__FILE__));
define("STX_PLUGIN_URL",plugins_url());
$full_url = STX_PLUGIN_URL."/stock_overview/";
define("STX_FULL_PLUGIN_URL",$full_url);
define("STX_ADMIN_URL",get_admin_url());


// for security 
if(!defined('ABSPATH')){
    header("Location:/wp_test");
    die();
}

function stock_plugin_activate(){

  global $wpdb,$table_prefix;
   $wp_stock_overview = $table_prefix.'stock_overview';
  
  $qry1 = "CREATE TABLE IF NOT EXISTS $wp_stock_overview(`id` INT(11) NOT NULL AUTO_INCREMENT , `symbol` VARCHAR(255) NOT NULL , `content` VARCHAR(255) NOT NULL , `name` TEXT NOT NULL , `test_area` TEXT NOT NULL , `country` VARCHAR(255) NOT NULL , `ipo_year` INT(11) NOT NULL , `sector` VARCHAR(255) NOT NULL , `industry` VARCHAR(255) NOT NULL , `status` INT(11) NOT NULL , `add_on` TIMESTAMP NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
   ";
 $wpdb->query($qry1);

}
register_activation_hook(__FILE__, 'stock_plugin_activate');


function stock_plugin_deactivation(){
    global $wpdb,$table_prefix;
    $wp_stock_overview = $table_prefix.'stock_overview';

    $qry1 = "TRUNCATE $wp_stock_overview";
    $wpdb->query($qry1);
}
register_deactivation_hook(__FILE__, 'stock_plugin_deactivation');


function stock_menu()
{

 add_menu_page( 'Stock Overview', 'Stock Overview', 'manage_options', 'dashboard',  'stock_dashboard_page_load',STX_PLUGIN_URL.'/stock_overview/media/diagram.png');
 add_submenu_page('dashboard', 'Settings', 'Add Stocks', 'manage_options', 'add_stocks', 'add_stocks_page_load');

 add_submenu_page('dashboard', 'Settings', 'Manage Stocks', 'manage_options', 'manage_stocks', 'manage_stocks_page_load');

 add_submenu_page('dashboard', 'Settings', 'Settings', 'manage_options', 'settings', 'stock_api_page_load');

}
add_action('admin_menu','stock_menu');


function stock_dashboard_page_load()
{
	include('admin/dashboard.php');
}

function add_stocks_page_load()
{
    include('admin/add_stocks.php');
}

function manage_stocks_page_load()
{
	include('admin/manage_stocks.php');
}

function stock_api_page_load()
{
	include('admin/settings.php');
}


/***
 ----------------------------------------------------------------
     REGISTER FRONTEND TEMPLATES
 ---------------------------------------------------------------- 
***/

  function my_template_array()
  {
    $temp = [];
    $temps['stock-display.php'] = 'Stock Overview';
    return $temps;
  }

  function my_template_register($page_templates,$theme,$post)
  {
    $templates  = my_template_array();
    foreach($templates as $tk => $tv)
    {
      $page_templates[$tk] = $tv;
    }
     return $page_templates;
  }
  add_filter('theme_page_templates','my_template_register',10,3);


  function my_template_select($template)
  {
    global $post, $wp_query, $wpdb;
    $page_temp_slug = get_page_template_slug($post->ID);

    $templates = my_template_array();
    
    if(isset($templates[$page_temp_slug]))
    {
        $template = plugin_dir_path(__FILE__).'admin/template/'.$page_temp_slug;
    }

    //echo '<pre>Preformatted';print_r($page_temp_slug);echo '</pre>';
    return $template;
  }
  add_filter('template_include','my_template_select',99);


//echo plugin_dir_path(__FILE__);


function stock_plugin_demo($atts) {
	$Content = "<style>\r\n";
	$Content .= "h3.demoClass {\r\n";
	$Content .= "color: #26b158;\r\n";
	$Content .= "}\r\n";
	$Content .= "</style>\r\n";
	//$Content .= include('admin/list_local_server_movies.php');

    return $Content;
}

add_shortcode('stock-plugin-demo', 'stock_plugin_demo');





 ?>