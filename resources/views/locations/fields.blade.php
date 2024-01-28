<!-- Label Field -->
<div class="form-group col-sm-6">
    {!! Form::label('label', 'Label:') !!}
    {!! Form::text('label', null, ['class' => 'form-control', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control', 'maxlength' => 191, 'maxlength' => 191, 'maxlength' => 191]) !!}
</div>

<!-- City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city', 'City:') !!}
    {!! Form::text('city', null, ['class' => 'form-control', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Province Field -->
<div class="form-group col-sm-6">
    {!! Form::label('province', 'Province:') !!}
    {!! Form::text('province', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35, 'maxlength' => 35]) !!}
</div>

<!-- Postal Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('postal_code', 'Postal Code:') !!}
    {!! Form::text('postal_code', null, ['class' => 'form-control', 'maxlength' => 10, 'maxlength' => 10, 'maxlength' => 10]) !!}
</div>

<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Country:') !!}
    {!! Form::text('country', null, ['class' => 'form-control', 'maxlength' => 2, 'maxlength' => 2, 'maxlength' => 2]) !!}
</div>

<!-- Google Geocode Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('google_geocode', 'Google Geocode:') !!}
    {!! Form::textarea('google_geocode', null, ['class' => 'form-control', 'maxlength' => 16777215, 'maxlength' => 16777215, 'maxlength' => 16777215]) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::number('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::number('longitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Location Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('location', 'Location:') !!}
    {!! Form::textarea('location', null, ['class' => 'form-control', 'maxlength' => 16777215, 'maxlength' => 16777215, 'maxlength' => 16777215]) !!}
</div>

<!-- Map Url Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('map_url', 'Map Url:') !!}
    {!! Form::textarea('map_url', null, ['class' => 'form-control', 'maxlength' => 16777215, 'maxlength' => 16777215, 'maxlength' => 16777215]) !!}
</div>

<!-- Directions Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('directions', 'Directions:') !!}
    {!! Form::textarea('directions', null, ['class' => 'form-control', 'maxlength' => 16777215, 'maxlength' => 16777215, 'maxlength' => 16777215]) !!}
</div>