<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 191,'maxlength' => 191]) !!}
</div>

<!-- Minborder Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minBorder', 'Minborder:') !!}
    {!! Form::number('minBorder', null, ['class' => 'form-control']) !!}
</div>

<!-- Maxborder Field -->
<div class="form-group col-sm-6">
    {!! Form::label('maxBorder', 'Maxborder:') !!}
    {!! Form::number('maxBorder', null, ['class' => 'form-control']) !!}
</div>