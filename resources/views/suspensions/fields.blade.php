<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::number('id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Suspended By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('suspended_by', 'Suspended By:') !!}
    {!! Form::number('suspended_by', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Suspended At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('suspended_at', 'Suspended At:') !!}
    {!! Form::text('suspended_at', null, ['class' => 'form-control','id'=>'suspended_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#suspended_at').datepicker()
    </script>
@endpush

<!-- Suspended Expires Field -->
<div class="form-group col-sm-6">
    {!! Form::label('suspended_expires', 'Suspended Expires:') !!}
    {!! Form::text('suspended_expires', null, ['class' => 'form-control','id'=>'suspended_expires']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#suspended_expires').datepicker()
    </script>
@endpush

<!-- Cause Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cause', 'Cause:') !!}
    {!! Form::text('cause', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>