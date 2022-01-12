<fieldset>
    <div class="row">
        <div class="col-md-12">
            @form_group([
                'type'     => "text",
                'name'     => "offer.label",
                'required' => true,
                'text'     => __('offer::offer.construction._form.label'),
                'value'    => optional($offer)->getLabel(), 
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('offer::offer.construction._form.enterprises')}}
                    <sup class=" text-danger font-italic">*</sup>
                </label>
                <select
                        data-live-search="1"
                        class="form-control shadow-sm selectpicker"
                        id="selected_enterprise"
                        name="offer[enterprise_id]"
                        @if ($page === 'edit' || ! is_null($workfield))
                            disabled
                        @endif
                >
                    @foreach($enterprises as $id => $name)
                        <option value="{{ $id }}" @if(! is_null($owner) && $owner == $id) selected @endif>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

       <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('offer::offer.construction._form.referents')}}
                    <sup class=" text-danger font-italic">*</sup>
                </label>
                <select data-live-search="1" class="form-control shadow-sm selectpicker" id="selected_referent" name="offer[referent_id]"></select>
            </div>
        </div>
    </div>

    <div class="row">
         <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('offer::offer.construction._form.workfield')}}
                </label>
                <select
                        data-live-search="1"
                        class="form-control shadow-sm selectpicker"
                        id="selected_workfield"
                        name="offer[workfield_id]"
                        @if ($page === 'edit' || ! is_null($workfield))
                            disabled
                        @endif
                ></select>
                @if( ! is_null($workfield))
                    <input type="hidden" name="offer[workfield_id]" value="{{ $workfield }}">
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('offer::offer.construction._form.departments')}}
                </label>
                <select data-live-search="1" multiple="1" class="form-control shadow-sm selectpicker" name="offer[departments][]">
                    @foreach($departments as $id => $name)
                        <option
                                value="{{$id}}"
                                @if (isset($selected_departments) && in_array($id, array_keys($selected_departments)))
                                    selected
                                @endif
                        >
                            {{$name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'type'     => "date",
                'name'     => "offer.starts_at_desired",
                'required' => true,
                'text'     => __('offer::offer.construction._form.starts_at_desired'),
                'value'    => optional($offer)->getStartsAtDesired(),
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'type'  => "date",
                'name'  => "offer.ends_at",
                'text'  => __('offer::offer.construction._form.ends_at'),
                'value' => optional($offer)->getEndsAt(),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('offer::offer.construction._form.asked_skills')}}
                </label>
                <select data-live-search="1" multiple="1" class="form-control shadow-sm selectpicker" id="selected_skill" name="offer[skills][]"></select>
            </div>
        </div>
        <div class="col-md-6">
            @form_group([
                'type' => "date",
                'name' => "offer.response_deadline",
                'text' => __('offer::offer.construction._form.response_deadline'),
                'value'    => optional($offer)->getResponseDeadline(),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @form_group([
                'type'     => "textarea",
                'name'     => "offer.description",
                'required' => true,
                'text'     => __('offer::offer.construction._form.description'),
                'rows'     => 6,
                'value'    => optional($offer)->getDescription(),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'name'  => "offer.external_id",
                'text'  => __('offer::offer.construction._form.external_id'),
                'value' => optional($offer)->getExternalId(),
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'name'  => "offer.analytic_code",
                'text'  => __('offer::offer.construction._form.analytic_code'),
                'value' => optional($offer)->getAnalyticCode(),
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
                'type'        => "file",
                'name'        => "offer.file.",
                'required'    => false,
                'text'       => __('offer::offer.construction._form.files'),
                'multiple'    => true,
            ])
        </div>
        <div>
            <ul>
            @foreach($offer->getFiles() as $file)
                <li>
                    {{ $file->name ?? basename($file->path) }} <small class="text-muted">{{ human_filesize($file->size) }}</small>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
</fieldset>

