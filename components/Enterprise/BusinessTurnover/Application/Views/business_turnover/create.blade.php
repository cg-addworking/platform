@extends('foundation::layout.app.create', ['action' => route('business_turnover.store'), 'enctype' => "multipart/form-data"])

@section('title', __('business_turnover::business_turnover.create.title'))

@section('breadcrumb')
    @include('business_turnover::business_turnover._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <div class="alert alert-info" role="alert">

            {{__('business_turnover::business_turnover.create.alert_sentence_1')}}<br/>
            {{__('business_turnover::business_turnover.create.alert_sentence_2')}}<br/><br/>
            {{__('business_turnover::business_turnover.create.alert_sentence_3')}}<br/>
            {{__('business_turnover::business_turnover.create.alert_sentence_4')}}<br/><br/>
            {{__('business_turnover::business_turnover.create.alert_sentence_5')}}

    </div>
    @include('business_turnover::business_turnover._form', ['page' => "create"])

    <button class="btn btn-success shadow submit-business-turnover" disabled>
        @icon('check') {{ __('business_turnover::business_turnover.create.create') }}
    </button>

    @can('skip', $business_turnover)
        ou <a href="{{route('business_turnover.skip')}}">
            {{ __('business_turnover::business_turnover.create.skip') }}
        </a>
    @endcan
@endsection

@push('scripts')
    <script>
        $(".submit-business-turnover").on('click', function () {
            if(! confirm("{{__('business_turnover::business_turnover.create.confirm_data_exactitude')}}")) {
                return false;
            }
        });
    </script>
@endpush

