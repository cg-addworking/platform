@inject('repo', 'App\Repositories\Addworking\Contract\ContractRepository')

@extends('foundation::layout.app.show')

@section('title', "{$contract}")

@section('toolbar')
    @button(__('addworking.contract.contract.show.return')."|href:{$contract->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('tabs')
    @component('bootstrap::tab', ['name' => "info", 'active' => true])
        Contrat
    @endcomponent

    @component('bootstrap::tab', ['name' => "signatories"])
        Signataires <span class="badge badge-light">{{ $contract->contractParties()->count() }}</span>
    @endcomponent

    @component('bootstrap::tab', ['name' => "documents"])
        Documents <span class="badge badge-light">{{ $contract->contractDocuments()->count() }}</span>
    @endcomponent

    @component('bootstrap::tab', ['name' => "addendums"])
        Avenants <span class="badge badge-light">{{ $contract->children()->count() }}</span>
    @endcomponent

    {{--
    @component('bootstrap::tab', ['name' => "annexes"])
        Annexes <span class="badge badge-light">{{ $contract->contractAnnexes()->count() }}</span>
    @endcomponent

    @component('bootstrap::tab', ['name' => "addendums"])
        Avenants <span class="badge badge-light">{{ 0 }}</span>
    @endcomponent

    @component('bootstrap::tab', ['name' => "variables"])
        Variables <span class="badge badge-light">{{ $contract->contractVariables()->count() }}</span>
    @endcomponent
    --}}
@endsection

@section('content')
    @component('bootstrap::tab.pane', ['name' => "info", 'active' => true])
        <div class="row">
            <div class="col-md-9 mb-3">
                <div class="card shadow">
                    <div class="card-body">
                        {{ $contract->file->views->iframe }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @can('viewSummary', $contract)
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            {{ $contract->views->summary }}
                        </div>
                    </div>
                @endcan

                <div class="card shadow">
                    <div class="card-body">
                        {{ $contract->views->html }}
                    </div>
                </div>
            </div>
        </div>
    @endcomponent

    @component('bootstrap::tab.pane', ['name' => "signatories"])
        <table class="table">
            <thead>
                <tr>
                    {{ $contract->contractParties()->make()->views->table_head }}
                </tr>
            </thead>
            <tbody>
                @forelse ($contract->contractParties as $contract_template_party)
                    @can('view', $contract_template_party)
                        {{ $contract_template_party->views->table_row }}
                    @endcan
                @empty
                    {{ $contract->contractParties()->make()->views->table_row_empty }}
                @endforelse
            </tbody>
        </table>
    @endcomponent

    @component('bootstrap::tab.pane', ['name' => "documents"])
        <table class="table">
            <thead>
                <tr>
                    {{ $contract->contractDocuments()->make()->views->table_head }}
                </tr>
            </thead>
            <tbody>
                @forelse ($contract->contractDocuments as $contract_document)
                    @can('view', $contract_document)
                        {{ $contract_document->views->table_row }}
                    @endcan
                @empty
                    {{ $contract->contractDocuments()->make()->views->table_row_empty }}
                @endforelse
            </tbody>
        </table>
    @endcomponent

    @component('bootstrap::tab.pane', ['name' => "addendums"])
        {{ $contract->views->addendums }}
    @endcomponent

    {{--
    @component('bootstrap::tab.pane', ['name' => "annexes"])
    @endcomponent

    @component('bootstrap::tab.pane', ['name' => "addendums"])
    @endcomponent

    @component('bootstrap::tab.pane', ['name' => "variables"])
    @endcomponent
    --}}
@endsection
