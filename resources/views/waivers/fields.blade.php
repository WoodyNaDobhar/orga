<!-- Pronoun Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pronoun_id', 'Pronoun Id:') !!}
    {!! Form::number('pronoun_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Persona Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    {!! Form::number('persona_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Waiverable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('waiverable_type', 'Waiverable Type:') !!}
    {!! Form::text('waiverable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Waiverable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('waiverable_id', 'Waiverable Id:') !!}
    {!! Form::number('waiverable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- File Field -->
<div class="form-group col-sm-6">
    {!! Form::label('file', 'File:') !!}
    {!! Form::text('file', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Player Field -->
<div class="form-group col-sm-6">
    {!! Form::label('player', 'Player:') !!}
    {!! Form::text('player', null, ['class' => 'form-control', 'required', 'maxlength' => 150, 'maxlength' => 150, 'maxlength' => 150]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control', 'maxlength' => 25, 'maxlength' => 25, 'maxlength' => 25]) !!}
</div>

<!-- Location Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_id', 'Location Id:') !!}
    {!! Form::number('location_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Dob Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dob', 'Dob:') !!}
    {!! Form::text('dob', null, ['class' => 'form-control','id'=>'dob']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#dob').datepicker()
    </script>
@endpush

<!-- Age Verified At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('age_verified_at', 'Age Verified At:') !!}
    {!! Form::text('age_verified_at', null, ['class' => 'form-control','id'=>'age_verified_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#age_verified_at').datepicker()
    </script>
@endpush

<!-- Age Verified By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('age_verified_by', 'Age Verified By:') !!}
    {!! Form::number('age_verified_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Guardian Field -->
<div class="form-group col-sm-6">
    {!! Form::label('guardian', 'Guardian:') !!}
    {!! Form::text('guardian', null, ['class' => 'form-control', 'maxlength' => 150, 'maxlength' => 150, 'maxlength' => 150]) !!}
</div>

<!-- Emergency Contact Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('emergency_contact_name', 'Emergency Contact Name:') !!}
    {!! Form::text('emergency_contact_name', null, ['class' => 'form-control', 'maxlength' => 150, 'maxlength' => 150, 'maxlength' => 150]) !!}
</div>

<!-- Emergency Contact Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('emergency_contact_phone', 'Emergency Contact Phone:') !!}
    {!! Form::text('emergency_contact_phone', null, ['class' => 'form-control', 'maxlength' => 25, 'maxlength' => 25, 'maxlength' => 25]) !!}
</div>

<!-- Signed At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('signed_at', 'Signed At:') !!}
    {!! Form::text('signed_at', null, ['class' => 'form-control','id'=>'signed_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#signed_at').datepicker()
    </script>
@endpush