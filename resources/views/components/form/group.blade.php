@if (! function_exists('platform_form_group_attr'))
    @php
        function platform_form_group_attr(array $vars = [])
        {
            $attr  = [];
            $class = ['form-group'];

            if (isset($vars['errors'], $vars['name']) && $vars['errors']->has(rtrim($vars['name'], '.'))) {
                $class[] = 'has-error';
            }

            if (isset($vars['class'])) {
                $class = array_merge($class, (array) $vars['class']);
            }

            if (isset($vars['shownif'])) {
                $attr['data-shown-if'] = $vars['shownif'];
            }

            $attr['class'] = implode(' ', $class);

            return attr($attr);
        }
    @endphp
@endif

@if (! function_exists('platform_form_group_label_attr'))
    @php
        function platform_form_group_label_attr(array $vars = [])
        {
            $class = ['control-label'];

            if (! empty($vars['horizontal'])) {
                $class[] = 'col-md-4';
            }

            $attr  = [
                'for'   => $vars['id'] ?? uniqid('field_'),
                'class' => implode(' ', $class),
            ];

            return attr($attr);
        }
    @endphp
@endif

@if (!empty($value) && $value instanceof Illuminate\Database\Eloquent\Model)
    @php
        $value = $value->exists ? $value->id : null;
    @endphp
@endif

<div {{ platform_form_group_attr(get_defined_vars()) }}>
    @if (!empty($text) || !empty($label))
        <label {{ platform_form_group_label_attr(get_defined_vars()) }}>
            @if (!empty($required))
                <span @tooltip(__('components.form.group.required_field'))>
            @endif

            {{ $text ?? $label ?? '' }}

            @if (isset($help))
                @component('components.button.help', ['direction' => "bottom"])
                    {{ $help }}
                @endcomponent
            @endif

            @if (!empty($required))
                <sup class="text-danger">*</sup>
                </span>
            @endif
        </label>
    @endif

    @if (!empty($horizontal))
        <div class="col-md-8">
    @endif

    @if (isset($slot) && trim($slot))
        {{ $slot }}
    @else
        @include('components.form.control')
    @endif

    @if (isset($errors) && $errors->has(rtrim($name, '.')))
        <span class="help-block">
            <strong>{{ $errors->first(rtrim($name, '.')) }}</strong>
        </span>
    @endif

    @if (!empty($horizontal))
        </div>
    @endif
</div>
