@if(empty($not_allowed) && isset($column))
    <th @attr(['class' => $class ?? ''])>
        <button type="submit" name="sort-by[{{ $column }}]" value="{{ request()->input("sort-by.{$column}") == 'desc' ? 'asc' : 'desc' }}" class="btn btn-link p-0 btn-sm font-weight-bold text-dark">
            @if (request()->input("sort-by.{$column}") == 'asc')
                @icon('caret-down')
            @elseif (request()->input("sort-by.{$column}") == 'desc')
                @icon('caret-up')
            @endif
            {{ $text ?? $slot ?? '' }}
        </button>
    </th>
@else
    <th style="cursor: not-allowed" @attr(['class' => $class ?? ''])>{{ $text ?? $slot ?? '' }}</th>
@endempty
