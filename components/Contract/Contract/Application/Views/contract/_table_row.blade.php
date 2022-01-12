@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')
@inject('enterpriseRepository', 'Components\Contract\Contract\Application\Repositories\EnterpriseRepository')

<tr>
    <td>{{ $contract->getNumber() }}</td>
    <td><a href="{{ route('contract.show', $contract) }}">{{ $contract->getName()}}</a>@if($contract->getExternalIdentifier()) {{' ('.$contract->getExternalIdentifier().')'}} @endif</td>
    @if (! Auth::user()->isSupport())
        <td>
            @if(! is_null($contract->getCreatedBy()) && ! $contract->getCreatedBy()->isSupport()
                && Auth::user()->enterprise->id !== $contract->getEnterprise()
            )
                {{ $contract->getCreatedBy()->getNameAttribute() }}</a>
            @else
                N/A
            @endif
        </td>
    @else
        <td>
            @if(! is_null($contract->getContractModel()))
                <a href="{{ route('support.contract.model.show', $contract->getContractModel()) }}" target="_blank">{{ $contract->getContractModel()->name}} </a>
            @else
                N/A
            @endif
        </td>
    @endif
    <td>{{ $contract->getEnterprise()->views->link ?? "n/a"}}</td>
    <td>
        @forelse ($contractRepository->getPartiesWithoutOwner($contract) as $party)
            {{ $party->getEnterprise()->views->link }}
            @if (! $loop->last)
                ,
            @endif
        @empty
            n/a
        @endforelse
    </td>
    <td>@include('contract::contract._state')</td>
    @if (! Auth::user()->isSupport())
        <td>
            @if (! is_null($contract->getMission()))
                @money($contract->getMission()->getAmount())
            @else
                n/a
            @endif
        </td>
    @endif
    <td>@date($contract->getValidFrom())</td>
    <td>@date($contractRepository->getValidUntilDate($contract))</td>
    <td class="text-right">
        @include('common::lazy_loading._actions', [
                'action_path' => 'contract::contract._actions',
                'action_objects' => json_encode(
                    [
                        'contract' => [
                            'id' => $contract->getId(),
                            'model' => get_class($contract),
                        ]
                    ]
                )
            ])
    </td>
</tr>
