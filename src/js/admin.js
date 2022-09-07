jQuery(document).ready( function($){

    var mediaUploader;

    function mediaUpload(e){
        let capture = e.currentTarget.parentElement.nextElementSibling;

        e.preventDefault();
        if( mediaUploader ){
            mediaUploader.id = e.target;
            mediaUploader.capture = capture;
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            id: e.target,
            capture: capture,
            title: 'Choose a Profile Picture',
            button: {
                text: 'Choose Picture'
            },
            multiple: false
        });

        mediaUploader.on('select', function(){
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            if(mediaUploader.capture) {
                $(mediaUploader.capture).val(attachment.id);
            } else {
                $(capture).val(attachment.id);
            }
            $(mediaUploader.id).attr('src', attachment.url);
        });

        mediaUploader.open();
    }

   $('#upload-button_1, #upload-button_2, #upload-button_3').on('click', function (a) {
       // console.log(a);
       mediaUpload(a);
    });

});