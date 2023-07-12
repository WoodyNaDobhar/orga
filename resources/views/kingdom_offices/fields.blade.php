<!-- Kingdom Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kingdom_id', 'Kingdom Id:') !!}
    {!! Form::number('kingdom_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Office Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('office_id', 'Office Id:') !!}
    {!! Form::number('office_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Custom Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('custom_name', 'Custom Name:') !!}
    {!! Form::text('custom_name', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
</div>