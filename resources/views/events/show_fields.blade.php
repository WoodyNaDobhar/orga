<!-- Eventable Type Field -->
<div class="col-sm-12">
    {!! Form::label('eventable_type', 'Eventable Type:') !!}
    <p>{{ $event->eventable_type }}</p>
</div>

<!-- Eventable Id Field -->
<div class="col-sm-12">
    {!! Form::label('eventable_id', 'Eventable Id:') !!}
    <p>{{ $event->eventable_id }}</p>
</div>

<!-- Location Id Field -->
<div class="col-sm-12">
    {!! Form::label('location_id', 'Location Id:') !!}
    <p>{{ $event->location_id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $event->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $event->description }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $event->image }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>{{ $event->is_active }}</p>
</div>

<!-- Is Demo Field -->
<div class="col-sm-12">
    {!! Form::label('is_demo', 'Is Demo:') !!}
    <p>{{ $event->is_demo }}</p>
</div>

<!-- Event Started At Field -->
<div class="col-sm-12">
    {!! Form::label('event_started_at', 'Event Started At:') !!}
    <p>{{ $event->event_started_at }}</p>
</div>

<!-- Event Ended At Field -->
<div class="col-sm-12">
    {!! Form::label('event_ended_at', 'Event Ended At:') !!}
    <p>{{ $event->event_ended_at }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $event->price }}</p>
</div>

