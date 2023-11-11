<!-- Awarder Type Field -->
<div class="col-sm-12">
    {!! Form::label('awarder_type', 'Awarder Type:') !!}
    <p>{{ $award->awarder_type }}</p>
</div>

<!-- Awarder Id Field -->
<div class="col-sm-12">
    {!! Form::label('awarder_id', 'Awarder Id:') !!}
    <p>{{ $award->awarder_id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $award->name }}</p>
</div>

<!-- Is Ladder Field -->
<div class="col-sm-12">
    {!! Form::label('is_ladder', 'Is Ladder:') !!}
    <p>{{ $award->is_ladder }}</p>
</div>

<!-- Limit Field -->
<div class="col-sm-12">
    {!! Form::label('limit', 'Limit:') !!}
    <p>{{ $award->limit }}</p>
</div>

