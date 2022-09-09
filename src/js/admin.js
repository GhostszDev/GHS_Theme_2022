jQuery(document).ready( function($){

    var mediaUploader;

    var iconSelect = [
        {
            name: 'Headphones',
            value: ghs_obj.mediaPath + 'icons.svg#icon-headphones'
        },
        {
            name: 'VR Helmet',
            value: ghs_obj.mediaPath + 'icons.svg#icon-vr'
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

    function changeIcon(e){
        var currentInput = $(e.currentTarget).val();
        var preview = e.currentTarget.parentElement.parentElement.children[0].children[0];
        let capture = e.currentTarget.parentElement.nextElementSibling;

        $(preview).attr('href', currentInput);
        $(capture).val(currentInput);

    }

    $('#upload-button_1, #upload-button_2, #upload-button_3, #insight_submit').on('click', function (a) {
       // console.log(a);
       mediaUpload(a);
    });

    if($('.icon_select').length > 0){

        let featColumn = [
            {
                icon: ghs_obj.featColumn.icon_1
            },
            {
                icon: ghs_obj.featColumn.icon_2
            },
            {
                icon: ghs_obj.featColumn.icon_3
            },
        ];

        let key = 0;

        iconSelect.forEach((v)=>{

            if(v.value == featColumn[key].icon) {
                $('.icon_select').append(
                    `<option value="${v.value}" selected="selected">${v.name}</option>`
                );
            } else {
                $('.icon_select').append(
                    `<option value="${v.value}">${v.name}</option>`
                );
            }

            key++;
        });

        $('.icon_select').on('change', function(b){
            changeIcon(b);
        });
    }

});