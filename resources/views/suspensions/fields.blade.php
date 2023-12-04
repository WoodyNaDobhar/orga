<!-- Persona Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    {!! Form::number('persona_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Realm Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kingdom_id', 'Realm Id:') !!}
    {!! Form::number('kingdom_id', null, ['class' => 'form-control', 'required']) !!}
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

<!-- Expires At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('expires_at', 'Expires At:') !!}
    {!! Form::text('expires_at', null, ['class' => 'form-control','id'=>'expires_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#expires_at').datepicker()
    </script>
@endpush

<!-- Cause Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cause', 'Cause:') !!}
    {!! Form::text('cause', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Is Propogating Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_propogating', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_propogating', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_propogating', 'Is Propogating', ['class' => 'form-check-label']) !!}
    </div>
</div>