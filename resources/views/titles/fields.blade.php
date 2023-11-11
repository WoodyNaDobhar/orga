<!-- Titleable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('titleable_type', 'Titleable Type:') !!}
    {!! Form::text('titleable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Titleable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('titleable_id', 'Titleable Id:') !!}
    {!! Form::number('titleable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Rank Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rank', 'Rank:') !!}
    {!! Form::number('rank', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Peerage Field -->
<div class="form-group col-sm-6">
    {!! Form::label('peerage', 'Peerage:') !!}
    {!! Form::text('peerage', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Is Roaming Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_roaming', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_roaming', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_roaming', 'Is Roaming', ['class' => 'form-check-label']) !!}
    </div>
</div>