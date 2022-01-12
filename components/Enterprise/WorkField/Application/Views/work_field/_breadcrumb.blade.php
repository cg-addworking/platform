@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('work_field::workfield._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('work_field::workfield._breadcrumb.index')."|href:".route('work_field.index'))
        @breadcrumb_item(__('work_field::workfield._breadcrumb.create')."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('work_field::workfield._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('work_field::workfield._breadcrumb.index')."|href:".route('work_field.index'))
        @breadcrumb_item($work_field->getDisplayName()."|href:".route('work_field.show', $work_field))
        @breadcrumb_item(__('work_field::workfield._breadcrumb.edit')."|active")
    @break
    
    @case('show')
        @breadcrumb_item(__('work_field::workfield._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('work_field::workfield._breadcrumb.index')."|href:".route('work_field.index'))
        @breadcrumb_item($data['display_name']."|active")
    @break

    @case('manageContributors')
        @breadcrumb_item(__('work_field::workfield._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('work_field::workfield._breadcrumb.index')."|href:".route('work_field.index'))
        @breadcrumb_item($work_field->getDisplayName()."|href:".route('work_field.show', $work_field))
        @breadcrumb_item(__('work_field::workfield._breadcrumb.manage_contributors')."|active")
    @break

    @default
        @breadcrumb_item(__('work_field::workfield._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('work_field::workfield._breadcrumb.index')."|active")
@endswitch
