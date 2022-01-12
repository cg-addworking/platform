<script src="https://cdn.tiny.cloud/1/{{env('TINYMCE_API_KEY')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    tinymce.PluginManager.add('custom_preview', function(editor) {
        var openDialog = function () {
            return editor.windowManager.open({
                title: 'Preview',
                body: {
                    type: 'panel',
                    items: [
                    ]
                },
                buttons: [
                    {
                        type: 'cancel',
                        text: 'Close'
                    },
                ]
            });
        };
        editor.ui.registry.addButton('custom_preview', {
            text: 'Preview',
            onAction: function () {
                var content = tinyMCE.activeEditor.getContent();
                if (content !== null && content !== '') {
                    var url = "{{ route('support.contract.model.part.wysiwyg_preview', $contract_model) }}";
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            content: content
                        },
                        beforeSend: function () {
                            $('#contract-owner-id option').remove();
                        },
                        success: function(response) {
                            openDialog();
                            $('.tox-dialog__body-content').append('<embed ' +
                                'id="custom_preview_embed" '+
                                'type="application/pdf" ' +
                                'src="" ' +
                                'width="250" ' +
                                'height="200">'
                            );

                            var embed = $('#custom_preview_embed');
                            embed.attr('src', 'data:application/pdf;base64,'+response.data);
                            $('.tox-dialog').css('min-height', '80%');
                            $('.tox-dialog').css('min-width', '90%');

                            embed.css('min-height', '100%');
                            embed.css('min-width', '90%');
                        },
                    });
                } else {
                    alert('{{__('components.contract.model.application.views.contract_model_part._form.empty_textarea')}}');
                }
            }
        });
        editor.ui.registry.addMenuItem('custom_preview', {
            text: 'Preview',
            onAction: function() {
                openDialog();
            }
        });
        return {
            getMetadata: function () {
                return  {
                    name: 'Preview'
                };
            }
        };
    });

    tinymce.init({
        selector: 'textarea',
        plugins: 'custom_preview print paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: false,
        toolbar: 'custom_preview | undo redo | cut copy paste pastetext searchreplace | bold italic underline strikethrough superscript subscript | fontselect fontsizeselect formatselect lineheight | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor hr removeformat | pagebreak | charmap | fullscreen  | insertfile image link table insertdatetime',
        toolbar_sticky: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        importcss_append: true,
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>
