jQuery(document).ready( function($) {
    var ghs_woo_addy = $('.ghs_woocommerce_content .woocommerce-Address');
    var ghs_woo_addy_p = $('.ghs_woocommerce_content p');

    var ghs_woo_msg = $('.ghs_woocommerce_content .woocommerce-message');
    var ghs_woo_Msg = $('.ghs_woocommerce_content .woocommerce-Message');

    var ghs_woo_edit_acc = $('.ghs_woocommerce_content .woocommerce-EditAccountForm');

    if(ghs_woo_addy.length > 0) {
        ghs_woo_addy.removeClass('col-1');
        ghs_woo_addy.removeClass('col-2');
        ghs_woo_addy.removeClass('col-3');
        ghs_woo_addy.removeClass('col-4');
        ghs_woo_addy.removeClass('col-5');

        $('.ghs_woocommerce_content .woocommerce-Address-title a').text('').append('<span class="ghs_feat_post_info btn btn-info btn-sm">Edit</span>');
        ghs_woo_addy_p.addClass('alert alert-primary mb-4');
    }

    if(ghs_woo_msg.length > 0 || ghs_woo_Msg.length > 0){
        ghs_woo_msg.addClass('alert alert-primary mb-4');
        ghs_woo_Msg.addClass('alert alert-primary mb-4');
    }

    if(ghs_woo_edit_acc.length > 0){
        ghs_woo_edit_acc.addClass('px-5');
        $('.woocommerce-form-row label').addClass('form-label');
        $('.woocommerce-form-row span').addClass('form-text');
        $('.woocommerce-form-row .woocommerce-Input').addClass('form-control');
        $('.woocommerce-form-row').addClass('mb-3');
        $('.ghs_woocommerce_content fieldset').addClass('mt-5');
        $('.ghs_woocommerce_content button').addClass('btn btn-primary');
        $('.woocommerce-form__input').addClass('me-3');
    }

})