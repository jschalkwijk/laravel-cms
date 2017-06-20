@extends('admin.layout')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                @if (count($errors))
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                <div class="center">
                    <form class="small" enctype="multipart/form-data" method="post" action="{{ route('uploads.store') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="MAX_FILE_SIZE" value="43500000" />
                        <label for="files[]">Choose File(max size: 3.5 MB): </label><br />
                        <input type="file" name="files[]" multiple/><br />
                        <label for="destination">Select Destination</label>
                        <select name="destination">
                            <option value="0" selected>None</option>
                            @foreach($folders as $folder)
                                <option value="{{$folder->id()}}">{{$folder->name}}</option>
                            @endforeach
                        </select><br>
                        <input type="text" name="name" placeholder="New Folder" maxlength="60"/>
                        @if($parent != null)
                        <input type="hidden" name="parent" value="{{$parent->id()}}">
                        @endif
                        {{--<input type="text" name="new_album_name" placeholder="Create New Sub Folder" maxlength="60"/>--}}
                        <button type="submit" name="submit">Add File('s)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                <form id="check-folders" method="post" action="{{ route('folders.action') }}">
                    {{ csrf_field() }}
                    <table class="table table-sm table-striped">
                        <thead class="thead-default">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Size(MB)</th>
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
                                <td><a class="btn btn-sm btn-danger" href="{{ route('folders.destroy',$folder->folder_id) }}">Delete</a></td>
                                <td><input class="checkbox" type="checkbox" name="checkbox[]" value="{{ $folder->id() }}"/></td>
                                <td><input type="hidden" name="name" value="{{ $folder->name }}"/></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" name="delete-selected" id="delete-selected">Delete Folders</button>
                </form>
            </div>
        </div>
        @if(isset($files))
            <div class="row">
                <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                    <form id="check-files" method="post" action="/admin/uploads/action">
                        {{ csrf_field() }}
                        <table class="table table-sm table-striped">
                            <thead>

                            </thead>
                            <tbody>
                            @foreach ($files as $file)
                                <tr class="meta">
                                    <td class="media"><a class="image_link" href="{{ asset('storage/'.$file->file_path) }}"><img class="ADMIN" src="{{ asset('storage/'.$file->thumb_path) }}"/></a></td>
                                    <td class="td-title">{{ $file->name }}</td>
                                    <td>{{ $file->user['username']}}</td>
                                    <td class="td-category"><p>{{ $file->type }}</p></td>
                                    <td>{{ $file->created_at }}</td>
                                    <td class="td-btn"><a href="{{ route('uploads.edit',$file->upload_id) }}"><img class="glyph-small link-btn" alt="edit-item" src="edit.png"/></a></td>
                                    @if ($file->approved == 0 )
                                        <td class="td-btn"><img class="glyph-small" alt="item-hidden-from-front-end-user" src="hide.png"/></td>
                                    @elseif ($file->approved == 1 )
                                        <td class="td-btn"><img class="glyph-small" alt="item-visible-for-front-end-user" src="'show.png"/></td>
                                    @endif
                                    <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $file->id() }}"/></p></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <button type="submit" name="delete-selected" id="delete">Delete Selected</button>
                        <button type="submit" name="download_files" id="download_files">Download files</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@stop