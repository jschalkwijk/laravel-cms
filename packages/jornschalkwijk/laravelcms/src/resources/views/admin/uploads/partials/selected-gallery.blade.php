@section('content')
    <div class="row">
        <div class="col-md-6">
            <button id="add-to-gallery" name="add-to-gallery">Add To Gallery</button>
        </div>
    </div>
    <div class="row">
        <h2 class="my-4 text-center text-lg-left">{{$gallery->name}}</h2>
        <select id="gallery-image-selector" multiple="multiple" class="image-picker">
            @foreach ($uploads as $upload)
                <div class="col-md-6">
                    <option id="{{$upload->upload_id}}" data-img-src="{{ asset('storage/'.$upload->path('thumbnail')) }}"
                            value="{{ asset('storage/'.$upload->path()) }}">{{$upload->name}}
                    </option>
                </div>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-6">
            <button id="remove-from-gallery" name="remove-from-gallery">Remove From Gallery</button>
        </div>
    </div>
@stop