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
    
    <h3><?php echo $GalleryData->title ?> <?php _e("Gallery", MYWPG_TEXT_DOMAIN) ?></h3>

    <div class="mywpg-btn-wrapper">
        <button type="button" onclick="window.open('<?php echo home_url('?mywp_gallery='.$GalleryData->gallery_id) ?>', '_blank')" class="mywpg-btn-outline"> <?php _e("Preview", MYWPG_TEXT_DOMAIN) ?> <span class="dashicons dashicons-external"></span></button>
        <button type="button" class="mywpg-btn" onclick="window.location.href= '<?php echo admin_url('/admin.php?page=mywpg-gallery') ?>';"><?php _e("Publish", MYWPG_TEXT_DOMAIN) ?></button>
    </div>
    <br>
    

    <input type="hidden" name="gallery_id" value="<?php echo $GalleryData->gallery_id ?>" />

    <hr>

    <div class="mywp-wrap-row">

        <div class="mywpg-edit-left">
            <div class="mywpg-gallery-images-wrapper">

                <div class="mywpg-gallery-image mywpg-gallery-image-btn" style="cursor: pointer;">
                    <div class="mywpg-gallery-new-btn">
                        <span class="dashicons dashicons-plus-alt"></span>
                        <p><?php _e("Add Image", MYWPG_TEXT_DOMAIN) ?></p>
                    </div>
                </div>

                <?php foreach($GalleryImagesData as $image): ?>
                    <div class="mywpg-gallery-image" id="mywpg_gallery_<?php echo $image->image_id ?>" style="background-image: url('<?php echo $image->url ?>');"> 

                        <div class="mywpg-gallery-image-btns">
                            <button type="button" class="mywpg-btn-img-edit" onclick="WPG_openTab('mywpg-image-settings', <?php echo $image->image_id ?>)"><span class="dashicons dashicons-edit"></span></button> 
                            &nbsp; 
                            <button type="button" class="mywpg-btn-img-delete" onclick="deleteImageGallery(this, <?php echo $image->image_id ?>)"><span class="dashicons dashicons-trash"></span></button>
                        </div>

                    </div>
                <?php endforeach ?>

            </div>
        </div>
        <div class="mywpg-edit-right">

        <div id="mywpg-message-right"></div>


        <!-- Gallery Settings -->

        
        <div class="mywpg-settings-wrapper"  id="mywpg-gallery-settings">
                <div class="mywpg-settings-header">
                    <h3>Gallery Settings</h3>
                </div>
                <div class="mywpg-settings-body">

                    <form id="mywpg-form-edit-gallery" onsubmit="MYWPG_updateGallery(event, this)">

                        <div class="mywpg-form-item">
                            <label for="" class="label"><?php _e("Title", MYWPG_TEXT_DOMAIN) ?> </label>
                            <input type="text" name="title" value="<?php echo $GalleryData->title ?>" placeholder="" class="regular-text" />
                        </div>

                        <div class="mywpg-form-item">
                            <label for="" class="label"><?php _e("Hide Image Title", MYWPG_TEXT_DOMAIN) ?> </label>

                            <fieldset>
                                <span title='g:i a'>
                                    <input type="radio" name="hide_title" value="1" <?php echo $GalleryData->hide_title==1?'checked':'' ?> />
                                    <span><?php esc_attr_e( 'Yes', MYWPG_TEXT_DOMAIN ); ?></span>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <span title='g:i a'>
                                    <input type="radio" name="hide_title" value="0" <?php echo $GalleryData->hide_title==0?'checked':'' ?> />
                                    <span><?php esc_attr_e( 'No', MYWPG_TEXT_DOMAIN ); ?></span>
                                </span>
                            </fieldset>
                        </div>
                        

                        <div class="mywpg-form-item">
                            <label for="" class="label"><?php _e("Hide Image Description", MYWPG_TEXT_DOMAIN) ?> </label>

                            <fieldset>
                                <span title='g:i a'>
                                    <input type="radio" name="hide_description" value="1" <?php echo $GalleryData->hide_description==1?'checked':'' ?> />
                                    <span><?php esc_attr_e( 'Yes', MYWPG_TEXT_DOMAIN ); ?></span>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <span title='g:i a'>
                                    <input type="radio" name="hide_description" value="0" <?php echo $GalleryData->hide_description==0?'checked':'' ?> />
                                    <span><?php esc_attr_e( 'No', MYWPG_TEXT_DOMAIN ); ?></span>
                                </span>
                            </fieldset>
                        </div>
                        
                        <div class="mywpg-form-item">
                            <button type="submit" class="button-primary" onclick="WPG_openTab('mywpg-gallery-settings')">
                                Update
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        <!-- Image Settings -->
        
        <div class="mywpg-settings-wrapper" id="mywpg-image-settings" style="display: none;">
                <div class="mywpg-settings-header">
                    <h3> Image Settings</h3>
                </div>
                <div class="mywpg-settings-body">

                    <form action="#!" onsubmit="MYWPG_updateImageGallery(event, this)" data-mywpg-image_id>

                        <div class="mywpg-form-item">
                            <label for="" class="label"><?php _e("Image", MYWPG_TEXT_DOMAIN) ?> </label>
                            <img src="http://localhost/others/wordpress/wp-content/uploads/2020/08/bedroom-5-1.jpg" data-mywpg_imgsrc width="150" alt="">
                        </div>

                        <div class="mywpg-form-item">
                            <label for="" class="label"><?php _e("Title", MYWPG_TEXT_DOMAIN) ?> </label>
                            <input type="text" name="title" data-mywpg_title value="<?php echo $GalleryData->title ?>" placeholder="" class="regular-text" />
                        </div>
                        
                        <div class="mywpg-form-item">
                            <label for="" class="label"><?php _e("Description", MYWPG_TEXT_DOMAIN) ?> </label>
                            <textarea type="text" name="description"  data-mywpg_description value="<?php echo $GalleryData->title ?>" placeholder="" rows="5" cols="50" ></textarea>
                        </div>

                        <div class="mywpg-form-item">
                            <button type="submit" class="button-primary">
                                Update
                            </button>
                            <button type="button" class="button-secondary" onclick="WPG_openTab('mywpg-gallery-settings')">
                                Cancel
                            </button>
                            &nbsp; <a href="#!" onclick="deleteImageGallery(this, 1)" style="color: red">delete</a>
                        </div>
                        
                        
                    </form>

                </div>

            </div>

        </div>    
    </div> <!-- .mywp-wrap-row -->

</div>

<script type="text/javascript">
    
    window.WPG_openTab = (tab_id, image_id) => {
        
        if(tab_id=='mywpg-image-settings'){
            getImageDetailsAjax(image_id);
            jQuery('#'+tab_id).find('[data-mywpg-image_id]').attr('data-mywpg-image_id', image_id);
        }

        jQuery('.mywpg-settings-wrapper').hide();
        jQuery('#'+tab_id).show();
        
    };

    window.getImageDetailsAjax = (image_id) => {
        // send ajax request
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            data: { action: "mywpg_gallery_image_view", gallery_id: '<?php echo $GalleryData->gallery_id ?>', image_id: image_id, nonce: myAjax.nonce },
            success: function (response) {
                if (response.status == "success") {
                    for(let key of Object.keys(response.data)){
                        jQuery('[data-mywpg_'+key+']').val( response.data[key] );
                        jQuery('[data-mywpg_'+key+']').attr('data-mywpg_'+key+'', response.data[key] );
                    };

                    jQuery('[data-mywpg_imgsrc]').attr('src', response.data['url'] );

                }
                else {
                    alert("Server Error Occured")
                }
            }
        })
    }

window.MYWPG_updateImageGallery = (e, elem) => {
    e.preventDefault();
    // alert('Hello');
    
    let formData = {
        title: jQuery(elem).find('[name=title]').val(),
        description: jQuery(elem).find('[name=description]').val(),
        action: "mywpg_gallery_image_update",
        gallery_id: <?php echo $GalleryData->gallery_id ?>,
        image_id: jQuery(elem).attr('data-mywpg-image_id'),
        nonce: myAjax.nonce
    };

    // send ajax request
    jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: formData,
        success: function (response) {
            if (response.status == "success") {
                jQuery('#mywpg-message-right').html('<div class="notice notice-success inline">'+'<p><?php echo _e( 'Image settings updated successfully', MYWPG_TEXT_DOMAIN ); ?></p>'+'</div> <BR><BR>');
                setTimeout(() => {
                    jQuery('#mywpg-message-right').html('');
                }, 15000);
            }
            else {
                alert("Server Error Occured")
            }
        }
    })

}

window.MYWPG_updateGallery = (e, elem) => {
    e.preventDefault();

    // console.log(new FormData(elem));

    let formData = jQuery(elem).serializeArray();

    // formData['action'] = 'mywpg_gallery_gallery_update';

    formData.push({name: 'gallery_id', value: <?php echo $GalleryData->gallery_id ?> })
    formData.push({name: 'action', value: 'mywpg_gallery_gallery_update'})
    formData.push({name: 'nonce', value: myAjax.nonce})

    console.log(formData);

    // send ajax request
    jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: formData,
        success: function (response) {
            if (response.status == "success") {
                jQuery('#mywpg-message-right').html('<div class="notice notice-success inline">'+'<p><?php echo _e( 'Gallery settings updated successfully', MYWPG_TEXT_DOMAIN ); ?></p>'+'</div> <BR><BR>');
                setTimeout(() => {
                    jQuery('#mywpg-message-right').html('');
                }, 15000);
            }
            else {
                alert("Server Error Occured")
            }
        }
    })

}

jQuery(document).ready(function($){

    jQuery('.mywpg-gallery-image-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: true
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_images = image.state().get('selection');
            uploaded_images.map((uploaded_image) => {

                var image_obj = uploaded_image.toJSON();
                var image_url = uploaded_image.toJSON().url;
                

                let code = Math.floor(Math.random() * 100);

                // append and loading icon
                jQuery('.mywpg-gallery-images-wrapper').append(
                    '<div class="mywpg-gallery-image" id="mywpg_gallery_'+code+'" style="background-image: url(\''+image_url+'\');"><div class="spinner is-active" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;"></div></div>');

                // let data = new FormData();

                // send ajax request
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: myAjax.ajaxurl,
                    data: { action: "mywpg_gallery_image_insert", gallery_id: '<?php echo $GalleryData->gallery_id ?>', image: image_url, title: image_obj.title, description: image_obj.description, nonce: myAjax.nonce },
                    success: function (response) {
                        if (response.status == "success") {
                            jQuery('#mywpg_gallery_'+code).css({
                                'background-image': 'url(\''+image_url+'\')'
                            });
                            jQuery('#mywpg_gallery_'+code).html('<div class="mywpg-gallery-image-btns">'+
                                    '<button type="button" class="mywpg-btn-img-edit" onclick="WPG_openTab(\'mywpg-image-settings\', '+response.image_id+')"><span class="dashicons dashicons-edit"></span></button> '+
                                    '&nbsp; '+
                                    '<button type="button" class="mywpg-btn-img-delete" onclick="deleteImageGallery(this, '+response.image_id+')"><span class="dashicons dashicons-trash"></span></button>'+
                            '</div>');

                            jQuery('#mywpg_gallery_'+code).attr('id', 'mywpg_gallery_'+response.image_id)


                        }
                        else {
                            alert("Server Error Occured")
                        }
                    }
                })

            })

        });
    });
});

window.deleteImageGallery = (elem, image_id) => {
    if(confirm('Are you sure you want to remove this image from gallery ?')){

         // send ajax request
         jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            data: { action: "mywpg_gallery_image_delete", gallery_id: '<?php echo $GalleryData->gallery_id ?>', image_id: image_id, nonce: myAjax.nonce  },
            success: function (response) {
                if (response.status == "success") {
                    jQuery('#mywpg_gallery_'+image_id).remove();
                }
                else {
                    alert("Server Error Occured")
                }
            }
        });
        
    }else{
        
    }
}
</script>