<!-- Parent Id Field -->
<div class="col-sm-12">
    {!! Form::label('parent_id', 'Parent Id:') !!}
    <p>{{ $kingdom->parent_id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $kingdom->name }}</p>
</div>

<!-- Abbreviation Field -->
<div class="col-sm-12">
    {!! Form::label('abbreviation', 'Abbreviation:') !!}
    <p>{{ $kingdom->abbreviation }}</p>
</div>

<!-- Heraldry Field -->
<div class="col-sm-12">
    {!! Form::label('heraldry', 'Heraldry:') !!}
    <p>{{ $kingdom->heraldry }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>{{ $kingdom->is_active }}</p>
</div>

