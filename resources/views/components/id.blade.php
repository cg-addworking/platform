<abbr title="UUID" data-toggle="popover" data-html="true" data-content="<pre>{{ $slot ?? 'n/a' }}</pre>" class="id">
    {{ substr($slot ?? 'n/a', 0, 8) }}
</abbr>
