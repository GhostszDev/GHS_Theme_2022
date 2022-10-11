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
        },
        {
            name: 'Gamepad',
            value: ghs_obj.mediaPath + 'icons.svg#icon-gamepad'
        },
        {
            name: 'Console',
            value: ghs_obj.mediaPath + 'icons.svg#icon-console'
        },
        {
            name: 'Mobile Gaming',
            value: ghs_obj.mediaPath + 'icons.svg#icon-mobile-gaming'
        },
        {
            name: 'Coding',
            value: ghs_obj.mediaPath + 'icons.svg#icon-coding'
        }
    ]

    var employeeTemplate = {
        'image': '',
        'name': '',
        'position': '',
        'Description': ''
    }

    var employees = ghs_obj.employees;

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

    $('.ghs_add_button').on('click', function (a) {
       // console.log(a);
        addToEmployeeArray(a);
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

        iconSelect.forEach((v)=>{

            $('.icon_select').append(
                `<option value="${v.value}">${v.name}</option>`
            );

        });

        $('.icon_select').on('change', function(b){
            changeIcon(b);
        });
    }

    function loadIcon(name) {
        var preview = $(name)[0].parentElement.parentElement.children[0].children[0];

        switch(name) {
            case '.ghs_feat_column_select_1':
                $(preview).attr('href', ghs_obj.featColumn.icon_1);
                $(name + ' option[value='+JSON.stringify(ghs_obj.featColumn.icon_1)+']').prop("selected", true)
            break;
            case '.ghs_feat_column_select_2':
                $(preview).attr('href', ghs_obj.featColumn.icon_2);
                $(name + ' option[value='+JSON.stringify(ghs_obj.featColumn.icon_2)+']').prop("selected", true)
            break;
            case '.ghs_feat_column_select_3':
                $(preview).attr('href', ghs_obj.featColumn.icon_3);
                $(name + ' option[value='+JSON.stringify(ghs_obj.featColumn.icon_3)+']').prop("selected", true)
            break;
        }
        // $(capture).val(currentInput);
    }

    if($('.ghs_feat_column_select_1').length > 0) {
        loadIcon('.ghs_feat_column_select_1');
    }

    if($('.ghs_feat_column_select_2').length > 0) {
        loadIcon('.ghs_feat_column_select_2');
    }

    if($('.ghs_feat_column_select_3').length > 0) {
        loadIcon('.ghs_feat_column_select_3');
    }

    function addToEmployeeArray(){
        var appendable = $('.ghs_employee_list');
        var listItem = "<li>" +
            "<label for=\"insight_bg\">\n" +
            "<img class=\"insight_img\" src=\"https://placehold.jp/1920x1080.png\" " +
            "value=\"Upload Profile Picture\" id=\"insight_submit\" />\n" +
            "</label>\n" +
            "<input id=\"insight_bg\" class=\"insight_bg\" name=\"employee["+employees.length+"][image]\" value=\"\" />\n" +
            "<input type=\"text\"  name=\"employee["+employees.length+"][name]\" value=\"\" placeholder=\"Name\">\n" +
            "<input type=\"text\"  name=\"employee["+employees.length+"][position]\" value=\"\" placeholder=\"Position\">\n" +
            "<textarea placeholder=\"Description\" name=\"employee["+employees.length+"][description]\" ></textarea>" +
            "</li>";

        if(appendable.length > 0){
            appendable.append(listItem);
        }

        employees.push(employeeTemplate);

    }

    $(document).on('click', '#upload-button_1, #upload-button_2, #upload-button_3, #insight_submit', function (a) {
        // console.log(a);
        mediaUpload(a);
    });

});