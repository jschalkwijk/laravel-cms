<div class="row">
    <select id="image-folder-selector" multiple="multiple" class="image-picker">
        @foreach ($uploads as $upload)
            <div class="col">
                <option id="{{$upload->upload_id}}" data-img-src="{{ asset('/storage/'.$upload->path('thumbnail')) }}"
                        value="{{ asset('/storage/'.$upload->path()) }}">{{$upload->name}}
                </option>
            </div>
        @endforeach
    </select>
    <div class="row">
        <div class="col-md-6">
            <button id="add-multiple" name="add-multiple">Add Selection</button>
        </div>
    </div>
</div>
