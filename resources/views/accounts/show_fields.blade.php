<!-- Parent Id Field -->
<div class="col-sm-12">
    {!! Form::label('parent_id', 'Parent Id:') !!}
    <p>{{ $account->parent_id }}</p>
</div>

<!-- Accountable Type Field -->
<div class="col-sm-12">
    {!! Form::label('accountable_type', 'Accountable Type:') !!}
    <p>{{ $account->accountable_type }}</p>
</div>

<!-- Accountable Id Field -->
<div class="col-sm-12">
    {!! Form::label('accountable_id', 'Accountable Id:') !!}
    <p>{{ $account->accountable_id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $account->name }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $account->type }}</p>
</div>

