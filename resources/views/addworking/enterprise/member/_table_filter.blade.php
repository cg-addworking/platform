<td>
    @form_control([
        'type'  => "text",
        'name'  => "filter.name",
        'class' => "form-control-sm",
        'value' => request()->input('filter.name'),
    ])
</td>

@can('readMemberRoles', $enterprise)
    <td>
        @form_control([
            'type'         => "select",
            'options'      => user()::getAvailableRoles(true),
            'value'        => request()->input('filter.roles'),
            'name'         => "filter.roles.",
            'class'        => "form-control-sm",
            'multiple'     => true,
            'selectpicker' => true,
        ])
    </td>
@endcan

@can('readMemberAccess', $enterprise)
    <td>
        @form_control([
            'type'         => "select",
            'options'      => user()::getAvailableAccess(true),
            'value'        => request()->input('filter.accesses'),
            'name'         => 'filter.accesses.',
            'class'        => "form-control-sm",
            'multiple'     => true,
            'selectpicker' => true,
        ])
    </td>
@endcan

<td>
    <button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button>
</td>
