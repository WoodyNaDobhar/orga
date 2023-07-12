<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 100]) !!}
</div>

<!-- Crown Points Field -->
<div class="form-group col-sm-6">
    {!! Form::label('crown_points', 'Crown Points:') !!}
    {!! Form::number('crown_points', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Crown Limit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('crown_limit', 'Crown Limit:') !!}
    {!! Form::number('crown_limit', null, ['class' => 'form-control', 'required']) !!}
</div>