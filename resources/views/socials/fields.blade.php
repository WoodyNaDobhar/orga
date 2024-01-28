<!-- Sociable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sociable_type', 'Sociable Type:') !!}
    {!! Form::text('sociable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Sociable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sociable_id', 'Sociable Id:') !!}
    {!! Form::number('sociable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Media Field -->
<div class="form-group col-sm-6">
    {!! Form::label('media', 'Media:') !!}
    {!! Form::text('media', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::text('value', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>