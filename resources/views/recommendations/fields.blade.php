<!-- Persona Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    {!! Form::number('persona_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Recommendable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recommendable_type', 'Recommendable Type:') !!}
    {!! Form::text('recommendable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Recommendable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recommendable_id', 'Recommendable Id:') !!}
    {!! Form::number('recommendable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Rank Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rank', 'Rank:') !!}
    {!! Form::number('rank', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Anonymous Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_anonymous', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_anonymous', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_anonymous', 'Is Anonymous', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Reason Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reason', 'Reason:') !!}
    {!! Form::text('reason', null, ['class' => 'form-control', 'required', 'maxlength' => 400, 'maxlength' => 400, 'maxlength' => 400]) !!}
</div>