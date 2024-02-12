<!-- Awardable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('awardable_type', 'Awardable Type:') !!}
    {!! Form::text('awardable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Awardable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('awardable_id', 'Awardable Id:') !!}
    {!! Form::number('awardable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Is Ladder Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_ladder', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_ladder', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_ladder', 'Is Ladder', ['class' => 'form-check-label']) !!}
    </div>
</div>