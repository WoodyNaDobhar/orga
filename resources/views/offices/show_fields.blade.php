<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $office->name }}</p>
</div>

<!-- Crown Points Field -->
<div class="col-sm-12">
    {!! Form::label('crown_points', 'Crown Points:') !!}
    <p>{{ $office->crown_points }}</p>
</div>

<!-- Crown Limit Field -->
<div class="col-sm-12">
    {!! Form::label('crown_limit', 'Crown Limit:') !!}
    <p>{{ $office->crown_limit }}</p>
</div>

