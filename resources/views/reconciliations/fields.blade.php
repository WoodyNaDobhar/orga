<!-- Archetype Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('archetype_id', 'Archetype Id:') !!}
    {!! Form::number('archetype_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Is Reconciled Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_reconciled', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_reconciled', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_reconciled', 'Is Reconciled', ['class' => 'form-check-label']) !!}
    </div>
</div>