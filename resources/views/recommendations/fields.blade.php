<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Award Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('award_id', 'Award Id:') !!}
    {!! Form::number('award_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Rank Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rank', 'Rank:') !!}
    {!! Form::number('rank', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Is Anonymous Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_anonymous', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_anonymous', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_anonymous', 'Is Anonymous', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Reason Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reason', 'Reason:') !!}
    {!! Form::text('reason', null, ['class' => 'form-control', 'required', 'maxlength' => 400]) !!}
</div>