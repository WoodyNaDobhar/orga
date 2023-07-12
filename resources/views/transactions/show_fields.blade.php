<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $transaction->description }}</p>
</div>

<!-- Memo Field -->
<div class="col-sm-12">
    {!! Form::label('memo', 'Memo:') !!}
    <p>{{ $transaction->memo }}</p>
</div>

<!-- Transaction At Field -->
<div class="col-sm-12">
    {!! Form::label('transaction_at', 'Transaction At:') !!}
    <p>{{ $transaction->transaction_at }}</p>
</div>

