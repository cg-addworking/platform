<table class="table">
    <thead>
        <tr>
            {{ $contract->views->table_head }}
        </tr>
    </thead>
    <tbody>
        @forelse ($contract->children()->cursor() as $contract_addendum)
            @can('view', $contract_addendum)
                {{ $contract_addendum->views->table_row }}
            @endcan
        @empty
            {{ $contract->children()->make()->views->table_row_empty }}
        @endforelse
    </tbody>
</table>
