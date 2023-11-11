<!-- Tournamentable Type Field -->
<div class="col-sm-12">
    {!! Form::label('tournamentable_type', 'Tournamentable Type:') !!}
    <p>{{ $tournament->tournamentable_type }}</p>
</div>

<!-- Tournamentable Id Field -->
<div class="col-sm-12">
    {!! Form::label('tournamentable_id', 'Tournamentable Id:') !!}
    <p>{{ $tournament->tournamentable_id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $tournament->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $tournament->description }}</p>
</div>

<!-- Url Field -->
<div class="col-sm-12">
    {!! Form::label('url', 'Url:') !!}
    <p>{{ $tournament->url }}</p>
</div>

<!-- Occured At Field -->
<div class="col-sm-12">
    {!! Form::label('occured_at', 'Occured At:') !!}
    <p>{{ $tournament->occured_at }}</p>
</div>

