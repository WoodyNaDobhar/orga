<!-- Officerable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('officerable_type', 'Officerable Type:') !!}
    {!! Form::text('officerable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Officerable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('officerable_id', 'Officerable Id:') !!}
    {!! Form::number('officerable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Office Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('office_id', 'Office Id:') !!}
    {!! Form::number('office_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Persona Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    {!! Form::number('persona_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Label Field -->
<div class="form-group col-sm-6">
    {!! Form::label('label', 'Label:') !!}
    {!! Form::text('label', null, ['class' => 'form-control', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Starts On Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starts_on', 'Starts On:') !!}
    {!! Form::text('starts_on', null, ['class' => 'form-control','id'=>'starts_on']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#starts_on').datepicker()
    </script>
@endpush

<!-- Ends On Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ends_on', 'Ends On:') !!}
    {!! Form::text('ends_on', null, ['class' => 'form-control','id'=>'ends_on']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#ends_on').datepicker()
    </script>
@endpush

<!-- Notes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notes', 'Notes:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control', 'maxlength' => 191, 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>