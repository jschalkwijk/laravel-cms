<form id="check-folders" method="post" action="{{ route('folders.action') }}">
    {{ csrf_field() }}
    <table class="table table-sm table-striped">
        <thead class="thead-default">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Size(MB)</th>
            <th></th>
            <th></th>
            <th>
                <button type="button" id="check-all"><img class="glyph-small" src="/images/check.png"/></button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($folders as $folder)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><a href="{{ route('folders.show',$folder->id()) }}">{{ $folder->name }}</a></td>
                <td>Size</td>
                <td class="td-btn"><p><a href="{{ $folder->table.'/'.$folder->id().'/edit'}}">Edit</a></p></td>
                <td><a class="btn btn-sm btn-danger" href="{{ route('folders.destroy',$folder->folder_id) }}">Delete</a></td>
                <td><input class="checkbox" type="checkbox" name="checkbox[]" value="{{ $folder->id() }}"/></td>
                <td><input type="hidden" name="folder_id" value="{{ $folder->name }}"/></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <button type="submit" name="delete-selected" id="delete-selected">Delete Folders</button>
</form>