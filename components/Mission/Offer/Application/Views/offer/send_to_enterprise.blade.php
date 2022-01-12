@inject('proposalRepository', "Components\Mission\Offer\Application\Repositories\ProposalRepository")
@inject('skillRepository', "Components\Mission\Offer\Application\Repositories\SkillRepository")

@extends('foundation::layout.app.show')

@section('title', __('offer::offer.send_to_enterprise.title').' '.$offer->getLabel())

@section('toolbar')
    @button(__('offer::offer.send_to_enterprise.return')."|href:".route('sector.offer.show', $offer)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('offer::offer._breadcrumb', ['page' => "send_to_enterprise"])
@endsection

@section('content')
    <form method="GET" class="mb-5">
        @form_group([
            'type'         => "select",
            'text'         => __('offer::offer.send_to_enterprise.skill'),
            'name'         => "filter.skills.",
            'value'        => request()->input('filter.skills', []),
            'options'      => $skills,
            'selectpicker' => true,
            'multiple'     => true,
            'search'       => true
        ])

        <div class="text-right">
            @if(request()->has('filter'))
                @button(__('offer::offer.send_to_enterprise.reset')."|href:".route('sector.offer.send_to_enterprise', $offer)."?reset|icon:trash-restore|color:danger|outline|sm")
            @endif
            @button(__('offer::offer.send_to_enterprise.search')."|icon:search|color:primary|outline|sm|type:submit")
        </div>
    </form>

    @if ($response_deadline_is_passed)
        <div class="modal fade" id="edit_response_deadline" tabindex="-1" role="dialog" aria-labelledby="editResponseDeadline" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> {{__('offer::offer.send_to_enterprise.edit_response_deadline')}} </h5>
                    </div>
                    <div class="modal-body">
                        <fieldset class="pt-2">
                            @form_group([
                                'text'        => __('offer::offer.send_to_enterprise.response_deadline'),
                                'type'        => "date",
                                'name'        => "offer.send_to_enterprise.response_deadline",
                                'id'          => 'modal_input_response_deadline',
                                'value'       => optional($offer)->getResponseDeadline(),
                            ])
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="modal_edit_response_deadline_send_button"> {{__('offer::offer.send_to_enterprise.record')}} </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form id="form" action="{{ route('sector.offer.send_to_enterprise.store', $offer) }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead>
                <th>{{ __('offer::offer.send_to_enterprise.vendor') }}</th>
                <th class="text-center">{{ __('offer::offer.send_to_enterprise.skills') }}</th>
                <th class="text-center">
                    <input name="test" type="checkbox" id="select-all">
                </th>
                </thead>
                <tbody>
                @forelse ($vendors as $vendor)
                    <tr>
                        <td><a href="{{ route('enterprise.show', $vendor) }}" target="_blank">{{ $vendor->name }}</a></td>
                        <td class="text-center">
                            @if($skillRepository->hasOfferSkills($vendor, $offer))
                                <i class="far fa-check-circle text-success" data-toggle="tooltip" data-placement="left" title="{{ __('offer::offer.send_to_enterprise.vendor_skills_ok_msg') }}"></i>
                            @else
                                <i class="far fa-times-circle text-danger" data-toggle="tooltip" data-placement="left" title="{{ __('offer::offer.send_to_enterprise.vendor_skills_no_ok_msg') }}"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($proposalRepository->hasProposalFor($offer,$vendor))
                                <b>{{ __('offer::offer.send_to_enterprise.sended') }}</b>
                            @else
                                <input name="offer[vendor][]" type="checkbox" value="{{ $vendor->id }}">
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            <div class="p-5">
                                <i class="fa fa-frown-o"></i> @lang('messages.empty')
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-outline-success">
                <i class="fas fa-share-alt mr-1"></i>
                {{ __('offer::offer.send_to_enterprise.submit') }}
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        var response_deadline_is_passed = '{{$response_deadline_is_passed}}';

        $("#select-all").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });

        $("#form").on('submit', function() {
            if ($('#select-all').is(':checked')) {
                $('#select-all').prop('checked', false);
            }
            if ($('input:checkbox').filter(':checked').length < 1){
                alert("Veuillez choisir au minimum 1 prestataire");
                return false;
            }

            if(confirm('Confirmer la diffusion ?')) {
                return true;
            }

            return false;
        });

        if (response_deadline_is_passed) {
                $('#edit_response_deadline').modal('show');
                var offer_id = '{{ $offer->id }}';

                $('#modal_edit_response_deadline_send_button').bind('click', function () {
                    var value = $('#modal_input_response_deadline').val();

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('sector.offer.set_response_deadline') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            response_deadline: value,
                            offer: offer_id,
                        },
                        success: function(response) {
                            $('#edit_response_deadline').modal('hide');
                            location.reload(true);
                        },
                    });
                });
            }
    </script>
@endpush