@if ($file->isPdf())
    <div class="embed-responsive embed-responsive-{{ $ratio ?? "16by9" }}">
        <iframe class="embed-responsive-item" src="{{ $file->common_url }}" frameborder="0"></iframe>
    </div>
@elseif($file->isImage())
    <img src="{{ $file->common_url }}" style="max-width:100%">
@elseif($file->isHtml())
    <pre><code>{{ $file->content }}</code></pre>
@else
    @include('addworking.common.file._download')
@endif
