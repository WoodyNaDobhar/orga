<!-- Office Id Field -->
<div class="col-sm-12">
    {!! Form::label('office_id', 'Office Id:') !!}
    <p>{{ $officer->office_id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $officer->user_id }}</p>
</div>

<!-- Authorized By Field -->
<div class="col-sm-12">
    {!! Form::label('authorized_by', 'Authorized By:') !!}
    <p>{{ $officer->authorized_by }}</p>
</div>

<!-- Officerable Type Field -->
<div class="col-sm-12">
    {!! Form::label('officerable_type', 'Officerable Type:') !!}
    <p>{{ $officer->officerable_type }}</p>
</div>

<!-- Officerable Id Field -->
<div class="col-sm-12">
    {!! Form::label('officerable_id', 'Officerable Id:') !!}
    <p>{{ $officer->officerable_id }}</p>
</div>

<!-- Scope Field -->
<div class="col-sm-12">
    {!! Form::label('scope', 'Scope:') !!}
    <p>{{ $officer->scope }}</p>
</div>

