<!-- Subject Field -->
<div class="col-sm-12">
    {!! Form::label('subject', 'Subject:') !!}
    <p>{{ $pronoun->subject }}</p>
</div>

<!-- Object Field -->
<div class="col-sm-12">
    {!! Form::label('object', 'Object:') !!}
    <p>{{ $pronoun->object }}</p>
</div>

<!-- Possessive Field -->
<div class="col-sm-12">
    {!! Form::label('possessive', 'Possessive:') !!}
    <p>{{ $pronoun->possessive }}</p>
</div>

<!-- Possessivepronoun Field -->
<div class="col-sm-12">
    {!! Form::label('possessivepronoun', 'Possessivepronoun:') !!}
    <p>{{ $pronoun->possessivepronoun }}</p>
</div>

<!-- Reflexive Field -->
<div class="col-sm-12">
    {!! Form::label('reflexive', 'Reflexive:') !!}
    <p>{{ $pronoun->reflexive }}</p>
</div>

