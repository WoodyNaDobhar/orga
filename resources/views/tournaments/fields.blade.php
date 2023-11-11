<!-- Tournamentable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tournamentable_type', 'Tournamentable Type:') !!}
    {!! Form::text('tournamentable_type', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Tournamentable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tournamentable_id', 'Tournamentable Id:') !!}
    {!! Form::number('tournamentable_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required', 'maxlength' => 16777215, 'maxlength' => 16777215, 'maxlength' => 16777215]) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Occured At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('occured_at', 'Occured At:') !!}
    {!! Form::text('occured_at', null, ['class' => 'form-control','id'=>'occured_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#occured_at').datepicker()
    </script>
@endpush