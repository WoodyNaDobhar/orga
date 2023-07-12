<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $recommendation->user_id }}</p>
</div>

<!-- Award Id Field -->
<div class="col-sm-12">
    {!! Form::label('award_id', 'Award Id:') !!}
    <p>{{ $recommendation->award_id }}</p>
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

