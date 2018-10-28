<form class="backend-form" method="post" action="/admin/users/action">
    {{ csrf_field() }}
    <table class="table table-sm table-striped">
        <thead class="thead-default">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Date/Time</th>
            <th>Edit</th>
            <th>View</th>
            <th>Del</th>
            <th>Check</th>
        </tr>
        </thead>
        @foreach($users as $single)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td class="td-title"><p>{{ $single->first_name }}</p></td>
                <td><p>{{ $single->email }}</p></td>
                <td><p>{{ $single->created_at }}</p></td>
                {{--<td class="td-category"><p>@foreach($single->permission as $perm){{ $perm->name }} @endforeach</p></td>--}}

                <td class="td-btn"><a href="{{ $single->table.'/'.$single->user_id.'/edit/'}}">Edit</a></td>
                @if ($single->approved == 0)
                    <td><a class="form-action btn btn-sm btn-warning" href="{{ route($single->table.'.approve', $single->id()) }}"></a></td>
                @elseif ($single->approved == 1)
                    <td><a class="form-action btn btn-sm btn-success" href="{{ route($single->table.'.hide', $single->id()) }}"></a></td>
                @endif
                @if ($single->trashed == 0)
                    <td><a href="{{route($single->table.'.trash',$single->id())}}" class="form-action btn btn-sm btn-danger"></a></td>
                @elseif ($single->trashed == 1)
                    <td><a href="{{route($single->table.'.destroy',$single->id())}}" class="form-action btn btn-sm btn-danger"><img
                                    class="glyph-small" alt="destroy-item" src=""/></a></td>
                @endif
                <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $single->user_id }}>"/></p></td>
            </tr>
        @endforeach
    </table>
    <table class="float-right">
        <?php if($trashed === 0){ ?>
        <tr><th></th><th>Trash</th><th>Show</th><th>Hide</th></tr>
        <tr>
            <td>On selected items</td>
            <td><p><button class="btn btn-sm btn-danger form-action" type="submit" name="trash-selected" id="trash-selected"></button></p></td>
            <td><p><button class="btn btn-sm btn-success form-action" type="submit" name="approve-selected" id="approve-selected"></button></p></td>
            <td><p><button class="btn btn-sm btn-warning form-action" type="submit" name="hide-selected" id="hide-selected"></button></p></td>
        </tr>
        <?php } else if($trashed === 1){ ?>
        <th>Restore</th><th>Remove</th></tr>
        <tr>
            <td>On selected items</td>
            <td><p><button class="btn btn-sm btn-info form-action" type="submit" name="restore-selected" id="restore-selected"></button></p></td>
            <td><p><button class="btn btn-sm btn-danger form-action" type="submit" name="delete-selected" id="delete-selected"></p></td>
        </tr>
        <?php } ?>
    </table>
</form>

