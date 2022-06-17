<div class="table-responsive">
    <table class="table" id="symptoms-table">
        <thead>
        <tr>
            <th>Name</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($symptoms as $symptom)
            <tr>
                <td>{{ $symptom->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['symptoms.destroy', $symptom->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('symptoms.show', [$symptom->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('symptoms.edit', [$symptom->id]) }}"
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
