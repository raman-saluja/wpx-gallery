<?php 
/*
 * Plugin Name: WPX WordPress Gallery
 * Plugin URI:  https://raman.work
 * Description: Simple WordPress Gallery plugin created for learning purposes & exploring WordPress
 * Version:     1.1.7
 * Author:      Ramantech
 * Author URI:  https://raman.work/
 * License:     GPL-2.0+
 * Text Domain: wpxgallery
 * Domain Path: /languages
 */


// vendor autoload
 require "vendor/autoload.php";

 require "app/Helpers.php";

// !defined(ABSPATH)
if(!defined("ABSPATH")){
    exit();
}

define('MYWPG_BASE_FILE', __FILE__);
define('MYWPG_URL', plugin_dir_url(__FILE__));
define('MYWPG_ABSPATH',  WP_PLUGIN_DIR.'/my-wp-gallery');
define('MYWPG_VIEWPATH',  MYWPG_ABSPATH.'/app/views');
define('MYWPG_TEXT_DOMAIN',  'wpxgallery');


// instance class MYWPG_Gallery
function MYWPG_Gallery()
{
    return \MYWPG\MYWPG_Gallery::instance();
}

$_GLOBALS['MYWPG_Gallery'] = MYWPG_Gallery();


