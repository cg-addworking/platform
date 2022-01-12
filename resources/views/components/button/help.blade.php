@if (! function_exists('button_help_attr'))
    @php
        function button_help_attr(array $vars = [])
        {
            $class = ['btn', 'btn-xs', 'btn-default', 'help'];

            if (isset($vars['class'])) {
                $class = array_merge($class, (array) $class);
            }

            $attr  = [
                'class'          => implode(' ', $class),
                'title'          => __('messages.help'),
                'type'           => "button",
                'data-toggle'    => "popover",
                'data-placement' => $vars['direction'] ?? "right",
                'data-trigger'   => $vars['trigger']   ?? "focus",
                'data-content'   => $vars['slot']      ?? 'n/a',
            ];

            return attr($attr);
        }
    @endphp
@endif

<button {{ button_help_attr(get_defined_vars()) }}><i class="fa fa-fw fa-{{ $icon ?? 'question' }}"></i></button>
