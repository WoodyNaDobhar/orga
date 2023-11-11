<!-- Archetype Id Field -->
<div class="col-sm-12">
    {!! Form::label('archetype_id', 'Archetype Id:') !!}
    <p>{{ $reconciliation->archetype_id }}</p>
</div>

<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $reconciliation->persona_id }}</p>
</div>

<!-- Credits Field -->
<div class="col-sm-12">
    {!! Form::label('credits', 'Credits:') !!}
    <p>{{ $reconciliation->credits }}</p>
</div>

