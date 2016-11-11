@extends('admin.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form id="check-folders" method="post" action="#">
                <table class="files-table">
                    <thead><th>Preview</th><th>Name</th><th>Size(MB)</th><th><button type="button" id="check-all"><img class="glyph-small" src="/images/check.png"/></button></th></thead>
                    @foreach($folders as $folder)
                        <tr class="meta">
                            <td><img class="glyph-medium" src="/images/files.png"/></td>
                            <td><a href="/files/{{ $folder->id() }}/{{ $folder->name }}">{{ $folder->name }}</a></td>
                            <td>Size</td>
                            <td><input class="checkbox" type="checkbox" name="checkbox[]" value="{{ $folder->id() }}"/></td>
                            <input type="hidden" name="name" value="{{ $folder->name }}"/>
                        </tr>
                    @endforeach
                </table>
                <button type="submit" name="delete-albums" id="delete-albums">Delete Albums</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form id="check-files" method="post" action="#">
                <table class="files-table">
                    @foreach ($files as $file)
                        <tr class="meta">
                            <td class="media"><a class="image_link" href="{{ asset('storage/'.$file->file_path) }}"><img class="ADMIN" src="{{ asset('storage/'.$file->thumb_path) }}"/></a></td>
                            <td class="td-title">{{ $file->name }}</td>
                            <td>{{ $file->user['username']}}</td>
                            <td class="td-category"><p>{{ $file->type }}</p></td>
                            <td>{{ $file->created_at }}</td>
                            <td class="td-btn"><a href="{{ $file->table.'/edit/'.$file->id().'/'.$file->getLink() }}"><img class="glyph-small link-btn" alt="edit-item" src="edit.png"/></a></td>
                            @if ($file->approved == 0 )
                                <td class="td-btn"><img class="glyph-small" alt="item-hidden-from-front-end-user" src="hide.png"/></td>
                            @elseif ($file->approved == 1 )
                                <td class="td-btn"><img class="glyph-small" alt="item-visible-for-front-end-user" src="'show.png"/></td>
                            @endif
                            <td class="td-btn"><p><input type="checkbox" name="checkbox[]" value="{{ $file->id() }}>"/></p></td>
                        </tr>
                    @endforeach
                </table>
                <button type="submit" name="delete" id="delete">Delete Selected</button>
                <button type="submit" name="download_files" id="download_files">Download files</button>
            </form>
        </div>
    </div>
</div>
@stop