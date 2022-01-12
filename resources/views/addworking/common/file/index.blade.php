@extends('foundation::layout.app.index')

@section('title', __('addworking.common.file.index.files'))

@section('toolbar')
    @button(__('addworking.common.file.index.add_file')."|href:".route('file.create')."|icon:plus|color:outline-success|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.file.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.file.index.files')."|active")
@endsection

@section('table.head')
    <th>{{ __('addworking.common.file.index.creation') }}</th>
    <th>{{ __('addworking.common.file.index.owner') }}</th>
    <th>{{ __('addworking.common.file.index.path') }}</th>
    <th>{{ __('addworking.common.file.index.type') }}</th>
    <th>{{ __('addworking.common.file.index.associated_to') }}</th>
    <th class="text-right">{{ __('addworking.common.file.index.cut') }}</th>
    <th class="text-right">{{ __('addworking.common.file.index.actions') }}</th>
@endsection

@section('table.filter')
    <td><input class="form-control form-control-sm" type="date" name="filter[created_at]" value="{{ request()->input('filter.created_at') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[owner]" value="{{ request()->input('filter.owner') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[path]" value="{{ request()->input('filter.path') }}"></td>
    <td>
        <select class="form-control form-control-sm" name="filter[mime_type]">
            <option></option>
            @foreach(config('mime-type') as $type => $type_array)
                <optgroup label="{{ $type }}">
                    @foreach ($type_array as $key => $value)
                        <option value="{{ $value }}" @if(request()->input('filter.mime_type') == $value) selected @endif>{{ $value }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </td>
    <td></td>
    <td></td>
    <td><button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button></td>
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @forelse ($items as $file)
        <tr>
            <td>@datetime($file->created_at)</td>
            <td>{{ $file->owner->views->link }}</td>
            <td>{{ str_max($file->path, 30) }}</td>
            <td>{{ str_max($file->mime_type, 15) }}</td>
            <td>{{ $file->associated ? $file->associated->views->link : 'n/a' }}</td>
            <td class="text-right">{{ human_filesize($file->size) }}</td>

            <td class="text-right">{{ $file->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">
                <div class="p-5">
                    <i class="fa fa-frown-o"></i> @lang('messages.empty')
                </div>
            </td>
        </tr>
    @endforelse
@endsection
