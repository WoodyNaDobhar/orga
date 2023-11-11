<!-- Chapter Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chapter_id', 'Chapter Id:') !!}
    {!! Form::number('chapter_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Location Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_id', 'Location Id:') !!}
    {!! Form::number('location_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Alt Location Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alt_location_id', 'Alt Location Id:') !!}
    {!! Form::number('alt_location_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Recurrence Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recurrence', 'Recurrence:') !!}
    {!! Form::text('recurrence', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Week Of Month Field -->
<div class="form-group col-sm-6">
    {!! Form::label('week_of_month', 'Week Of Month:') !!}
    {!! Form::number('week_of_month', null, ['class' => 'form-control']) !!}
</div>

<!-- Week Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('week_day', 'Week Day:') !!}
    {!! Form::text('week_day', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Month Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('month_day', 'Month Day:') !!}
    {!! Form::number('month_day', null, ['class' => 'form-control']) !!}
</div>

<!-- Occurs At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('occurs_at', 'Occurs At:') !!}
    {!! Form::text('occurs_at', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Purpose Field -->
<div class="form-group col-sm-6">
    {!! Form::label('purpose', 'Purpose:') !!}
    {!! Form::text('purpose', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>