<form action="{{route('enterprise.offer.assign.store', [$enterprise, $offer, $vendor])}}" method="POST">
    <div class="modal fade" id="assign-modal-{{$vendor->id}}" tabindex="-1" aria-labelledby="assign-modal-label-{{$vendor->id}}" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="assign-modal-label-{{$vendor->id}}">{{__('addworking.mission.offer.assign_modal.title')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                        @csrf
                        @method('POST')
                        @form_group([
                            'text'  => __('addworking.mission.offer.assign_modal.close_offer'),
                            'type'  => "checkbox",
                            'name'  => "close_offer",
                            'value' => 1,
                            'selected' => 'selected'
                        ])
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="mr-2 fa fa-save"></i> {{ __('addworking.mission.offer.assign_modal.register') }}
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__('addworking.mission.offer.assign_modal.close')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>
