<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $recommendation->persona_id }}</p>
</div>

<!-- Recommendable Type Field -->
<div class="col-sm-12">
    {!! Form::label('recommendable_type', 'Recommendable Type:') !!}
    <p>{{ $recommendation->recommendable_type }}</p>
</div>

<!-- Recommendable Id Field -->
<div class="col-sm-12">
    {!! Form::label('recommendable_id', 'Recommendable Id:') !!}
    <p>{{ $recommendation->recommendable_id }}</p>
</div>

<!-- Rank Field -->
<div class="col-sm-12">
    {!! Form::label('rank', 'Rank:') !!}
    <p>{{ $recommendation->rank }}</p>
</div>

<!-- Is Anonymous Field -->
<div class="col-sm-12">
    {!! Form::label('is_anonymous', 'Is Anonymous:') !!}
    <p>{{ $recommendation->is_anonymous }}</p>
</div>

<!-- Reason Field -->
<div class="col-sm-12">
    {!! Form::label('reason', 'Reason:') !!}
    <p>{{ $recommendation->reason }}</p>
</div>

