<!-- Event Id Field -->
<div class="col-sm-12">
    {!! Form::label('event_id', 'Event Id:') !!}
    <p>{{ $guest->event_id }}</p>
</div>

<!-- Chapter Id Field -->
<div class="col-sm-12">
    {!! Form::label('chapter_id', 'Chapter Id:') !!}
    <p>{{ $guest->chapter_id }}</p>
</div>

<!-- Is Followedup Field -->
<div class="col-sm-12">
    {!! Form::label('is_followedup', 'Is Followedup:') !!}
    <p>{{ $guest->is_followedup }}</p>
</div>

<!-- Notes Field -->
<div class="col-sm-12">
    {!! Form::label('notes', 'Notes:') !!}
    <p>{{ $guest->notes }}</p>
</div>

