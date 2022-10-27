jQuery(document).ready( function($) {

    if($('.ghs_woocommerce_content .woocommerce-Address').length > 0) {
        $('.ghs_woocommerce_content .woocommerce-Address').removeClass('col-1');
        $('.ghs_woocommerce_content .woocommerce-Address').removeClass('col-2');
        $('.ghs_woocommerce_content .woocommerce-Address').removeClass('col-3');
        $('.ghs_woocommerce_content .woocommerce-Address').removeClass('col-4');
        $('.ghs_woocommerce_content .woocommerce-Address').removeClass('col-5');

        $('.ghs_woocommerce_content .woocommerce-Address-title a').text('').append('<span class="ghs_feat_post_info btn btn-info btn-sm">Edit</span>');
    }

})