<!-- Configurable Type Field -->
<div class="col-sm-12">
    {!! Form::label('configurable_type', 'Configurable Type:') !!}
    <p>{{ $configuration->configurable_type }}</p>
</div>

<!-- Configurable Id Field -->
<div class="col-sm-12">
    {!! Form::label('configurable_id', 'Configurable Id:') !!}
    <p>{{ $configuration->configurable_id }}</p>
</div>

<!-- Key Field -->
<div class="col-sm-12">
    {!! Form::label('key', 'Key:') !!}
    <p>{{ $configuration->key }}</p>
</div>

<!-- Value Field -->
<div class="col-sm-12">
    {!! Form::label('value', 'Value:') !!}
    <p>{{ $configuration->value }}</p>
</div>

<!-- Is User Setting Field -->
<div class="col-sm-12">
    {!! Form::label('is_user_setting', 'Is User Setting:') !!}
    <p>{{ $configuration->is_user_setting }}</p>
</div>

<!-- Allowed Values Field -->
<div class="col-sm-12">
    {!! Form::label('allowed_values', 'Allowed Values:') !!}
    <p>{{ $configuration->allowed_values }}</p>
</div>

<!-- Modified Field -->
<div class="col-sm-12">
    {!! Form::label('modified', 'Modified:') !!}
    <p>{{ $configuration->modified }}</p>
</div>

<!-- Var Type Field -->
<div class="col-sm-12">
    {!! Form::label('var_type', 'Var Type:') !!}
    <p>{{ $configuration->var_type }}</p>
</div>

