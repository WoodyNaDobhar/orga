<!-- Park Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('park_id', 'Park Id:') !!}
    {!! Form::number('park_id', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Pronoun Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pronoun_id', 'Pronoun Id:') !!}
    {!! Form::number('pronoun_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mundane Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mundane', 'Mundane:') !!}
    {!! Form::text('mundane', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Persona Field -->
<div class="form-group col-sm-6">
    {!! Form::label('persona', 'Persona:') !!}
    {!! Form::text('persona', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Heraldry Field -->
<div class="form-group col-sm-6">
    {!! Form::label('heraldry', 'Heraldry:') !!}
    {!! Form::text('heraldry', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::text('image', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Restricted Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('restricted', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('restricted', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('restricted', 'Restricted', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Waivered Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('waivered', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('waivered', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('waivered', 'Waivered', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Waiver Ext Field -->
<div class="form-group col-sm-6">
    {!! Form::label('waiver_ext', 'Waiver Ext:') !!}
    {!! Form::text('waiver_ext', null, ['class' => 'form-control', 'required', 'maxlength' => 8, 'maxlength' => 8, 'maxlength' => 8]) !!}
</div>

<!-- Penalty Box Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('penalty_box', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('penalty_box', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('penalty_box', 'Penalty Box', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Reeve Qualified Expires Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reeve_qualified_expires', 'Reeve Qualified Expires:') !!}
    {!! Form::text('reeve_qualified_expires', null, ['class' => 'form-control','id'=>'reeve_qualified_expires']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#reeve_qualified_expires').datepicker()
    </script>
@endpush

<!-- Corpora Qualified Expires Field -->
<div class="form-group col-sm-6">
    {!! Form::label('corpora_qualified_expires', 'Corpora Qualified Expires:') !!}
    {!! Form::text('corpora_qualified_expires', null, ['class' => 'form-control','id'=>'corpora_qualified_expires']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#corpora_qualified_expires').datepicker()
    </script>
@endpush

<!-- Joined Park At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('joined_park_at', 'Joined Park At:') !!}
    {!! Form::text('joined_park_at', null, ['class' => 'form-control','id'=>'joined_park_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#joined_park_at').datepicker()
    </script>
@endpush