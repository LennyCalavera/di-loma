<div class="table-responsive">
    <table class="table" id="terms-table">
        <thead>
        <tr>
            <th>Name</th>
        <th>Minborder</th>
        <th>Maxborder</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($terms as $term)
            <tr>
                <td>{{ $term->name }}</td>
            <td>{{ $term->minBorder }}</td>
            <td>{{ $term->maxBorder }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['terms.destroy', $term->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('terms.show', [$term->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('terms.edit', [$term->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
