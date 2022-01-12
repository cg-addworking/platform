<div class="checkbox">
    <label>
        <input
          id="{{ $id ?? uniqid('input_') }}"
          type="checkbox"
          name="{{ dot_to_input($name) }}"
          value="{{ $value ?? 1 }}"
          {{ attr_if(old($name) || isset($checked) && !old($name), 'checked') }}
        /> {{ $checkbox_label ?? "" }}
    </label>
</div>

