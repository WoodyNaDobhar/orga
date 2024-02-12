<!-- Persona Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    {!! Form::number('persona_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Unit Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_id', 'Unit Id:') !!}
    {!! Form::number('unit_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Is Head Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_head', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_head', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_head', 'Is Head', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Is Voting Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_voting', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_voting', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_voting', 'Is Voting', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Joined At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('joined_at', 'Joined At:') !!}
    {!! Form::text('joined_at', null, ['class' => 'form-control','id'=>'joined_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#joined_at').datepicker()
    </script>
@endpush

<!-- Left At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('left_at', 'Left At:') !!}
    {!! Form::text('left_at', null, ['class' => 'form-control','id'=>'left_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#left_at').datepicker()
    </script>
@endpush

<!-- Notes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notes', 'Notes:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control', 'maxlength' => 191, 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>