<div class="input-group date" data-provide="datepicker" data-date-format="{{ $format ?? 'dd/mm/yyyy' }}">
    @include('components.form.input', ['type' => "text", 'value' => ($value ?? null) instanceof DateTime ? $value->format('d/m/Y') : ($value ?? null)])
    <div class="input-group-addon">
        <span class="fa fa-calendar"></span>
    </div>
</div>
