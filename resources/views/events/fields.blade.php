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

<!-- Autocrat Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('autocrat_id', 'Autocrat Id:') !!}
    {!! Form::number('autocrat_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Location Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_id', 'Location Id:') !!}
    {!! Form::number('location_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required', 'maxlength' => 16777215]) !!}
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

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
</div>

<!-- Url Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url_name', 'Url Name:') !!}
    {!! Form::text('url_name', null, ['class' => 'form-control', 'maxlength' => 40]) !!}
</div>