<div @attr('dropdown_attr')>
    <button @attr('button_attr') type="button" id="{{ $id = uniqid('dropdown_menu_button_') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $text ?? '' }} @icon('caret-down')
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
        {{ $slot }}
    </div>
</div>
