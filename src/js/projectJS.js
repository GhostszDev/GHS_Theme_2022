jQuery(document).ready( function($) {

    var fullscreenBtn = $('.fullscreenBtn');
    var iFrame = $('.ghs-projects-iframe');
    var divFrame = $('.ghs-projects-frame');
    var bodyTag = $('.ghs_body');
    var ghsInsight = $('.ghs_insight');
    var ghsSinglePostContainer = $('.ghs_single_post_container');
    var ghsSinglePost = $('.ghs_single_post');
    var  ghsIFrameScrollable = $('.ghs_iFrame_scrollable');


    fullscreenBtn.on('click', function () {
        if(iFrame.hasClass('fullScreen')){
            iFrame.removeClass('fullScreen');
            divFrame.removeClass('fullScreen');
            bodyTag.removeAttr('scroll');
            bodyTag.removeClass('ghs-noScroll');
            ghsInsight.removeClass('position-absolute');
            fullscreenBtn.removeClass('ghs-fullScreenedBtn');
            ghsSinglePostContainer.removeClass('position-absolute');
            ghsSinglePost.removeClass('ghs-NoPadding');
            ghsIFrameScrollable.attr('scrolling', 'no');
        }else {
            iFrame.addClass("fullScreen");
            divFrame.addClass("fullScreen");
            bodyTag.attr('scroll', 'no');
            bodyTag.addClass('ghs-noScroll');
            ghsInsight.addClass('position-absolute');
            fullscreenBtn.addClass('ghs-fullScreenedBtn');
            ghsSinglePostContainer.addClass('position-absolute');
            ghsSinglePost.addClass('ghs-NoPadding');
            ghsIFrameScrollable.attr('scrolling', 'yes');
        }
    });

})