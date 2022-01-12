@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.invitation.relaunch_multiple', $enterprise)])

@section('title', "Relancer mes invitations")

@section('toolbar')
    @button("Retour|icon:arrow-left|color:secondary|outline|sm|mr:2|href:".route('addworking.enterprise.invitation.index', $enterprise))
@endsection

@section('breadcrumb')
    @breadcrumb_item("Tableau de bord|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item("Mes Invitations|href:".route('addworking.enterprise.invitation.index', $enterprise))
    @breadcrumb_item("Relancer mes invitations|active")
@endsection

@section('form')
    <header class="btn-toolbar justify-content-between my-4" role="toolbar">
        <div class="btn-group" role="group" aria-label="First group">
            <div class="input-group mr-3">
                <div class="input-group-append">
                    <div class="input-group-text rounded bg-light border-0"><b>{{ $items->total() }}</b>&nbsp;objets trouvés</div>
                </div>
            </div>
        </div>
    </header>
    <div class="mb-4">
        <button type="submit" class="btn btn-outline-success btn-sm" style="display: none" id="button-submit">
            @icon('redo-alt|mr-2') Relancer les invitations sélectionnées
        </button>
    </div>
    <div class="table-responsive" id="item-list">
        <table class="table table-hover">
            <colgroup>
                <col style="width: 5%">
                <col style="width: 50%">
                <col style="width: 15%">
                <col style="width: 15%">
                <col style="width: 15%">
            </colgroup>
            <thead>
                <td class="text-center"><input type="checkbox" id="select-all"></td>
                @th('Invité|not_allowed')
                @th('Email|not_allowed')
                @th('Statut|not_allowed|class:text-center')
                @th('Type|not_allowed|class:text-center')
            </thead>
            <tbody>
                @foreach ($items as $invitation)
                    <tr>
                        <td class="text-center"><input type="checkbox" name="invitation[id][]" value="{{ $invitation->id }}"></td>
                        <td>
                            @link($invitation->guest) de @link($invitation->guestEnterprise)<br>
                            <small class="text-muted">
                                <b>{{ $invitation->valid_until->isPast() ? 'A expiré' : 'Expire' }} {{ $invitation->valid_until->diffForHumans() }}</b>
                            </small>
                        </td>
                        <td>
                            <span class="text-secondary">{{ $invitation->contact }}</span>
                        </td>
                        <td class="text-center">
                            @include('addworking.enterprise.invitation._invitation_status')
                        </td>
                        <td class="text-center">
                            @include('addworking.enterprise.invitation._invitation_types')
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $items->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('[name=per-page]').change(function (event) {
                $(this).parents('form').first().submit();
            })
        })

        function checked_counter() {
            var count = $('#item-list input:checkbox:checked:not(#select-all)').length;
            $('#button-submit')[count == 0 ? 'hide': 'show']();
        }

        $(function () {
            $('#select-all').click(function () {
                $('#item-list input:checkbox').prop('checked', $(this).is(':checked'));
                checked_counter()
            });

            $('#item-list input:checkbox').change(checked_counter);
        })
     </script>
@endpush
