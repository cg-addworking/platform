<fieldset>
    <div class="row">
        <div class="col-md-12">
            @form_group([
                'type'     => "text",
                'name'     => "mission.label",
                'required' => true,
                'text'     => __('mission::mission.construction._form.label'),
                'value'    => optional($mission)->getLabel(),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('mission::mission.construction._form.enterprises')}}
                    <sup class=" text-danger font-italic">*</sup>
                </label>
                <select
                        data-live-search="1"
                        class="form-control shadow-sm selectpicker"
                        id="selected_enterprise"
                        name="mission[enterprise_id]"
                        @if ($page === 'edit' || ! is_null($workfield))
                            disabled
                        @endif
                >
                    @foreach($enterprises as $id => $name)
                        <option
                                value="{{ $id }}"
                                @if(! is_null($owner) && $owner == $id)
                                    selected
                                @endif
                        >
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

       <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('mission::mission.construction._form.referents')}}
                    <sup class=" text-danger font-italic">*</sup>
                </label>
                <select data-live-search="1" class="form-control shadow-sm selectpicker" id="selected_referent" name="mission[referent_id]"></select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    {{__('mission::mission.construction._form.vendors')}}
                    <sup class=" text-danger font-italic">*</sup>
                </label>
                <select data-live-search="1" class="form-control shadow-sm selectpicker" id="selected_vendor" name="mission[vendor_id]" @if ($page === 'edit') disabled @endif></select>
            </div>
        </div>
    </div>

    <div class="row">
         <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('mission::mission.construction._form.workfield')}}
                </label>
                <select
                        data-live-search="1"
                        class="form-control shadow-sm selectpicker"
                        id="selected_workfield"
                        name="mission[workfield_id]"
                        @if ($page === 'edit' || ! is_null($workfield))
                            disabled
                        @endif
                ></select>
                @if( ! is_null($workfield))
                    <input type="hidden" name="mission[workfield_id]" value="{{ $workfield }}">
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('mission::mission.construction._form.departments')}}
                </label>
                <select data-live-search="1" multiple="1" class="form-control shadow-sm selectpicker" name="mission[departments][]">
                    @foreach($departments as $id => $name)
                        <option
                                value="{{$id}}"
                                @if (isset($selected_departments) && in_array($id, $selected_departments))
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
                'name'     => "mission.starts_at",
                'required' => true,
                'text'     => __('mission::mission.construction._form.starts_at'),
                'value'    => optional($mission)->getStartsAt(),
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'type'  => "date",
                'name'  => "mission.ends_at",
                'text'  => __('mission::mission.construction._form.ends_at'),
                'value' => optional($mission)->getEndsAt(),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @form_group([
                'type'     => "textarea",
                'name'     => "mission.description",
                'required' => true,
                'text'     => __('mission::mission.construction._form.description'),
                'rows'     => 6,
                'value'    => optional($mission)->getDescription(),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col">
            @form_group([
                'name'     => "mission.amount",
                'text'     => __('mission::mission.construction._form.amount'),
                'value'    => optional($mission)->getAmount() ?? '0',
                'type'     => 'number',
                'step'     => '0.01',
                'required' => true,
            ])
        </div>
        <div class="col">
            @form_group([
                'name'  => "mission.external_id",
                'text'  => __('mission::mission.construction._form.external_id'),
                'value' => optional($mission)->getExternalId(),
            ])
        </div>
        <div class="col">
            @form_group([
                'name'  => "mission.analytic_code",
                'text'  => __('mission::mission.construction._form.analytic_code'),
                'value' => optional($mission)->getAnalyticCode(),
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
                'type'        => "file",
                'name'        => "mission.file.",
                'required'    => false,
                'text'       => __('mission::mission.construction._form.files'),
                'multiple'    => true,
            ])
        </div>
        <div>
            <ul>
            @foreach($mission->getFiles() as $file)
                <li>
                    {{ $file->name ?? basename($file->path) }} <small class="text-muted">{{ human_filesize($file->size) }}</small>
                </li>
            @endforeach
            </ul>
        </div>
    </div>


    @if( ! is_null($workfield))
        <fieldset class="mt-5 pt-2">
            <legend class="text-primary h5">@icon('info') {{ __('mission::mission.construction._form.cost_estimation.title') }}</legend>
            <div class="row">
                <div class="col">
                    @form_group([
                        'name'     => "mission.cost_estimation.amount_before_taxes",
                        'text'     => __('mission::mission.construction._form.cost_estimation.amount_before_taxes'),
                        'value'    => optional($mission->getCostEstimation())->getAmountBeforeTaxes() ?? '0',
                        'type'     => 'number',
                        'step'     => '0.01',
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @form_group([
                        'type'        => "file",
                        'name'        => "mission.cost_estimation.file",
                        'required'    => false,
                        'text'       => __('mission::mission.construction._form.cost_estimation.file'),
                        'multiple'    => false,
                    ])
                </div>
                <div>
                    @if($mission->getCostEstimation() && $mission->getCostEstimation()->getFile())
                    <ul>
                        <li>
                            {{ $mission->getCostEstimation()->getFile()->name ?? basename($mission->getCostEstimation()->getFile()->path) }}
                            <small class="text-muted">
                                {{ human_filesize($mission->getCostEstimation()->getFile()->size) }}
                            </small>
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </fieldset>
    @endif
</fieldset>

