
<div class="mywpg-page-header">
    <h1><?php _e("WPX GALLERY", MYWPG_TEXT_DOMAIN) ?></h1>
</div>
<div class="mywpg-page-wrapper">
<br />
<br />

    <table class="widefat">
        <thead>
            <tr>
                <th>#</th>
                <th class="row-title"><?php _e("Title", MYWPG_TEXT_DOMAIN) ?></th>
                <th><?php _e("Shortcode", MYWPG_TEXT_DOMAIN) ?></th>
                <th><?php _e("Created", MYWPG_TEXT_DOMAIN) ?></th>
                <th><?php _e("Action", MYWPG_TEXT_DOMAIN) ?></th>
            </tr>
        </thead>
	    <tbody>
            <?php if(!empty($GalleryData)): foreach($GalleryData as $row): ?>
                <tr>
                    <td class="row-title"><?php echo $row->gallery_id ?></td>
                    <td class="row-title"><label for="tablecell" onclick="window.location.href = '<?php echo admin_url('/admin.php?page=mywpg-edit-gallery&gallery_id='.$row->gallery_id) ?>'"><?php echo $row->title ?></label></td>
                    <td><?php echo '<code>[mywpg_gallery gallery_id='.$row->gallery_id.']</code>' ?></td>
                    <td><?php echo $row->created_at ?></td>
                    <td>
                        <a href="<?php echo admin_url('/admin.php?page=mywpg-edit-gallery&gallery_id='.$row->gallery_id) ?>" class="button"><?php _e("Edit", MYWPG_TEXT_DOMAIN) ?></a>
                        <a href="<?php echo admin_url('/admin.php?page=mywpg-edit-gallery&action=delete_category&gallery_id='.$row->gallery_id) ?>" onclick="return confirm('Are you sure you want to delete this gallery ?')" class="button-secondary"><?php _e("Delete", MYWPG_TEXT_DOMAIN) ?></a>
                        <a href="<?php echo home_url('?mywp_gallery='.$row->gallery_id) ?>" target="_blank" class="button"><?php _e("Preview", MYWPG_TEXT_DOMAIN) ?></a>
                    </td>
                </tr>

            <?php endforeach; else:  ?>
                <tr>
                    <td colspan="10" style="text-align: center;">No Records Found</td>
                </tr>
            <?php endif; ?>
                
        </tbody>
        <tfoot>
        <tr>
                <th>#</th>
                <th class="row-title"><?php _e("Title", MYWPG_TEXT_DOMAIN) ?></th>
                <th><?php _e("Shortcode", MYWPG_TEXT_DOMAIN) ?></th>
                <th><?php _e("Created", MYWPG_TEXT_DOMAIN) ?></th>
                <th><?php _e("Action", MYWPG_TEXT_DOMAIN) ?></th>
        </tr>
        </tfoot>
    </table>
    <br>
    <a class="button-primary" href="<?php menu_page_url('mywpg-new-gallery') ?>" title="<?php _e("Add Gallery", MYWPG_TEXT_DOMAIN) ?>">
        <?php _e("Add Gallery", MYWPG_TEXT_DOMAIN) ?>
    </a>
    <br>

</div>