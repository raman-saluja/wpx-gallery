<?php

// jQuery
wp_enqueue_script('jquery');
// This will enqueue the Media Uploader script
wp_enqueue_media();
?>

<div class="mywpg-page-header">
    <h1><?php _e("WP GALLERY", MYWPG_TEXT_DOMAIN) ?></h1>
</div>
<div class="mywpg-page-wrapper">
    
    <h3> <?php _e("New Gallery", MYWPG_TEXT_DOMAIN) ?></h3>

    <form action="<?php menu_page_url('mywpg-new-gallery') ?>" method="post" onSubmit="mywpg_gallery_submit(event, this)">
        <label for="" class="label"> <?php _e("Title", MYWPG_TEXT_DOMAIN) ?> </label> &nbsp;  <input type="text" name="title" value="" placeholder="" class="regular-text" /><br>


        <br>
        <a href="<?php menu_page_url('mywpg-gallery') ?>" class="button-secondary"> <?php _e("Cancel", MYWPG_TEXT_DOMAIN) ?></a> &nbsp; &nbsp;<button type="submit" class="button-primary"> <?php _e("Next", MYWPG_TEXT_DOMAIN) ?></button>
    </form>

</div>
