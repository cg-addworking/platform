@extends('addworking.common.file.create')

@section('title')
    {{ __('sogetrel.user.passwork.create_file.add_file_to_passwork') }}
@endsection

@section('form.hidden')
    <input type="hidden" name="file[attachable_id]" value="{{ $passwork->id }}">
    <input type="hidden" name="file[attachable_type]" value="sogetrel_passwork">
    <input type="hidden" name="file[return-to]" value="{{ route('sogetrel.passwork.show', $passwork->id) }}">
@endsection
