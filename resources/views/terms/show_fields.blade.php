<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $term->name }}</p>
</div>

<!-- Minborder Field -->
<div class="col-sm-12">
    {!! Form::label('minBorder', 'Minborder:') !!}
    <p>{{ $term->minBorder }}</p>
</div>

<!-- Maxborder Field -->
<div class="col-sm-12">
    {!! Form::label('maxBorder', 'Maxborder:') !!}
    <p>{{ $term->maxBorder }}</p>
</div>

