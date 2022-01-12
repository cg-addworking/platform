<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.common.file._form.general_information') }}</legend>

    @if ($file->exists)
        <div class="row">
            <div class="col-md-3">
                @form_group([
                    'text'        => __('addworking.common.file._form.mime_type'),
                    'type'        => "select",
                    'options'     => config('mime-type'),
                    'name'        => "file.mime_type",
                    'value'       => optional($file)->mime_type,
                    'required'    => true,
                    'ignore_keys' => true,
                ])
            </div>
            <div class="col-md-9">
                @form_group([
                    'text'        => __('addworking.common.file._form.path'),
                    'type'        => "text",
                    'name'        => "file.path",
                    'value'       => optional($file)->path,
                    'required'    => true,
                ])
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            @form_group([
                'text'        => __('addworking.common.file._form.file'),
                'type'        => "file",
                'name'        => "file.content",
                'accept'      => '.pdf, .png, .jpg, .jpeg, .csv',
                'required'    => ! $file->exists,
            ])
        </div>
    </div>
</fieldset>
