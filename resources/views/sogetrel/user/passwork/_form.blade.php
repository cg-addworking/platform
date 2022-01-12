@component('components.form.wizard')
    @slot('nav')
        @component('components.form.wizard_nav', ['target' => "tab1", 'active' => true])
            {{ __('sogetrel.user.passwork._form.page1') }}

            @slot('description')
                {{ __('sogetrel.user.passwork._form.page1_desc') }}
            @endslot
        @endcomponent

        @component('components.form.wizard_nav', ['target' => "tab2"])
            {{ __('sogetrel.user.passwork._form.page2') }}

            @slot('description')
                {{ __('sogetrel.user.passwork._form.page2_desc') }}
            @endslot
        @endcomponent

        @component('components.form.wizard_nav', ['target' => "tab3"])
            {{ __('sogetrel.user.passwork._form.page3') }}

            @slot('description')
                {{ __('sogetrel.user.passwork._form.page3_desc') }}
            @endslot
        @endcomponent

        @component('components.form.wizard_nav', ['target' => "tab4"])
            {{ __('sogetrel.user.passwork._form.page4') }}

            @slot('description')
                {{ __('sogetrel.user.passwork._form.page4_desc') }}
            @endslot
        @endcomponent
    @endslot

    @component('components.form.wizard_tab', ['id' => "tab1", 'show' => true])
        @include('sogetrel.user.passwork._tab1')

        <hr>

        <div class="text-right">
            <button data-toggle="wizard" data-target="#tab2" class="btn btn-success">
                <i class="fa fa-arrow-right fa-fw mr-2"></i> {{ __('sogetrel.user.passwork._form.next') }}
            </button>
        </div>
    @endcomponent

    @component('components.form.wizard_tab', ['id' => "tab2"])
        @include('sogetrel.user.passwork._tab2')

        <hr>

        <div class="row mb-0">
            <div class="col-md-6">
                <button data-toggle="wizard" data-target="#tab1" class="btn btn-primary">
                    <i class="fa fa-arrow-left fa-fw mr-2"></i> {{ __('sogetrel.user.passwork._form.prev') }}
                </button>
            </div>
            <div class="col-md-6 text-right">
                <button data-toggle="wizard" data-target="#tab3" class="btn btn-success">
                    <i class="fa fa-arrow-right fa-fw mr-2"></i> {{ __('sogetrel.user.passwork._form.next') }}
                </button>
            </div>
        </div>
    @endcomponent

    @component('components.form.wizard_tab', ['id' => 'tab3'])
        @include('sogetrel.user.passwork._tab3')

        <hr>

        <div class="row mb-0">
            <div class="col-md-6">
                <button data-toggle="wizard" data-target="#tab2" class="btn btn-primary">
                    <i class="fa fa-arrow-left fa-fw mr-2"></i> {{ __('sogetrel.user.passwork._form.prev') }}
                </button>
            </div>
            <div class="col-md-6 text-right">
                <button data-toggle="wizard" data-target="#tab4" class="btn btn-success">
                    <i class="fa fa-arrow-right fa-fw mr-2"></i> {{ __('sogetrel.user.passwork._form.next') }}
                </button>
            </div>
        </div>
    @endcomponent

    @component('components.form.wizard_tab', ['id' => "tab4"])
        @include('sogetrel.user.passwork._tab4')

        <hr>

        <div class="row mb-0">
            <div class="col-md-6">
                <button data-toggle="wizard" data-target="#tab3" class="btn btn-primary">
                    <i class="fa fa-arrow-left fa-fw mr-2"></i> {{ __('sogetrel.user.passwork._form.prev') }}
                </button>
            </div>
            <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check fa-fw mr-2"></i> {{ __('sogetrel.user.passwork._form.save') }}
                </button>
            </div>
        </div>
    @endcomponent
@endcomponent
