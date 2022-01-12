@extends('foundation::layout.app.edit', ['action' => route('addworking.common.enterprise.passwork.update', [$enterprise, $passwork])])

@section('title', __('addworking.common.passwork.edit.edit_passwork')." {$passwork->customer->name}");

@section('toolbar')
    @button(__('addworking.common.passwork.edit.return')."|href:".route('addworking.common.enterprise.passwork.show', [$enterprise, $passwork])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.passwork.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.passwork.edit.enterprises').'|href:'.route('enterprise.index') )
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.common.passwork.edit.passwork').'|href:'.route('addworking.common.enterprise.passwork.index', $enterprise) )
    @breadcrumb_item($passwork->customer->name .'|href:'.route('addworking.common.enterprise.passwork.show', [$enterprise, $passwork]) )
    @breadcrumb_item(__('addworking.common.passwork.edit.edit')."|active")
@endsection

@section('form')
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('addworking.common.passwork.edit.job') }}</th>
                <th>{{ __('addworking.common.passwork.edit.skill') }}</th>
                <th>{{ __('addworking.common.passwork.edit.level') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
                @foreach ($job->skills as $skill)
                    <tr>
                        @if ($loop->first)
                            <td rowspan="{{ count($job->skills) }}">{{ $job->display_name }}</td>
                        @endif
                        <td>{{ $skill->display_name }}</td>
                        <td>
                            <select name="skill[{{ $skill->id }}][level]" class="form-control">
                                <option @if(! $passwork->hasSkill($skill)) selected @endif></option>
                                <option value="1" @if($passwork->getLevelFor($skill) == 1) selected @endif>{{ __('addworking.common.passwork.edit.beginner') }}</option>
                                <option value="2" @if($passwork->getLevelFor($skill) == 2) selected @endif>{{ __('addworking.common.passwork.edit.intermediate') }}</option>
                                <option value="3" @if($passwork->getLevelFor($skill) == 3) selected @endif>{{ __('addworking.common.passwork.edit.advance') }}</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="text-right my-5">
        @button(__('addworking.common.passwork.edit.register')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
