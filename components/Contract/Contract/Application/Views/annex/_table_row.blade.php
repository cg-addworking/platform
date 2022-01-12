<tr>
    <td>{{ $annex->getNumber() }}</td>
    <td>{{ $annex->getName()}}</td>
    <td>
        @if(strlen($annex->getDescription()) > 50)
            {{ substr($annex->getDescription(), 0, 50) }} ...
            <a href="#" tabindex="0" data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="{{ $annex->getDescription() }}">Voir plus</a>
        @else
            {{ $annex->getDescription() }}
        @endif
    </td>
    <td>@date($annex->getCreatedAt())</td>
    <td><a href="{{route('file.show', $annex->getFile())}}" target="_blank">{{$annex->getFile()->name}}</a></td>
    <td class="text-right"> @include('contract::annex._actions') </td>
</tr>
