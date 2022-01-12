<div>
    @if (isset($class) && $class == "stacked")
        <div class="row"><div class="col-md-3">
    @endif

    @if (isset($class) && $class == "pills")
        @component('components.panel')
    @endif

    <ul class="nav nav-{{ $class ?? 'tabs' }}" role="tablist">
        @foreach ($tabs as $id => $name)
            <li role="presentation" {!! attr('class', $loop->first ? "active" : "") !!}>
                <a href="#{{ $id }}" aria-controls="{{ $id }}" role="tab" data-toggle="tab">
                    @if (is_string($name))
                        {{ $name }}
                    @elseif (isset($name['html']))
                        {!! $name['html'] !!}
                    @else
                        @if (isset($name['icon']))
                            <i class="mr-2 fa fa-fw fa-{{ $name['icon'] }}"></i>
                        @endif

                        {{ $name['name'] }}

                        @if (isset($name['badge']))
                            <span class="badge">{{ $name['badge'] }}</span>
                        @endif
                    @endif
                </a>
            </li>
        @endforeach
    </ul>

    @if (isset($class) && $class == "pills")
        @endcomponent
    @endif

    @if (isset($class) && $class == "stacked")
        </div><div class="col-md-9">
    @endif

    <div class="tab-content">
        @foreach ($tabs as $id => $name)
            <div role="tabpanel" class="mt-3 tab-pane fade {{ $loop->first ? 'in active' : '' }}" id="{{ $id }}">
                {{ $$id }}
            </div>
        @endforeach
    </div>

    @if (isset($class) && $class == "stacked")
        </div></div>
    @endif
</div>
