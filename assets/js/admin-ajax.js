jQuery(document).ready(function () {

    window.mywpg_gallery_submit = (e, elem) => {
        e.preventDefault();

        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            data: { action: "mywpg_gallery_save_api", title: jQuery(elem).find('[name=title]').val(), nonce: myAjax.nonce },
            success: function (response) {
                if (response.status == "success") {
                    // console.log("success");
                    // return;
                    window.location.href = response.redirect_url;
                }
                else {
                    alert("Server Error Occured")
                }
            }
        })

    };

})