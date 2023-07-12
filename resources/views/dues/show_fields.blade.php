<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $due->user_id }}</p>
</div>

<!-- Park Id Field -->
<div class="col-sm-12">
    {!! Form::label('park_id', 'Park Id:') !!}
    <p>{{ $due->park_id }}</p>
</div>

<!-- Transaction Id Field -->
<div class="col-sm-12">
    {!! Form::label('transaction_id', 'Transaction Id:') !!}
    <p>{{ $due->transaction_id }}</p>
</div>

<!-- Is For Life Field -->
<div class="col-sm-12">
    {!! Form::label('is_for_life', 'Is For Life:') !!}
    <p>{{ $due->is_for_life }}</p>
</div>

<!-- Dues At Field -->
<div class="col-sm-12">
    {!! Form::label('dues_at', 'Dues At:') !!}
    <p>{{ $due->dues_at }}</p>
</div>

<!-- Intervals Field -->
<div class="col-sm-12">
    {!! Form::label('intervals', 'Intervals:') !!}
    <p>{{ $due->intervals }}</p>
</div>

<!-- Revoked On Field -->
<div class="col-sm-12">
    {!! Form::label('revoked_on', 'Revoked On:') !!}
    <p>{{ $due->revoked_on }}</p>
</div>

<!-- Revoked By Field -->
<div class="col-sm-12">
    {!! Form::label('revoked_by', 'Revoked By:') !!}
    <p>{{ $due->revoked_by }}</p>
</div>

