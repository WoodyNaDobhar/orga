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

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Issuer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issuer_id', 'Issuer Id:') !!}
    {!! Form::number('issuer_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Issuedable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issuedable_type', 'Issuedable Type:') !!}
    {!! Form::text('issuedable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Issuedable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issuedable_id', 'Issuedable Id:') !!}
    {!! Form::number('issuedable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Custom Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('custom_name', 'Custom Name:') !!}
    {!! Form::text('custom_name', null, ['class' => 'form-control', 'maxlength' => 64]) !!}
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

<!-- Note Field -->
<div class="form-group col-sm-6">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::text('note', null, ['class' => 'form-control', 'maxlength' => 400]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::text('image', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
</div>

<!-- Revocation Field -->
<div class="form-group col-sm-6">
    {!! Form::label('revocation', 'Revocation:') !!}
    {!! Form::text('revocation', null, ['class' => 'form-control', 'maxlength' => 50]) !!}
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