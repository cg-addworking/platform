<form action="{{route('sector.response.accept', [$response->getOffer(), $response])}}" method="POST">
    @csrf
    @method('POST')
    <div class="modal fade" id="close-offer-modal" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="close-offer-modal">{{ __('offer::response._close_offer_modal.accept') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{__('offer::response._close_offer_modal.sentence_one')  }} </p>
                    <p>{{__('offer::response._close_offer_modal.sentence_two')  }}  </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-default">
                        <i class="mr-2 fa fa-save"></i> {{ __('offer::response._close_offer_modal.accept') }}
                    </button>
                    <button type="submit" name="submit" class="btn btn-success" value="accept_close_offer">
                        <i class="mr-2 fa fa-save"></i> {{ __('offer::response._close_offer_modal.accept_close_offer') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>