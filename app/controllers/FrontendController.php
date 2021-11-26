<?php

namespace MYWPG\Controllers;

class FrontendController 
{

    private $gallery;

    // [mywpg_gallery id=1]	
    public function __construct() {
        add_shortcode( 'mywpg_gallery', [$this, 'shortcode_render'] );

        wp_enqueue_style('mywpg-gallery-front-lightBox', MYWPG_URL.'/assets/plugins/lightgallery/css/lightgallery-bundle.css');

        wp_enqueue_style('mywpg-gallery-front-css', MYWPG_URL.'/assets/css/front.css');

        wp_enqueue_script( "mywpg_gallery_script_front_lightBox", MYWPG_URL.'/assets/plugins/lightgallery/lightgallery.min.js', array('jquery') );

        wp_enqueue_script( "mywpg_gallery_script_front_lightBox_thumbnail", MYWPG_URL.'/assets/plugins/lightgallery/plugins/thumbnail/lg-thumbnail.umd.js' );

        wp_enqueue_script( "mywpg_gallery_script_front_lightBox_zoom", MYWPG_URL.'/assets/plugins/lightgallery/plugins/zoom/lg-zoom.umd.js' );


        if(!empty($_GET['mywp_gallery'])){

            $this->gallery = (int) $_GET['mywp_gallery'];
            add_filter('the_title', [ $this, 'theTitle' ] );
            add_filter('the_content', [ $this, 'theContent' ], 9001 );
            add_filter('template_include', [ $this, 'templateInclude' ] );
            add_filter('pre_get_posts', [ $this, 'preGetPosts' ] );
        }

    }

    public function shortcode_render( $atts )
    {
        global $wpdb;

        $GalleryData = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wpmg_gallery WHERE gallery_id = '.$atts['gallery_id']);

        if(!empty($GalleryData)){
            $GalleryData = $GalleryData[0];
        }else{
            return;
        }
        
        $GalleryImagesData = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wpmg_gallery_images WHERE gallery_id = '.$atts['gallery_id']);

        require MYWPG_VIEWPATH.'/frontend/gallery-view.php';
    }

    /**
     * @return string
     */
    public function theTitle($title)
    {
        if (!in_the_loop()) return $title;

        global $wpdb;

        $GalleryData = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'wpmg_gallery WHERE gallery_id = '.$this->gallery)[0];

        return $GalleryData->title . " - Gallery Preview";
    }

    /**
     * @return string
     */
    public function theContent()
    {
        if (!is_user_logged_in()) return 'Log In first in order to preview the Gallery.';

        return do_shortcode("[mywpg_gallery gallery_id='{$this->gallery}']");
    }


    public static function templateInclude()
    {
        return locate_template(array('page.php', 'single.php', 'index.php'));
    }


    public static function preGetPosts($query)
    {
        $query->set('posts_per_page', 1);
    }

}
