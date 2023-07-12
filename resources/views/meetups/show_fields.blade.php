<!-- Park Id Field -->
<div class="col-sm-12">
    {!! Form::label('park_id', 'Park Id:') !!}
    <p>{{ $meetup->park_id }}</p>
</div>

<!-- Location Id Field -->
<div class="col-sm-12">
    {!! Form::label('location_id', 'Location Id:') !!}
    <p>{{ $meetup->location_id }}</p>
</div>

<!-- Alt Location Id Field -->
<div class="col-sm-12">
    {!! Form::label('alt_location_id', 'Alt Location Id:') !!}
    <p>{{ $meetup->alt_location_id }}</p>
</div>

<!-- Recurrence Field -->
<div class="col-sm-12">
    {!! Form::label('recurrence', 'Recurrence:') !!}
    <p>{{ $meetup->recurrence }}</p>
</div>

<!-- Week Of Month Field -->
<div class="col-sm-12">
    {!! Form::label('week_of_month', 'Week Of Month:') !!}
    <p>{{ $meetup->week_of_month }}</p>
</div>

<!-- Week Day Field -->
<div class="col-sm-12">
    {!! Form::label('week_day', 'Week Day:') !!}
    <p>{{ $meetup->week_day }}</p>
</div>

<!-- Month Day Field -->
<div class="col-sm-12">
    {!! Form::label('month_day', 'Month Day:') !!}
    <p>{{ $meetup->month_day }}</p>
</div>

<!-- Occurs At Field -->
<div class="col-sm-12">
    {!! Form::label('occurs_at', 'Occurs At:') !!}
    <p>{{ $meetup->occurs_at }}</p>
</div>

<!-- Purpose Field -->
<div class="col-sm-12">
    {!! Form::label('purpose', 'Purpose:') !!}
    <p>{{ $meetup->purpose }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $meetup->description }}</p>
</div>

