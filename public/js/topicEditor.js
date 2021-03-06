$(function()
{
    $('#form_complete_library').preventDoubleSubmission();

    // Input des tags
    $('.ui-widget-content').attr('value', '5 mots max (ex: mariage)');
    
    $('ul.tagit input[type="text"]').css('color','#888');
    $('ul.tagit input[type="text"]').focus(function() {
        $(this).val('');
        $(this).css('color','#333');
    });
    
    CKEDITOR.on( 'dialogDefinition', function( ev )
    {
            // Take the dialog name and its definition from the event
            // data.
            var dialogName = ev.data.name;
            var dialogDefinition = ev.data.definition;
            var infoTab;

            // Check if the definition is from the dialog we're
            // interested on (the "Link" dialog).
            if ( dialogName == 'link' )
            {
                    // Get a reference to the "Link Info" tab.
                    infoTab = dialogDefinition.getContents( 'info' );

                    // Remove the "Link Type" combo and the "Browser
                    // Server" button from the "info" tab.
                    infoTab.remove( 'protocol' );
                    infoTab.remove( 'linkType' );
                    infoTab.remove( 'browse' );

                    // Remove the "Target" tab from the "Link" dialog.
                    dialogDefinition.removeContents( 'target' );
                    dialogDefinition.removeContents( 'advanced' );

                    // Rewrite the 'onFocus' handler to always focus 'url' field.
                    dialogDefinition.onFocus = function()
                    {
                            var urlField = this.getContentElement( 'info', 'url' );
                            urlField.select();
                    };
            }

            if ( dialogName == 'image' )
            {
                dialogDefinition.onShow = function () {
                    // This code will open the Upload tab.
                    this.selectPage('Upload');
                };
                infoTab = dialogDefinition.getContents( 'info' );
                dialogDefinition.removeContents( 'Link' );
                dialogDefinition.removeContents( 'advanced' );
                infoTab.remove( 'browse' );
                infoTab.remove( 'txtWidth' );
                infoTab.remove( 'txtHeight' );
                infoTab.remove( 'ratioLock' );
                infoTab.remove( 'txtBorder' );
                infoTab.remove( 'txtHSpace' );
                infoTab.remove( 'txtVSpace' );
                infoTab.remove( 'cmbAlign' );
                infoTab.remove( 'htmlPreview' );
            }
    });
        
    // Nouveau Topic
    var editor = CKEDITOR.replace('form_topic_content',{
		toolbar : [['Bold','Italic','Underline', 'FontSize', '-', 'Image', '-', 'Undo','Redo','-','NumberedList', 'BulletedList','-','Link','Unlink', '-', 'About']],
                //filebrowserBrowseUrl: '/simogeo-Filemanager-8b138bc/index.html',
                language : 'fr',
                entities : false,
                scayt_autoStartup : true,
                scayt_sLang : 'fr_FR',
                scayt_contextCommands : 'off',
                contentsCss : '/css/assets/output_xhtml.css',
                coreStyles_bold	: { element : 'span', attributes : {'class': 'Bold'} },
                coreStyles_italic	: { element : 'span', attributes : {'class': 'Italic'}},
                coreStyles_underline	: { element : 'span', attributes : {'class': 'Underline'}},
                fontSize_sizes : '10/FontTen;12/FontTwelve;14/FontFourteen;16/FontSixteen;20/FontTwenty;24/FontTwentyfour',
                fontSize_style :
                {
                    element : 'span',
                    attributes : { 'class' : '#(size)' }
                },
                width : 700,
                forcePasteAsPlainText :true,
                
                on :
                {
                    instanceReady : function( ev )
                    {
                        this.dataProcessor.writer.setRules( 'p',
                        {
                            indent : false,
                            breakBeforeOpen : true,
                            breakAfterOpen : false,
                            breakBeforeClose : false,
                            breakAfterClose : true
                        });
                    }
                }
    });
    
    CKFinder.setupCKEditor( editor, '/js/ckfinder/' );
});
