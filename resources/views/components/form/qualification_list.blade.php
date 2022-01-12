@forelse ($values ?? [] as $opt_value => $opt_name)
<div class="qualification_section">
	<b>{{$opt_name}}</b> - 
	<input type="radio" name="qualification[{{$opt_name}}]['compliance']" value="non" required/>{{ __('components.form.qualification_list.no') }}
	<input type="radio" name="qualification[{{$opt_name}}]['compliance']" value="pending"/>{{ __('components.form.qualification_list.being_obtained') }}
	<input type="radio" name="qualification[{{$opt_name}}]['compliance']" value="probationary_yes"/> {{ __('components.form.qualification_list.yes_probative') }}  
	<input type="radio" name="qualification[{{$opt_name}}]['compliance']" value="yes"/> {{ __('components.form.qualification_list.yes') }} 
	<div class="file_upload" style="display:none;">
		@include('components.form.group', ['type' => "file", 'name' => "qualification[file_id][$opt_name]"])
	</div> 
</div>
@empty
<li class="list-group-item">@lang('messages.empty')</li>
@endforelse

<br/>
