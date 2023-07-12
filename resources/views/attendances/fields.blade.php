<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Archetype Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('archetype_id', 'Archetype Id:') !!}
    {!! Form::number('archetype_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Attendable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('attendable_type', 'Attendable Type:') !!}
    {!! Form::text('attendable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Attendable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('attendable_id', 'Attendable Id:') !!}
    {!! Form::number('attendable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Attended At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('attended_at', 'Attended At:') !!}
    {!! Form::text('attended_at', null, ['class' => 'form-control','id'=>'attended_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#attended_at').datepicker()
    </script>
@endpush

<!-- Credits Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credits', 'Credits:') !!}
    {!! Form::number('credits', null, ['class' => 'form-control', 'required']) !!}
</div>