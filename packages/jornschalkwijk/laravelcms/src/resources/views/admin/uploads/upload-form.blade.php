<form class="dropzone" id="dropzone" enctype="multipart/form-data" method="post" action="{{ route('uploads.store') }}">
    {{ csrf_field() }}
    <label for="destination" class="form-check-label"><h4>Select Destination</h4></label>
    <select name="destination" class="form-control">
        <option value="0" selected>None</option>
        @foreach($folders as $f)
            <option value="{{$f->id()}}">{{$f->name}}</option>
        @endforeach
    </select><br>
    <input type="text" class="form-control" name="name" placeholder="New Folder" maxlength="60"/>
    @if(isset($folder) && $folder != null)
        <input type="hidden" name="parent" value="{{$folder->folder_id}}">
    @endif
    <input type="hidden" name="reload" value="{{(isset($reload)) ? $reload : true }}"/>
    <div class="fallback">
        <input type="hidden" name="MAX_FILE_SIZE" value="43500000"/>
        <label for="files[]" class="form-check-label">Choose File(max size: 3.5 MB): </label><br/>
        <input type="file" class="form-control" name="files[]" multiple/><br/>
        <button type="submit" class="form-control" name="submit">Add File('s)</button>
    </div>
</form>

@push('scripts')
    <script src="{{asset("/vendor/jornschalkwijk/LaravelCMS/assets/js/dropzone/min/dropzone.min.js")}}"></script>
    <script src="{{asset("/vendor/jornschalkwijk/LaravelCMS/assets/js/dropzoneOptions.js")}}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset("/vendor/jornschalkwijk/LaravelCMS/assets/js/dropzone/min/dropzone.min.css")}}"/>
@endpush
