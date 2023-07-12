<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $suspension->id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $suspension->user_id }}</p>
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

<!-- Suspended Expires Field -->
<div class="col-sm-12">
    {!! Form::label('suspended_expires', 'Suspended Expires:') !!}
    <p>{{ $suspension->suspended_expires }}</p>
</div>

<!-- Cause Field -->
<div class="col-sm-12">
    {!! Form::label('cause', 'Cause:') !!}
    <p>{{ $suspension->cause }}</p>
</div>

