<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>

<!-- Memo Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('memo', 'Memo:') !!}
    {!! Form::textarea('memo', null, ['class' => 'form-control', 'required', 'maxlength' => 16777215]) !!}
</div>

<!-- Transaction At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('transaction_at', 'Transaction At:') !!}
    {!! Form::text('transaction_at', null, ['class' => 'form-control','id'=>'transaction_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#transaction_at').datepicker()
    </script>
@endpush