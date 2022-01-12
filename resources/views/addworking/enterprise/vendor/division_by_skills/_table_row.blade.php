@inject('passworkRepository', 'App\Repositories\Addworking\Common\PassworkRepository')

<tr>
    <td>{{ $skill->display_name }}</td>
    <td>{{ $skill->job->display_name }}</td>
    <td>
        <button class="btn btn-sm" type="button" data-toggle="collapse" aria-expanded="false" aria-controls="{{ $collapse = uniqid('collapse_') }}" data-target="{{ "#".$collapse }}">
            <span>@icon('caret-down'){{ count($passworkRepository->getVendorsPassworksBySkill($enterprise, $skill)) }}</span>
        </button>
        <div class="collapse" id="{{ $collapse }}">
            <ul style="list-style-type: none;">
                @foreach($passworkRepository->getVendorsPassworksBySkill($enterprise, $skill) as $passwork)
                    <li><a href="{{ route('enterprise.show', $passwork->vendor) }}" target="_blank"> {{ $passwork->vendor->name }} </a></li>
                @endforeach
            </ul>
        </div>
    </td>
</tr>
