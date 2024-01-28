<!-- Unit Id Field -->
<div class="col-sm-12">
    {!! Form::label('unit_id', 'Unit Id:') !!}
    <p>{{ $member->unit_id }}</p>
</div>

<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $member->persona_id }}</p>
</div>

<!-- Is Head Field -->
<div class="col-sm-12">
    {!! Form::label('is_head', 'Is Head:') !!}
    <p>{{ $member->is_head }}</p>
</div>

<!-- Is Voting Field -->
<div class="col-sm-12">
    {!! Form::label('is_voting', 'Is Voting:') !!}
    <p>{{ $member->is_voting }}</p>
</div>

<!-- Joined At Field -->
<div class="col-sm-12">
    {!! Form::label('joined_at', 'Joined At:') !!}
    <p>{{ $member->joined_at }}</p>
</div>

<!-- Left At Field -->
<div class="col-sm-12">
    {!! Form::label('left_at', 'Left At:') !!}
    <p>{{ $member->left_at }}</p>
</div>

<!-- Notes Field -->
<div class="col-sm-12">
    {!! Form::label('notes', 'Notes:') !!}
    <p>{{ $member->notes }}</p>
</div>

