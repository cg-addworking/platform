@component('components.panel', ['class' => "info", 'icon' => "black-tie"])
    @slot('heading')
        @if (Auth::user()->enterprise->is($enterprise->signatories->first()))
            @lang('enterprise.enterprise.my_activity_title')
        @else
            {{ __('addworking.enterprise.enterprise_signatory._form.legal_representative') }} : {{ $enterprise->legalRepresentatives->first()->name }}
        @endif
    @endslot

    @if ($enterprise->signatories->count() == 1)
        <input type="hidden" name="signatory[id]" value="{{ $enterprise->signatories->first()->id }}">
    @else
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "signatory.id",
            'value'  => $enterprise->signatories->first()->id,
            'values' => $enterprise->signatories->pluck('name', 'id')
        ])
            @slot('label')
                {{ __('addworking.enterprise.enterprise_signatory._form.signatory_contracts') }}
            @endslot
        @endcomponent
    @endif

    <div class="row">
        <div class="col-md-6">
            @component('components.form.group', [
                'name'     => "signatory.job_title",
                'value'    => $enterprise->users->get("{$enterprise->signatories->first()->id}.pivot.job_title") ?: __('addworking.enterprise.enterprise_signatory._form.director'),
                'required' => true
            ])
                @slot('label')
                    @if (Auth::user()->enterprise->is($enterprise->signatories->first()))
                        @lang('enterprise.enterprise.job_title')
                    @else
                        {{ __('addworking.enterprise.enterprise_signatory._form.function_legal_representative') }}
                    @endif
                @endslot

                @slot('placeholder')
                    @lang('enterprise.enterprise.job_title_placeholder')
                @endslot
            @endcomponent
        </div>

        @if (!in_array($enterprise->legalForm->name, ['self_employed', 'ei', 'eirl']))
            <div class="col-md-6">
                @component('components.form.group', [
                    'name' => "signatory.representative",
                    'value' => $enterprise->users->get("{$enterprise->signatories->first()->id}.pivot.representative") ?: __('addworking.enterprise.enterprise_signatory._form.director'),
                    'required' => true
                ])
                    @slot('label')
                        @if (Auth::user()->enterprise->is($enterprise->signatories->first()))
                            @lang('enterprise.enterprise.representative')
                        @else
                            {{ __('addworking.enterprise.enterprise_signatory._form.quality_legal_representative') }}
                        @endif
                    @endslot

                    @slot('help')
                        @lang('enterprise.enterprise.help_representative')
                    @endslot

                    @slot('placeholder')
                        @lang('enterprise.enterprise.respresentative_placeholder')
                    @endslot
                @endcomponent
            </div>
        @endif
    </div>
@endcomponent
