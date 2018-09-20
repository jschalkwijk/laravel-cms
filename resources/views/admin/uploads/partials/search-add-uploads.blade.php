<!-- Add an optional button to open the popup -->
{{-- Upload Images --}}
<div class="row">
    <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
        <div class="center">
            @include('admin.uploads.upload-form',['reload'=> 0])
        </div>
    </div>
</div>

<div class="row">
    <button class="my_popup_open">Open popup</button>
    <div id="my_popup" class="col-xs-5 col-sm-5 col-md-5">
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
                        <select id="gallery" name="gallery" class="form-control">
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
                            <input type="text" id="name" name="name" placeholder="name" class="form-control">
                            <button id="create-gallery" name="create-gallery">Create Gallery</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="selected-gallery">
            {{-- JS will insert the gallary here--}}
        </div>

        <div id="folders">

        </div>
        <button class="my_popup_close">Close</button>
    </div>
</div>
<!-- Include jQuery Popup Overlay -->
<script src="https://cdn.rawgit.com/vast-engineering/jquery-popup-overlay/1.7.13/jquery.popupoverlay.js"></script>
<script>
    $('#my_popup').popup({
        opacity: 0.3,
        transition: 'all 0.3s',
        horizontal: 'right',
        vertical: 'top'
    });
</script>
@push('scripts')
<script src="{{ asset('js/tinymceAddFiles.js') }}"></script>
@endpush
@push('scripts')
<script src="{{ asset('js/image-picker/image-picker.js') }}"></script>
@endpush
@push('styles')
<link rel="stylesheet" href="{{ asset('js/image-picker/image-picker.css') }}"/>
@endpush