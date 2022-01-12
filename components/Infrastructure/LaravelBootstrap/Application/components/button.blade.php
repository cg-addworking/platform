@if(isset($href) && (!isset($method) || strtoupper($method) == 'GET'))
    <a role="button" @attr('button_attr')>
        @isset($icon)@icon($icon)@endif {{ $text ?? $slot ?? '' }}
    </a>
@elseif(isset($href, $method))
    <form action="{{ $href ?? '' }}" method="POST" style="display:inline">
        @method($method)
        @csrf
        @php
            unset($href);
        @endphp
        <button @attr('button_attr')>
            @isset($icon)@icon($icon)@endif {{ $text ?? $slot ?? '' }}
        </button>
    </form>
@else
    <button @attr('button_attr')>
        @isset($icon)@icon($icon)@endif {{ $text ?? $slot ?? '' }}
    </button>
@endif
