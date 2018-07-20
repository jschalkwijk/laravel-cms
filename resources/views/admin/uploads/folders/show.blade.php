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
                                <td><input type="hidden" name="name" value="{{ $folder->name }}"/></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" name="delete-selected" id="delete-selected">Delete Folders</button>
                </form>
            </div>
        </div>
<!--        --><?php //system('find '.storage_path('app/public/uploads').' -empty -type d -delete');?>
        @if(isset($files))
            <div class="row">
                <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                    @include('admin.uploads.uploads-table')
                </div>
            </div>
        @endif
    </div>
@stop