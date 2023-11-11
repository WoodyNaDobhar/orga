<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $due->persona_id }}</p>
</div>

<!-- Transaction Id Field -->
<div class="col-sm-12">
    {!! Form::label('transaction_id', 'Transaction Id:') !!}
    <p>{{ $due->transaction_id }}</p>
</div>

<!-- Dues On Field -->
<div class="col-sm-12">
    {!! Form::label('dues_on', 'Dues On:') !!}
    <p>{{ $due->dues_on }}</p>
</div>

<!-- Intervals Field -->
<div class="col-sm-12">
    {!! Form::label('intervals', 'Intervals:') !!}
    <p>{{ $due->intervals }}</p>
</div>

