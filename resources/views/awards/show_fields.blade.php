<!-- Awardable Type Field -->
<div class="col-sm-12">
    {!! Form::label('awardable_type', 'Awardable Type:') !!}
    <p>{{ $award->awardable_type }}</p>
</div>

<!-- Awardable Id Field -->
<div class="col-sm-12">
    {!! Form::label('awardable_id', 'Awardable Id:') !!}
    <p>{{ $award->awardable_id }}</p>
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

