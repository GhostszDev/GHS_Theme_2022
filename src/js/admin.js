jQuery(document).ready( function($){

    var mediaUploader;

    var iconSelect = [
        {
            name: 'GamePad',
            value: 'lni-game'
        }
    ]

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

    $('#upload-button_1, #upload-button_2, #upload-button_3, #insight_submit').on('click', function (a) {
       // console.log(a);
       mediaUpload(a);
    });

    if($('.ghs_feat_column_select').length > 0){
        iconSelect.forEach((v)=>{
            $('.ghs_feat_column_select').append(
                `<option value="${v.value}">
                                       ${v.name}
                                  </option>`
            );
        });
    }

});