<?php


namespace MYWPG;


use \MYWPG\Controllers\AdminController;
use \MYWPG\Controllers\FrontendController;

class MYWPG_Gallery
{

    protected static $_instance = null;


    public function __construct() {
        add_action('init', [$this, 'init'] );
        register_activation_hook( MYWPG_BASE_FILE, [$this, 'mywpg_activate_plugin'] );
        register_uninstall_hook( MYWPG_BASE_FILE, ['MYWPG\MYWPG_Gallery', 'mywpg_uninstall_plugin'] );
    }

    public function init()
    {
        // setup database
        
        if(is_admin()){
            new AdminController();
        }else{
            new FrontendController();
        }

    }

    public static function mywpg_activate_plugin()
    {

        // activating plugin
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $get_charset_collate = $wpdb->get_charset_collate();

        $sql = 'CREATE TABLE `'.$wpdb->prefix.'wpmg_gallery` (
            `gallery_id` int(11) NOT NULL AUTO_INCREMENT,
            `title` text DEFAULT NULL,
            `hide_title` int(11) NOT NULL,
            `hide_description` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`gallery_id`)
           ) '.$get_charset_collate.';
           
           CREATE TABLE `'.$wpdb->prefix.'wpmg_gallery_images` (
            `image_id` int(11) NOT NULL AUTO_INCREMENT,
            `gallery_id` text DEFAULT NULL,
            `title` text DEFAULT NULL,
            `description` text DEFAULT NULL,
            `url` text DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`image_id`)
           ) '.$get_charset_collate;

        dbDelta( $sql );
        
    }

    public static function mywpg_uninstall_plugin()
    {
        
        global $wpdb;
        $wpdb->query("DROP TABLE `".$wpdb->prefix."wpmg_gallery`");
        $wpdb->query("DROP TABLE `".$wpdb->prefix."wpmg_gallery_images`");
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    
}
