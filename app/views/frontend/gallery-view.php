<div class="mywpg-gallery-list" id="lightgallery">

    <?php foreach($GalleryImagesData as $image): ?>
        <?php
$WPG_show_title = (!empty($image->title) && $GalleryData->hide_title!=1)?true:false;
$WPG_show_desc = (!empty($image->description) && $GalleryData->hide_description!=1)?true:false;
?>
        
        <div class="mywpg-gallery-item" data-src="<?php echo $image->url ?>"  data-sub-html="<?php if(!empty($image->title) && $GalleryData->hide_title!=1){ ?><h5 style='color: white'><?php echo $image->title ?></h5><?php } ?><?php if(!empty($image->description) && $GalleryData->hide_description!=1){ ?><p><?php echo $image->description ?></p><?php } ?>">
            <img src="<?php echo $image->url ?>" alt="<?php echo $image->title ?>" title="<?php echo $image->title ?>" />

            <?php if($WPG_show_title || $WPG_show_desc){ ?>
                <div class="mywpg-item-inner">
                    <?php if($WPG_show_title){ ?>
                        <h5><?php echo $image->title ?></h5>
                    <?php } ?>
                    <?php if($WPG_show_desc){ ?>
                        <p><?php echo $image->description ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

    <?php endforeach ?>

</div>

<script>

    jQuery(document).ready(() => {
        lightGallery(document.getElementById('lightgallery'), {
            thumbnail: true,
            selector: '.mywpg-gallery-item'
        });

    })

</script>