<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 50]) !!}
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