<!-- Persona Id Field -->
<div class="col-sm-12">
    {!! Form::label('persona_id', 'Persona Id:') !!}
    <p>{{ $user->persona_id }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Email Verified At Field -->
<div class="col-sm-12">
    {!! Form::label('email_verified_at', 'Email Verified At:') !!}
    <p>{{ $user->email_verified_at }}</p>
</div>

<!-- Password Field -->
<div class="col-sm-12">
    {!! Form::label('password', 'Password:') !!}
    <p>{{ $user->password }}</p>
</div>

<!-- Remember Token Field -->
<div class="col-sm-12">
    {!! Form::label('remember_token', 'Remember Token:') !!}
    <p>{{ $user->remember_token }}</p>
</div>

<!-- Api Token Field -->
<div class="col-sm-12">
    {!! Form::label('api_token', 'Api Token:') !!}
    <p>{{ $user->api_token }}</p>
</div>

<!-- Is Restricted Field -->
<div class="col-sm-12">
    {!! Form::label('is_restricted', 'Is Restricted:') !!}
    <p>{{ $user->is_restricted }}</p>
</div>

