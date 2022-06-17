<!-- Conditions Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('conditions', 'Conditions:') !!}
    {!! Form::textarea('conditions', null, ['class' => 'form-control']) !!}
</div>

<!-- Disease Field -->
<div class="form-group col-sm-6">
    {!! Form::label('disease', 'Disease:') !!}
    {!! Form::number('disease', null, ['class' => 'form-control']) !!}
</div>

<!-- Weight Field -->
<div class="form-group col-sm-6">
    {!! Form::label('weight', 'Weight:') !!}
    {!! Form::number('weight', null, ['class' => 'form-control']) !!}
</div>