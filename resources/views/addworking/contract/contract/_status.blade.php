<span class="@if(Repository::contract()->isPositiveStatus($contract)) text-success @elseif(Repository::contract()->isNegativeStatus($contract)) text-danger @elseif(Repository::contract()->isNeutralStatus($contract)) text-muted @endif">
    {{ ucfirst(Repository::contract()->getStatus($contract, true)) }}
</span>
