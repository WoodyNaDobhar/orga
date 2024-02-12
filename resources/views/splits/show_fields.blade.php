<!-- Account Id Field -->
<div class="col-sm-12">
    {!! Form::label('account_id', 'Account Id:') !!}
    <p>{{ $split->account_id }}</p>
</div>

<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $split->persona_id }}</p>
</div>

<!-- Transaction Id Field -->
<div class="col-sm-12">
    {!! Form::label('transaction_id', 'Transaction Id:') !!}
    <p>{{ $split->transaction_id }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $split->amount }}</p>
</div>

