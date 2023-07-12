<!-- Archetype Id Field -->
<div class="col-sm-12">
    {!! Form::label('archetype_id', 'Archetype Id:') !!}
    <p>{{ $reconciliation->archetype_id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $reconciliation->user_id }}</p>
</div>

<!-- Is Reconciled Field -->
<div class="col-sm-12">
    {!! Form::label('is_reconciled', 'Is Reconciled:') !!}
    <p>{{ $reconciliation->is_reconciled }}</p>
</div>

