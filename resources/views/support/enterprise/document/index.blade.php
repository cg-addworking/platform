@extends('foundation::layout.app.index')

@section('title', "Documents")

@section('toolbar')
    @button("Retour|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button("Exporter|href:".route('support.enterprise.document.export')."?".http_build_query(request()->all())."|icon:download|color:primary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item('Support|href:'.route('dashboard') )
    @breadcrumb_item("Documents|active")
@endsection

@section('form')
    <div class="row" role="filter">
        <div class="col-md-4">
            @form_group([
                'text'     => "Type",
                'type'     => "select",
                'name'     => "filter.document_type.",
                'options'  => document_type()::options(),
                'value'    => request()->input('filter.document_type'),
                'search'   => true,
                'multiple' => true,
                'selectpicker' => true,
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Prestataire",
                'type'     => "text",
                'name'     => "filter.vendor",
                'value'    => request()->input('filter.vendor'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Déposé Avant",
                'type'     => "date",
                'name'     => "filter.created_before",
                'value'    => request()->input('filter.created_before'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Status",
                'type'     => "select",
                'name'     => "filter.status",
                'options'  => array_mirror(document()::getAvailableStatuses()),
                'value'    => request()->input('filter.status'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Client",
                'type'     => "select",
                'name'     => "filter.customer.",
                'options'  => enterprise([])->whereIsCustomer()->orderBy('name', 'asc')->pluck('name', 'id'),
                'value'    => request()->input('filter.customer'),
                'search'   => true,
                'multiple' => true,
                'selectpicker' => true,
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Déposé après",
                'type'     => "date",
                'name'     => "filter.created_after",
                'value'    => request()->input('filter.created_after'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Nature",
                'type'     => "select",
                'name'     => "filter.document_kind",
                'options'  => array_mirror(document_type()::getAvailableTypes()),
                'value'    => request()->input('filter.document_kind'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Propriétaire du document type",
                'type'     => "select",
                'name'     => "filter.type_owner",
                'options'  => enterprise([])->whereIsCustomer()->orderBy('name', 'asc')->pluck('name', 'id'),
                'value'    => request()->input('filter.type_owner'),
                'search'   => true,
                'multiple' => true,
                'selectpicker' => true,
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Prestataire sans client",
                'type'     => "select",
                'name'     => "filter.vendor_without_customer",
                'options'  => ['no' => 'Non', 'yes' => 'Oui'],
                'value'    => request()->input('filter.vendor_without_customer'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Document pré-validé",
                'type'     => "select",
                'name'     => "filter.is_pre_checked",
                'options'  => ['false' => 'Non', 'true' => 'Oui'],
                'value'    => request()->input('filter.is_pre_checked'),
            ])
        </div>
        <div class="col-12 text-right">
            @if (array_filter((array) request()->input('filter', [])))
                <a href="?reset" class="btn btn-outline-danger mr-3 rounded">@icon('times') Reinitialiser</a>
            @endif
        </div>
    </div>
@endsection

@section('table.colgroup')
@endsection

@section('table.head')
    <th>Création</th>
    <th>Prestataire</th>
    <th>Type</th>
    <th class="text-center">Status</th>
    <th>Action</th>
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @forelse ($items as $document)
        <tr>
            <td>@datetime($document->created_at)</td>
            <td>
                @if($document->enterprise->vendorIsInactiveForAllCustomers())
                    <span class="badge badge-pill badge-secondary mr-3" data-toggle="tooltip" data-placement="top" title="Ce prestataire est actuellement inactif">Inactif</span>
                @else
                    <span class="badge badge-pill badge-success mr-2" data-toggle="tooltip" data-placement="top" title="Ce prestataire est actuellement actif">Actif</span>
                @endif
                {{ $document->enterprise->views->link }}</td>
            <td>{{ $document->documentType->views->link }} ({{__("document.type.{$document->documentType->type}")}})</td>
            <td class="text-center">
                {{ $document->views->status }}
                @if(! is_null($document->signed_at))
                    <span class="badge badge-pill badge-success mr-3" data-toggle="tooltip" data-placement="top" title="Signer par {{ $document->getSignatoryName() }} le {{ date_iso_to_date_fr($document->signed_at) }}">Signé</span>
                @endif
            </td>
            <td>
               @if (isset($document, $document->routes->show) && (auth()->user()->can('show',$document) || auth()->user()->can('view',$document)))
                @button(__('addworking.enterprise.document.index.consult')."|href:{$document->routes->show}|icon:eye|color:primary|outline|sm|btn-sm")
               @endif
            </td>
            
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-5">
                Aucun résultat
            </td>
        </tr>
    @endforelse
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('[role=filter] :input').not('select[multiple]').change(function () {
                $(this).parents('form').first().submit();
            });

            $(document).on('changed.bs.select', '.bootstrap-select', function () {
                $(this).data('has-changed', true);
            })

            $(document).on('hidden.bs.select', '.bootstrap-select', function () {
                if ($(this).data('has-changed')) {
                    $(this).parents('form').first().submit();
                }
            });
        })
    </script>
@endpush
