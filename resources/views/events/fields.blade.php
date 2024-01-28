<!-- Eventable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('eventable_type', 'Eventable Type:') !!}
    {!! Form::text('eventable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Eventable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('eventable_id', 'Eventable Id:') !!}
    {!! Form::number('eventable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Location Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_id', 'Location Id:') !!}
    {!! Form::number('location_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 191, 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'maxlength' => 16777215, 'maxlength' => 16777215, 'maxlength' => 16777215]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::text('image', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Is Demo Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_demo', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_demo', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_demo', 'Is Demo', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Event Start Field -->
<div class="form-group col-sm-6">
    {!! Form::label('event_start', 'Event Start:') !!}
    {!! Form::text('event_start', null, ['class' => 'form-control','id'=>'event_start']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#event_start').datepicker()
    </script>
@endpush

<!-- Event End Field -->
<div class="form-group col-sm-6">
    {!! Form::label('event_end', 'Event End:') !!}
    {!! Form::text('event_end', null, ['class' => 'form-control','id'=>'event_end']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#event_end').datepicker()
    </script>
@endpush

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>