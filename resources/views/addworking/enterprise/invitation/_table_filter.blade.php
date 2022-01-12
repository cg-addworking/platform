<td>
    @form_control([
        'type'  => "text",
        'name'  => "filter.invite",
        'class' => "form-control-sm",
        'value' => request()->input('filter.invite'),
    ])
</td>

<td>
    @form_control([
        'type'  => "text",
        'name'  => "filter.contact",
        'class' => "form-control-sm",
        'value' => request()->input('filter.contact'),
    ])
</td>

<td>
    @form_control([
        'type'  => "select",
        'options' => invitation()::getAvailableStatuses(true),
        'name'  => "filter.status",
        'class' => "form-control-sm",
        'value' => request()->input('filter.status'),
    ])
</td>

<td>
    @form_control([
        'type'  => "select",
        'options' => invitation()::getAvailableTypes(true),
        'name'  => "filter.type",
        'class' => "form-control-sm",
        'value' => request()->input('filter.type'),
    ])
</td>

<td>
    <button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button>
</td>
