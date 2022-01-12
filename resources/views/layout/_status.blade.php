@php
    $class   = array_get(session('status'), 'class', 'primary');
    $message = is_array(session('status')) ? array_get(session('status'), 'message', '') : session('status');
    $info    = ['primary' => __('layout._status.notice'), 'danger' => __('layout._status.danger'), 'warning' => __('layout._status.attention'), 'success' => __('layout._status.success')][$class] ?? __('layout._status.notice');
@endphp

<div class="alert alert-{{$class }} alert-dismissible fade show mt-3" role="alert">
    <strong>{{ $info }}</strong> {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
