<!-- Event Id Field -->
<div class="col-sm-12">
    {!! Form::label('event_id', 'Event Id:') !!}
    <p>{{ $crat->event_id }}</p>
</div>

<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $crat->persona_id }}</p>
</div>

<!-- Role Field -->
<div class="col-sm-12">
    {!! Form::label('role', 'Role:') !!}
    <p>{{ $crat->role }}</p>
</div>

<!-- Is Autocrat Field -->
<div class="col-sm-12">
    {!! Form::label('is_autocrat', 'Is Autocrat:') !!}
    <p>{{ $crat->is_autocrat }}</p>
</div>

