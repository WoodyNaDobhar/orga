<!-- Chapter Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chapter_id', 'Chapter Id:') !!}
    {!! Form::number('chapter_id', null, ['class' => 'form-control', 'required']) !!}
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

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
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

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Reeve Qualified Expires At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reeve_qualified_expires_at', 'Reeve Qualified Expires At:') !!}
    {!! Form::text('reeve_qualified_expires_at', null, ['class' => 'form-control','id'=>'reeve_qualified_expires_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#reeve_qualified_expires_at').datepicker()
    </script>
@endpush

<!-- Corpora Qualified Expires At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('corpora_qualified_expires_at', 'Corpora Qualified Expires At:') !!}
    {!! Form::text('corpora_qualified_expires_at', null, ['class' => 'form-control','id'=>'corpora_qualified_expires_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#corpora_qualified_expires_at').datepicker()
    </script>
@endpush

<!-- Joined Chapter At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('joined_chapter_at', 'Joined Chapter At:') !!}
    {!! Form::text('joined_chapter_at', null, ['class' => 'form-control','id'=>'joined_chapter_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#joined_chapter_at').datepicker()
    </script>
@endpush