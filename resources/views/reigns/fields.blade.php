<!-- Reignable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reignable_type', 'Reignable Type:') !!}
    {!! Form::text('reignable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Reignable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reignable_id', 'Reignable Id:') !!}
    {!! Form::number('reignable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100, 'maxlength' => 100, 'maxlength' => 100]) !!}
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