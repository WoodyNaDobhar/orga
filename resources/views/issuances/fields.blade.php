<!-- Issuable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issuable_type', 'Issuable Type:') !!}
    {!! Form::text('issuable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Issuable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issuable_id', 'Issuable Id:') !!}
    {!! Form::number('issuable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Whereable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whereable_type', 'Whereable Type:') !!}
    {!! Form::text('whereable_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Whereable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('whereable_id', 'Whereable Id:') !!}
    {!! Form::number('whereable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Issuer Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issuer_type', 'Issuer Type:') !!}
    {!! Form::text('issuer_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Issuer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issuer_id', 'Issuer Id:') !!}
    {!! Form::number('issuer_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Recipient Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recipient_type', 'Recipient Type:') !!}
    {!! Form::text('recipient_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Recipient Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recipient_id', 'Recipient Id:') !!}
    {!! Form::number('recipient_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Signator Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('signator_id', 'Signator Id:') !!}
    {!! Form::number('signator_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Custom Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('custom_name', 'Custom Name:') !!}
    {!! Form::text('custom_name', null, ['class' => 'form-control', 'maxlength' => 64, 'maxlength' => 64, 'maxlength' => 64]) !!}
</div>

<!-- Rank Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rank', 'Rank:') !!}
    {!! Form::number('rank', null, ['class' => 'form-control']) !!}
</div>

<!-- Issued At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issued_at', 'Issued At:') !!}
    {!! Form::text('issued_at', null, ['class' => 'form-control','id'=>'issued_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#issued_at').datepicker()
    </script>
@endpush

<!-- Reason Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reason', 'Reason:') !!}
    {!! Form::text('reason', null, ['class' => 'form-control', 'maxlength' => 400, 'maxlength' => 400, 'maxlength' => 400]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::text('image', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Revoked By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('revoked_by', 'Revoked By:') !!}
    {!! Form::number('revoked_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Revoked At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('revoked_at', 'Revoked At:') !!}
    {!! Form::text('revoked_at', null, ['class' => 'form-control','id'=>'revoked_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#revoked_at').datepicker()
    </script>
@endpush

<!-- Revocation Field -->
<div class="form-group col-sm-6">
    {!! Form::label('revocation', 'Revocation:') !!}
    {!! Form::text('revocation', null, ['class' => 'form-control', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>