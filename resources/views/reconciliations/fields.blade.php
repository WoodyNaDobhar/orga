<!-- Archetype Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('archetype_id', 'Archetype Id:') !!}
    {!! Form::number('archetype_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Persona Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    {!! Form::number('persona_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Credits Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credits', 'Credits:') !!}
    {!! Form::number('credits', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Notes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notes', 'Notes:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control', 'maxlength' => 191, 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>