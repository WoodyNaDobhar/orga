<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Park Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('park_id', 'Park Id:') !!}
    {!! Form::number('park_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Transaction Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('transaction_id', 'Transaction Id:') !!}
    {!! Form::number('transaction_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Is For Life Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_for_life', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_for_life', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_for_life', 'Is For Life', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Dues At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dues_at', 'Dues At:') !!}
    {!! Form::text('dues_at', null, ['class' => 'form-control','id'=>'dues_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#dues_at').datepicker()
    </script>
@endpush

<!-- Intervals Field -->
<div class="form-group col-sm-6">
    {!! Form::label('intervals', 'Intervals:') !!}
    {!! Form::number('intervals', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Revoked On Field -->
<div class="form-group col-sm-6">
    {!! Form::label('revoked_on', 'Revoked On:') !!}
    {!! Form::text('revoked_on', null, ['class' => 'form-control','id'=>'revoked_on']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#revoked_on').datepicker()
    </script>
@endpush

<!-- Revoked By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('revoked_by', 'Revoked By:') !!}
    {!! Form::number('revoked_by', null, ['class' => 'form-control']) !!}
</div>