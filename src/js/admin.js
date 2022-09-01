jQuery(document).ready( function($){

    var mediaUploader;

    if($('#upload-button_1').length > 0) {
        $('#upload-button_1').on('click', function (e) {
            mediaUpload(e, 1);
        });
    };

    if($('#upload-button_2').length > 0) {
        $('#upload-button_2').on('click', function (e) {
            mediaUpload(e, 2);
        });
    };

    if($('#upload-button_3').length > 0) {
        $('#upload-button_3').on('click', function (e) {
            mediaUpload(e, 3);
        });
    };


    function mediaUpload(e, n){
        e.preventDefault();
        if( mediaUploader ){
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose a Profile Picture',
            button: {
                text: 'Choose Picture'
            },
            multiple: false
        });

        mediaUploader.on('select', function(){
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            console.log(attachment);
            $('#profile-picture_'+ n).val(attachment.id);
            $('#profile-picture-preview_'+ n).css('background-image','url(' + attachment.url + ')');
        });

        mediaUploader.open();
    };

});