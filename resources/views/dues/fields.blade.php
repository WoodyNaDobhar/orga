<!-- Persona Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    {!! Form::number('persona_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Transaction Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('transaction_id', 'Transaction Id:') !!}
    {!! Form::number('transaction_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Dues On Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dues_on', 'Dues On:') !!}
    {!! Form::text('dues_on', null, ['class' => 'form-control','id'=>'dues_on']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#dues_on').datepicker()
    </script>
@endpush

<!-- Intervals Field -->
<div class="form-group col-sm-6">
    {!! Form::label('intervals', 'Intervals:') !!}
    {!! Form::number('intervals', null, ['class' => 'form-control']) !!}
</div>