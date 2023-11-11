<!-- Event Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('event_id', 'Event Id:') !!}
    {!! Form::number('event_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Persona Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    {!! Form::number('persona_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:') !!}
    {!! Form::text('role', null, ['class' => 'form-control', 'required', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Is Autocrat Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_autocrat', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_autocrat', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_autocrat', 'Is Autocrat', ['class' => 'form-check-label']) !!}
    </div>
</div>