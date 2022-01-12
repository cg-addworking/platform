<tr>
    <td>{{ $export->getName() }}</td>
    <td>@include('export::export._status')</td>
    <td>{{ $exportRepository->displayFilters($export->getFilters())}}</td>
    <td>{{ date($export->getFinishedAt()) }}</td>
    <td>{{ date($export->getCreatedAt()) }}</td>
    <td class="text-right">
        @if($exportRepository->isGenerated($export))
            @can('download', $export)
                @button(__('common.infrastructure.export.application.views.export._actions.download')."|href:".route('infrastructure.export.download', $export)."|icon:file-export|color:outline-primary|outline|sm")
            @endcan
        @endif
    </td>
</tr>
