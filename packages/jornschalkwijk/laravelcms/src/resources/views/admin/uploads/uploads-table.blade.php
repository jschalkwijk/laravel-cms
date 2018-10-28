
    <form id="check-files" method="post" action="/admin/uploads/action">
        {{ csrf_field() }}
        <table class="table table-sm table-striped">
            <thead class="thead-default">
            <tr><th>#</th><th>Name</th><th>User</th><th>Type</th><th>Date</th><th>Edit</th>@if(isset($parent))<th>Del</th>@endif<th></th></tr>
            </thead>
            <tbody>
            @foreach ($files as $file)
                <tr>
                    <td class="media"><a class="image_link" href="{{ asset('/storage/'.$file->path()) }}"><img src="{{ asset('/storage/'.$file->path('thumbnail')) }}"/></a></td>
                    <td class="td-title">{{ $file->name }}</td>
                    <td>{{ $file->user->username }}</td>
                    <td class="td-category"><p>{{ $file->type }}</p></td>
                    <td>{{ $file->created_at }}</td>
                    <td class="td-btn"><a href="{{ route('uploads.edit',$file->upload_id) }}">Edit</a></td>
                    @if(isset($folder))
                        <td><a class="btn btn-sm btn-danger form-action" href="{{ route('uploads.destroy',[$file->id(),$folder->folder_id]) }}"></a></td>
                        <input type="hidden" name="folder_id" value="{{$folder->folder_id}}"/>
                    @endif
                    <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $file->id() }}"/></p></td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <button type="submit" name="delete-files" id="delete">Delete Selected</button>
        <button type="submit" name="download_files" id="download_files">Download files</button>
    </form>
