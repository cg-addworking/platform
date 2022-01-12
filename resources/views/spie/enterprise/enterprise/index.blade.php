@extends('foundation::layout.app.index')

@section('title', "Panel sous traitants Spie")

@section('toolbar')
    @button("Retour|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item('Spie|href:'.route('dashboard') )
    @breadcrumb_item("Entreprises|active")
@endsection

@section('form')
    <div class="row" role="filter">
        <div class="col-md-4">
            @form_group([
                'text'     => "Code",
                'type'     => "text",
                'name'     => "filter[code]",
                'value'    => request()->input('filter.code')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Société",
                'type'     => "text",
                'name'     => "filter[name]",
                'value'    => request()->input('filter.name')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Groupe",
                'type'     => "select",
                'options'  => spie_enterprise()::getAvailableGroups(request('filter', [])),
                'name'     => "filter[group]",
                'value'    => request()->input('filter.group')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Activités",
                'type'     => "select",
                'options'  => array_mirror(spie_enterprise()::getAvailableActivities(request('filter', []))),
                'name'     => "filter[activity]",
                'value'    => request()->input('filter.activity')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Ville",
                'type'     => "select",
                'options'  => array_mirror(spie_enterprise()::getAvailableTowns(request('filter', []))),
                'name'     => "filter[town]",
                'value'    => request()->input('filter.town')
            ])
        </div>
        <div class="col-md-4" id="select-coverage-zones">
            @component('bootstrap::form.group', ['text' => "Zone d'intervention"])
                <select name="filter[department][]" class="selectpicker form-control shadow-sm" multiple data-live-search="true" data-actions-box="true">
                    @foreach (region()::optionsWithDepartments() as $region => $departments)
                        <optgroup label="{{ $region }}">
                            @foreach ($departments as $id => $name)
                                <option value="{{ $id }}" data-tokens="{{ $region }}" @if (in_array($id, request()->input('filter.department', []))) selected @endif>{{ $name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            @endcomponent
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Qualifications",
                'type'     => "select",
                'options'  => spie_qualification()::options(request('filter', [])),
                'name'     => "filter[qualification]",
                'value'    => request()->input('filter.qualification')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Chiffre d'affaires",
                'type'     => "select",
                'options'  => array_mirror([
                    'moins de 1000€',
                    'entre 1000€ et 10K€',
                    'entre 10K€ et 50K€',
                    'entre 50K€ et 100K€',
                    'entre 100K€ et 200K€',
                    'entre 200K€ et 500K€',
                    'plus de 500K€',
                ]),
                'name'     => "filter[order]",
                'value'    => request()->input('filter.order')
            ])
        </div>
        <div class="col-md-4">
            @form_group([
                'text'     => "Actif",
                'type'     => "select",
                'options'  => ['true' => "Actif", 'false' => "Inactif"],
                'name'     => "filter[active]",
                'value'    => request()->input('filter.active')
            ])
        </div>
    </div>
@endsection

@section('table.colgroup')
    <col style="width:5%">
    <col style="width:5%">
    <col style="width:15%">
    <col style="width:10%">
    <col style="width:15%">
    <col style="width:10%">
    <col style="width:10%">
    <col style="width:10%">
    <col style="width:10%">
@endsection

@section('table.head')
    @th("Code|column:code")
    @th("Actif|column:active|class:text-center")
    @th("Société|column:name")
    @th("Groupe|column:group")
    @th("Activités|not_allowed")
    @th("Ville|column:city")
    @component('foundation::layout.app._table_head_cell', ['not_allowed' => true])
        <abbr title="Zone d'Intervention">Zones.</abbr>
    @endcomponent
    @component('foundation::layout.app._table_head_cell', ['not_allowed' => true])
        <abbr title="Habilitations / Qualifications">Qual.</abbr>
    @endcomponent
    @th("CA ".date('Y')."|not_allowed|class:text-right")
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @forelse ($items as $enterprise)
        <tr>
            <td>{{ $enterprise->code }}</td>
            <td class="text-center">@if ($enterprise->active) @icon('check|color:success') @else @icon('times|color:danger') @endif</td>
            <td><a href="{{ $enterprise->enterprise->routes->show }}">{{ $enterprise->name }}</a></td>
            <td>@include('spie.enterprise.enterprise._parent')</td>
            <td>@include('spie.enterprise.enterprise._activities')</td>
            <td>{{ ucwords(strtolower(optional($enterprise->enterprise)->registration_town)) }}</td>
            <td>@include('spie.enterprise.enterprise._coverage_zones')</td>
            <td>@include('spie.enterprise.enterprise._qualifications')</td>
            <td class="text-right">@money(optional($enterprise->orders()->where('year', date('Y'))->first())->amount)</td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center py-5">
                Aucun résultat
            </td>
        </tr>
    @endforelse
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            var submit_form = function () {
                $(this).parents('form').first().submit();
            };

            $('[role=filter] :input').not('select[multiple]').change(submit_form);

            $(document).on('changed.bs.select', '#select-coverage-zones .bootstrap-select', function () {
                $(this).data('has-changed', true);
            })

            $(document).on('hidden.bs.select', '#select-coverage-zones .bootstrap-select', function () {
                if ($(this).data('has-changed')) {
                    submit_form.call(this);
                }
            });
        })
    </script>
@endpush
