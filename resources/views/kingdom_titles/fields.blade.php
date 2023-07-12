<!-- Kingdom Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kingdom_id', 'Kingdom Id:') !!}
    {!! Form::number('kingdom_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Title Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title_id', 'Title Id:') !!}
    {!! Form::number('title_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Custom Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('custom_name', 'Custom Name:') !!}
    {!! Form::text('custom_name', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
</div>