<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', 'Parent Id:') !!}
    {!! Form::number('parent_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Abbreviation Field -->
<div class="form-group col-sm-6">
    {!! Form::label('abbreviation', 'Abbreviation:') !!}
    {!! Form::text('abbreviation', null, ['class' => 'form-control', 'required', 'maxlength' => 4, 'maxlength' => 4, 'maxlength' => 4]) !!}
</div>

<!-- Color Field -->
<div class="form-group col-sm-6">
    {!! Form::label('color', 'Color:') !!}
    {!! Form::text('color', null, ['class' => 'form-control', 'required', 'maxlength' => 6, 'maxlength' => 6, 'maxlength' => 6]) !!}
</div>

<!-- Heraldry Field -->
<div class="form-group col-sm-6">
    {!! Form::label('heraldry', 'Heraldry:') !!}
    {!! Form::text('heraldry', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Credit Minimum Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credit_minimum', 'Credit Minimum:') !!}
    {!! Form::number('credit_minimum', null, ['class' => 'form-control']) !!}
</div>

<!-- Credit Maximum Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credit_maximum', 'Credit Maximum:') !!}
    {!! Form::number('credit_maximum', null, ['class' => 'form-control']) !!}
</div>

<!-- Daily Minimum Field -->
<div class="form-group col-sm-6">
    {!! Form::label('daily_minimum', 'Daily Minimum:') !!}
    {!! Form::number('daily_minimum', null, ['class' => 'form-control']) !!}
</div>

<!-- Weekly Minimum Field -->
<div class="form-group col-sm-6">
    {!! Form::label('weekly_minimum', 'Weekly Minimum:') !!}
    {!! Form::number('weekly_minimum', null, ['class' => 'form-control']) !!}
</div>

<!-- Average Period Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('average_period_type', 'Average Period Type:') !!}
    {!! Form::text('average_period_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Average Period Field -->
<div class="form-group col-sm-6">
    {!! Form::label('average_period', 'Average Period:') !!}
    {!! Form::number('average_period', null, ['class' => 'form-control']) !!}
</div>

<!-- Dues Intervals Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dues_intervals_type', 'Dues Intervals Type:') !!}
    {!! Form::text('dues_intervals_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Dues Intervals Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dues_intervals', 'Dues Intervals:') !!}
    {!! Form::number('dues_intervals', null, ['class' => 'form-control']) !!}
</div>

<!-- Dues Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dues_amount', 'Dues Amount:') !!}
    {!! Form::number('dues_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Dues Take Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dues_take', 'Dues Take:') !!}
    {!! Form::number('dues_take', null, ['class' => 'form-control']) !!}
</div>