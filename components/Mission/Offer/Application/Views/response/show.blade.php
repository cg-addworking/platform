@extends('foundation::layout.app.show')

@section('title', __('offer::response.show.title', ['label' => $response->getOffer()->getLabel()]))

@section('toolbar')
    @button(__('offer::response.show.return')."|href:".route('sector.response.index', $response->getOffer())."|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('accept', [$response, $response->getOffer()])
        <button type="button" class="btn btn-outline-success btn-sm mr-2" data-toggle="modal" data-target="#close-offer-modal">
            @icon('check|color:success|mr:1') {{ __('offer::response.show.accept') }}
        </button>
        @push('modals')
          @include('offer::response._close_offer_modal')
        @endpush
    @endcan
    
    @can('reject', [$response, $response->getOffer()])
        <button type="button" class="btn btn-outline-danger btn-sm mr-2" data-toggle="modal" data-target="#exampleModal">
            @icon('times|color:danger|mr:1') {{ __('offer::response.show.reject.reject') }}
        </button>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('offer::response.show.reject.confirm')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('sector.response.reject', [$response->getOffer(), $response])}}">
                @csrf
                  <div class="modal-body">
                    @form_group([
                        'class'       => 'col-md-12',
                        'type'        => "textarea",
                        'name'        => "content",
                        'required'    => false,
                        'text'        => __('offer::response.show.reject.comment'),
                        'rows'        => 10,
                    ])
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-2" data-dismiss="modal">{{ __('offer::response.show.reject.close') }}</button>
                    <button type="submit" class="btn btn-outline-success btn-sm mr-2">{{ __('offer::response.show.reject.submit') }}</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
    @endcan
@endsection

@section('breadcrumb')
    @include('offer::response._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @include('offer::response.construction._html')
@endsection