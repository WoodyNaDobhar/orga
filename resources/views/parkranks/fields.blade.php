<!-- Kingdom Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kingdom_id', 'Kingdom Id:') !!}
    {!! Form::number('kingdom_id', null, ['class' => 'form-control', 'required']) !!}
</div>

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

<!-- Minimumattendance Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minimumattendance', 'Minimumattendance:') !!}
    {!! Form::number('minimumattendance', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Minimumcutoff Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minimumcutoff', 'Minimumcutoff:') !!}
    {!! Form::number('minimumcutoff', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Period Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period', 'Period:') !!}
    {!! Form::text('period', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Period Length Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period_length', 'Period Length:') !!}
    {!! Form::number('period_length', null, ['class' => 'form-control', 'required']) !!}
</div>