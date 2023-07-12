<!-- Configurable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('configurable_type', 'Configurable Type:') !!}
    {!! Form::text('configurable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Configurable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('configurable_id', 'Configurable Id:') !!}
    {!! Form::number('configurable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label('key', 'Key:') !!}
    {!! Form::text('key', null, ['class' => 'form-control', 'required', 'maxlength' => 50]) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::textarea('value', null, ['class' => 'form-control', 'required', 'maxlength' => 16777215]) !!}
</div>

<!-- Is User Setting Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_user_setting', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_user_setting', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_user_setting', 'Is User Setting', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Allowed Values Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('allowed_values', 'Allowed Values:') !!}
    {!! Form::textarea('allowed_values', null, ['class' => 'form-control', 'required', 'maxlength' => 16777215]) !!}
</div>

<!-- Modified Field -->
<div class="form-group col-sm-6">
    {!! Form::label('modified', 'Modified:') !!}
    {!! Form::text('modified', null, ['class' => 'form-control','id'=>'modified']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#modified').datepicker()
    </script>
@endpush

<!-- Var Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('var_type', 'Var Type:') !!}
    {!! Form::text('var_type', null, ['class' => 'form-control', 'required']) !!}
</div>