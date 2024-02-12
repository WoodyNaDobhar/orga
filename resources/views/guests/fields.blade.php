<!-- Event Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('event_id', 'Event Id:') !!}
    {!! Form::number('event_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Chapter Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chapter_id', 'Chapter Id:') !!}
    {!! Form::number('chapter_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Followedup Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_followedup', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_followedup', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_followedup', 'Is Followedup', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Notes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notes', 'Notes:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control', 'maxlength' => 191, 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>