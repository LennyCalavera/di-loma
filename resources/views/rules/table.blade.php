<div class="table-responsive">
    <table class="table" id="rules-table">
        <thead>
        <tr>
            <th>Conditions</th>
        <th>Disease</th>
        <th>Weight</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rules as $rule)
            <tr>
                <td>{{ $rule->conditions }}</td>
            <td>{{ $rule->disease }}</td>
            <td>{{ $rule->weight }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['rules.destroy', $rule->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('rules.show', [$rule->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('rules.edit', [$rule->id]) }}"
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
