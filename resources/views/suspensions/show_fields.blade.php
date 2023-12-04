<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $suspension->persona_id }}</p>
</div>

<!-- Realm Id Field -->
<div class="col-sm-12">
    {!! Form::label('kingdom_id', 'Realm Id:') !!}
    <p>{{ $suspension->kingdom_id }}</p>
</div>

<!-- Suspended By Field -->
<div class="col-sm-12">
    {!! Form::label('suspended_by', 'Suspended By:') !!}
    <p>{{ $suspension->suspended_by }}</p>
</div>

<!-- Suspended At Field -->
<div class="col-sm-12">
    {!! Form::label('suspended_at', 'Suspended At:') !!}
    <p>{{ $suspension->suspended_at }}</p>
</div>

<!-- Expires At Field -->
<div class="col-sm-12">
    {!! Form::label('expires_at', 'Expires At:') !!}
    <p>{{ $suspension->expires_at }}</p>
</div>

<!-- Cause Field -->
<div class="col-sm-12">
    {!! Form::label('cause', 'Cause:') !!}
    <p>{{ $suspension->cause }}</p>
</div>

<!-- Is Propogating Field -->
<div class="col-sm-12">
    {!! Form::label('is_propogating', 'Is Propogating:') !!}
    <p>{{ $suspension->is_propogating }}</p>
</div>

