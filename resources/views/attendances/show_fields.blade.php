<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $attendance->persona_id }}</p>
</div>

<!-- Archetype Id Field -->
<div class="col-sm-12">
    {!! Form::label('archetype_id', 'Archetype Id:') !!}
    <p>{{ $attendance->archetype_id }}</p>
</div>

<!-- Attendable Type Field -->
<div class="col-sm-12">
    {!! Form::label('attendable_type', 'Attendable Type:') !!}
    <p>{{ $attendance->attendable_type }}</p>
</div>

<!-- Attendable Id Field -->
<div class="col-sm-12">
    {!! Form::label('attendable_id', 'Attendable Id:') !!}
    <p>{{ $attendance->attendable_id }}</p>
</div>

<!-- Attended At Field -->
<div class="col-sm-12">
    {!! Form::label('attended_at', 'Attended At:') !!}
    <p>{{ $attendance->attended_at }}</p>
</div>

<!-- Credits Field -->
<div class="col-sm-12">
    {!! Form::label('credits', 'Credits:') !!}
    <p>{{ $attendance->credits }}</p>
</div>

