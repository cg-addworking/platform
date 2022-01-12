@if (session('status'))
    @push('scripts-stack')
        @if (is_array(session('status')))
            <script>toastr['{{ str_replace('danger', 'error', array_get(session('status'), 'class', 'info')) }}']('{!! array_get(session('status'), 'message') !!}')</script>
        @else
            <script>toastr["info"]('{!! session('status') !!}')</script>
        @endif
    @endpush
@endif
