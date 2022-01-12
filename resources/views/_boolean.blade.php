@switch ($var)
    @case (1)
        <span class="text-success">
            <i class="fa fa-fw fa-check"></i>
        </span>
        @break
    @case (0)
        <span class="text-danger">
            <i class="fa fa-fw fa-times"></i>
        </span>
        @break
    @default
        <span class="text-muted" @tooltip("Non Spécifié")>
            <i class="fa fa-fw fa-question"></i>
        </span>
        @break
@endswitch
