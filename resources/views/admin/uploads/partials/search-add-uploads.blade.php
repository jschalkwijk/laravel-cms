{{-- Searching uploads--}}
<div id="add-image">
    <form class="search">
        {{ csrf_field() }}
        <input class="form-control mr-sm-2" type="text" id="search" name='search' placeholder="Search" aria-label="Search">
        <button id="search-file" class="btn btn-outline-success my-2 my-sm-0" name="search-file">Search</button>
    </form>
    <div id="search-results">
        {{-- JS will insert the results here--}}
    </div>
</div>
{{-- Creating ,showing and adding uploads to a gallery--}}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <select id="gallery" name="gallery">
                    <option value="None">None</option>
                    @foreach($galleries as $gallery)
                        <option value="{{$gallery->gallery_id}}">{{$gallery->name}}</option>
                    @endforeach
                </select>
            </div>
            <button id="add-gallery" name="add-gallery">Add Gallery</button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form>
                    {{ csrf_field() }}
                    <input type="text" id="name" name="name" placeholder="name">
                    <button id="create-gallery" name="create-gallery">Create Gallery</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="selected-gallery">
    {{-- JS will insert the gallary here--}}
</div>
@push('scripts')
<script src="{{ asset('js/tinymceAddFiles.js') }}"></script>
@endpush
@push('scripts')
<script src="{{ asset('js/image-picker/image-picker.js') }}"></script>
@endpush
@push('styles')
<link rel="stylesheet" href="{{ asset('js/image-picker/image-picker.css') }}"/>
@endpush