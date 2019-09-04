(function () {
    tinymce.PluginManager.add( 'auth_bio_mce_job_button', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('auth_bio_mce_job_button', {
            title: 'Insert Event',
            cmd: 'auth_bio_mce_command',
            image: url + '/tinymce_icon.png'
        });
        // Add Command when Button Clicked
        editor.addCommand('auth_bio_mce_command', function() {
            editor.windowManager.open({
                title: window.auth_bio_tinymce_vars.title,
                body: [
                    {
                        type   : 'listbox',
                        name   : 'authorbio_shortcode',
                        label  : window.auth_bio_tinymce_vars.label,
                        values : window.auth_bio_tinymce_vars.events
                    }
                ],
                width: 768,
                height: 100,
                onsubmit: function (e) {
                    if( e.data.authorbio_shortcode ) {
                        let extraString = '';
                        let shortcodec = `[authorbio id="${e.data.authorbio_shortcode}"]`
                        if(extraString) {
                            shortcodec = `[authorbio id="${e.data.authorbio_shortcode}" ${extraString}]`;
                        }
                        editor.insertContent( shortcodec );
                    } else {
                        alert(window.auth_bio_tinymce_vars.select_error);
                        return false;
                    }
                },
                buttons: [
                    {
                        text: window.auth_bio_tinymce_vars.insert_text,
                        subtype: 'primary',
                        onclick: 'submit'
                    }
                ]
            }, {
                'tinymce': tinymce
            });
        });

    });
})();
