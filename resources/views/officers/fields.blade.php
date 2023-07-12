<!-- Office Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('office_id', 'Office Id:') !!}
    {!! Form::number('office_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Authorized By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('authorized_by', 'Authorized By:') !!}
    {!! Form::number('authorized_by', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Officerable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('officerable_type', 'Officerable Type:') !!}
    {!! Form::text('officerable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Officerable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('officerable_id', 'Officerable Id:') !!}
    {!! Form::number('officerable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Scope Field -->
<div class="form-group col-sm-6">
    {!! Form::label('scope', 'Scope:') !!}
    {!! Form::text('scope', null, ['class' => 'form-control', 'required']) !!}
</div>