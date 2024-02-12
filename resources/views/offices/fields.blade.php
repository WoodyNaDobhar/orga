<!-- Officeable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('officeable_type', 'Officeable Type:') !!}
    {!! Form::text('officeable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Officeable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('officeable_id', 'Officeable Id:') !!}
    {!! Form::number('officeable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Duration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('duration', 'Duration:') !!}
    {!! Form::number('duration', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order', 'Order:') !!}
    {!! Form::number('order', null, ['class' => 'form-control']) !!}
</div>