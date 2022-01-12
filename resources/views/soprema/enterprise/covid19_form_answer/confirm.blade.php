@extends('foundation::layout.app', ['_no_background' => true, '_no_shadow' => true, '_no_sidebar' => true, '_no_message' => true])

@section('main')
    <div class="row">
        <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-center" style="font-size: 250px">
                        @icon('thumbs-up|color:primary')
                    </div>
                    <h2 class="text-center text-primary mb-5">
                        {{ __('soprema.enterprise.covid19_form_answer.confirm.answer_saved') }}
                    </h2>

                    @button(__('soprema.enterprise.covid19_form_answer.confirm.back_to_home')."|class:btn-block|href:/")
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')
    <style>
        body {
            background: #007bff;
        }

        main footer {
            color: white;
        }

        main footer a {
            color: inherit;
        }
    </style>
@endpush
