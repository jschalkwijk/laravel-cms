<form id="dropzone" enctype="multipart/form-data" method="post" action="{{ route('uploads.store') }}">
    {{ csrf_field() }}
    <label for="destination" class="form-check-label"><h4>Select Destination</h4></label>
    <select name="destination" class="form-control">
        <option value="0" selected>None</option>
        @foreach($folders as $folder)
            <option value="{{$folder->id()}}">{{$folder->name}}</option>
        @endforeach
    </select><br>
    <input type="text" class="form-control" name="name" placeholder="New Folder" maxlength="60"/>
    @if(isset($folder) && $folder != null)
        <input type="hidden" name="parent" value="{{$folder->parent_id}}">
    @endif
    <input type="hidden" name="reload" value="{{(isset($reload)) ? $reload : true }}"/>
    <input type="hidden" name="MAX_FILE_SIZE" value="43500000"/>
    <label for="files[]" class="form-check-label">Choose File(max size: 3.5 MB): </label><br/>
    <input type="file" class="form-control" name="files[]" multiple/><br/>
    <button type="submit" class="form-control" name="submit">Add File('s)</button>
</form>