
<span @attr('boolean_attr')>
    @switch ($value)
        @case (1)
            @icon('check')
            @break
        @case (0)
            @icon('times')
            @break
        @default
            @icon('question')
            @break
    @endswitch
</span>
