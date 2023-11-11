<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', 'Parent Id:') !!}
    {!! Form::number('parent_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Accountable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accountable_type', 'Accountable Type:') !!}
    {!! Form::text('accountable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Accountable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accountable_id', 'Accountable Id:') !!}
    {!! Form::number('accountable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control', 'required']) !!}
</div>