<!-- Realm Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('realm_id', 'Realm Id:') !!}
    {!! Form::number('realm_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Chaptertype Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chaptertype_id', 'Chaptertype Id:') !!}
    {!! Form::number('chaptertype_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Location Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_id', 'Location Id:') !!}
    {!! Form::number('location_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Abbreviation Field -->
<div class="form-group col-sm-6">
    {!! Form::label('abbreviation', 'Abbreviation:') !!}
    {!! Form::text('abbreviation', null, ['class' => 'form-control', 'required', 'maxlength' => 3, 'maxlength' => 3, 'maxlength' => 3]) !!}
</div>

<!-- Heraldry Field -->
<div class="form-group col-sm-6">
    {!! Form::label('heraldry', 'Heraldry:') !!}
    {!! Form::text('heraldry', null, ['class' => 'form-control', 'maxlength' => 191, 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>