<?php

namespace MYWPG\Controllers;

class AdminController
{

    public function __construct() {
        add_action('admin_menu', [$this, 'mywpg_gallery']);

        // ajax requests
        add_action("wp_ajax_mywpg_gallery_save_api", [$this, 'mywpg_gallery_save_api']);
        add_action("wp_ajax_mywpg_gallery_image_insert", [$this, 'mywpg_gallery_image_insert']);
        add_action("wp_ajax_mywpg_gallery_image_delete", [$this, 'mywpg_gallery_image_delete']);
        add_action("wp_ajax_mywpg_gallery_image_update", [$this, 'mywpg_gallery_image_update']);
        add_action("wp_ajax_mywpg_gallery_image_view", [$this, 'mywpg_gallery_image_view']);
        add_action("wp_ajax_mywpg_gallery_gallery_update", [$this, 'mywpg_gallery_gallery_update']);
        

        wp_enqueue_style('mywpg-gallery-admin-css', MYWPG_URL.'/assets/css/admin.css' );

        wp_register_script( "mywpg_gallery_script", MYWPG_URL.'/assets/js/admin-ajax.js', array('jquery') );
        wp_localize_script( 'mywpg_gallery_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('ajaxnonce')));        

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'mywpg_gallery_script' );


    }

    public function mywpg_gallery()
    {

        add_menu_page(
            'MYWPG Gallery',
            'WP Gallery',
            'manage_options',
            'mywpg-gallery',
            [$this, 'mywpg_gallery_content'],
            'dashicons-format-gallery',
            10
        );

        add_submenu_page( 
            'mywpg-gallery',
            'New Gallery',
            'New Gallery',
            'manage_options',
            'mywpg-new-gallery',
            [$this, 'mywpg_new_gallery_content'],
            2
        );

        add_submenu_page( 
            '',
            'Edit Gallery',
            'Edit Gallery',
            'manage_options',
            'mywpg-edit-gallery',
            [$this, 'mywpg_edit_gallery_content'],
            2
        );
        
    }

    public function mywpg_gallery_content()
    {
        global $wpdb;

        $GalleryData = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wpmg_gallery');

        require MYWPG_VIEWPATH.'/admin/gallery-list.php';
    }

    public function mywpg_new_gallery_content()
    {
        wp_enqueue_style('mywpg-gallery-admin-css', MYWPG_URL.'/assets/css/admin.css' );

        require MYWPG_VIEWPATH.'/admin/gallery-new.php';
    }

    public function mywpg_edit_gallery_content()
    {
        
        global $wpdb;


        if(!empty($_GET['action']) && $_GET['action']=='delete_category'){
            $this->mywpg_delete_gallery($_GET['gallery_id']);
            return false;
        }

        $GalleryData = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wpmg_gallery WHERE gallery_id = '.$_GET['gallery_id'])[0];
        

        if(!empty($GalleryData)){
            $GalleryImagesData = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wpmg_gallery_images WHERE gallery_id = '.$_GET['gallery_id']);
            require MYWPG_VIEWPATH.'/admin/gallery-edit.php';
        }
        else
            wp_die('invalid id');
    }

    private function mywpg_delete_gallery( $gallery_id)
    {
        global $wpdb;

        if(empty($gallery_id) ){
            return false;
        }else
            $gallery_id = (int) $gallery_id;

        $wpdb->delete( $wpdb->prefix.'wpmg_gallery', [ 'gallery_id' => $gallery_id ] );
        $wpdb->delete( $wpdb->prefix.'wpmg_gallery_images', [ 'gallery_id' => $gallery_id ] );

        echo "Gallery has been deleted!";

        echo "<script>window.location.href =  '".admin_url('/admin.php?page=mywpg-gallery')."';</script>";
        
    }

    public function mywpg_gallery_save_api()
    {


        if (
            ! isset( $_POST['nonce'] ) 
            || ! isset( $_POST['title'] )
            || ! wp_verify_nonce( $_POST['nonce'], 'ajaxnonce' )
        ) {
            echo "invalid request";
            return;
        } 
        global $wpdb;

        $wpdb->insert($wpdb->prefix.'wpmg_gallery', array(
            'title' => mywpg_sanitize($_POST['title']),
        ));

        $id = $wpdb->insert_id;

        echo json_encode([

            'status' => 'success',
            'gallery_id' =>  $id,
            'redirect_url' => admin_url('admin.php?page=mywpg-edit-gallery&gallery_id='.$id, false)

        ]);

        wp_die();

    }
    

    public function mywpg_gallery_image_insert()
    {

        if (
            ! isset( $_POST['nonce'] ) 
            || ! wp_verify_nonce( $_POST['nonce'], 'ajaxnonce' )
        ) {
            echo "invalid request";
            return;
        } 

        global $wpdb;

        $wpdb->insert($wpdb->prefix.'wpmg_gallery_images', array(
            'gallery_id' => mywpg_sanitize($_POST['gallery_id']),
            'url' => mywpg_sanitize($_POST['image']),
            'title' => mywpg_sanitize($_POST['title']),
            'description' => mywpg_sanitize($_POST['description']),
        ));

        $id = $wpdb->insert_id;

        echo json_encode([

            'status' => 'success',
            'image_id' =>  $id,
            'url' => $_POST['image']

        ]);

        wp_die();

    }

    public function mywpg_gallery_image_delete()
    {

        if (
            ! isset( $_POST['nonce'] ) 
            || ! wp_verify_nonce( $_POST['nonce'], 'ajaxnonce' )
        ) {
            echo "invalid request";
            return;
        } 

        if(empty($_POST['image_id'])){
            echo json_encode([
                'status' => 'error',
            ]);
            wp_die();
        }

        global $wpdb;

        $wpdb->delete( $wpdb->prefix.'wpmg_gallery_images', [ 'image_id' => mywpg_sanitize($_POST['image_id']), 'gallery_id' => mywpg_sanitize($_POST['gallery_id']) ] );

        echo json_encode([
            'status' => 'success',
        ]);
        wp_die();
        
    }

    public function mywpg_gallery_image_update()
    {

        if (
            ! isset( $_POST['nonce'] ) 
            || ! wp_verify_nonce( $_POST['nonce'], 'ajaxnonce' )
        ) {
            echo "invalid request";
            return;
        } 

        if(empty($_POST['image_id'])){
            echo json_encode([
                'status' => 'error',
            ]);
            wp_die();
        }

        global $wpdb;

        $wpdb->update($wpdb->prefix.'wpmg_gallery_images', array(
            'title' => mywpg_sanitize($_POST['title']),
            'description' => mywpg_sanitize($_POST['description']),
        ), array(
            'image_id'  =>  mywpg_sanitize($_POST['image_id']),
            'gallery_id'  =>  mywpg_sanitize($_POST['gallery_id']),
        ));

        
        echo json_encode([
            'status' => 'success',
        ]);
        wp_die();

    }
    

    public function mywpg_gallery_image_view()
    {

        if (
            ! isset( $_POST['nonce'] ) 
            || ! wp_verify_nonce( $_POST['nonce'], 'ajaxnonce' )
        ) {
            echo "invalid request";
            return;
        } 

        if(empty($_POST['image_id'])){
            echo json_encode([
                'status' => 'error',
            ]);
            wp_die();
        }

        global $wpdb;
        $GalleryImagesData = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wpmg_gallery_images WHERE gallery_id = '.mywpg_sanitize($_POST['gallery_id']).' AND image_id = '.mywpg_sanitize($_POST['image_id']))[0];
        

        
        echo json_encode([
            'status' => 'success',
            'data'  =>  $GalleryImagesData,
        ]);
        wp_die();

    }

    public function mywpg_gallery_gallery_update()
    {

        if (
            ! isset( $_POST['nonce'] ) 
            || ! wp_verify_nonce( $_POST['nonce'], 'ajaxnonce' )
        ) {
            echo "invalid request";
            return;
        } 
        
        if(empty($_POST['gallery_id'])){
            echo json_encode([
                'status' => 'error',
            ]);
            wp_die();
        }

        global $wpdb;

        $wpdb->update($wpdb->prefix.'wpmg_gallery', array(
            'title' => mywpg_sanitize($_POST['title']),
            'hide_title' => mywpg_sanitize($_POST['hide_title']),
            'hide_description' => mywpg_sanitize($_POST['hide_description']),
        ), array(
            'gallery_id'  =>  mywpg_sanitize($_POST['gallery_id']),
        ));

        
        echo json_encode([
            'status' => 'success',
        ]);
        wp_die();
        # code...
    }
    
    
}
