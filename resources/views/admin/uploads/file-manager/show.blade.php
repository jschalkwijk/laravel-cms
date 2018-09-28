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
                <a id="back" href="{{url($back)}}">Back</a>
                <div class="center">
                    @include('admin.uploads.upload-form',['reload'=> 0])
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                <div class="row">
                    @if(isset($folders))
                        @foreach($folders as $folder)
                            <div class="col">
                                <a href="{{ route('folders.show',$folder->id()) }}">
                                    <img src="{{asset('images/folder.png')}}">{{ $folder->name }}
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <?php  /*system('find '.storage_path('app/public/uploads').' -empty -type d -delete')*/; ?>
        @if(isset($uploads))
            <div class="row">
                <select id="image-folder-selector" multiple="multiple" class="image-picker">
                    @foreach ($uploads as $upload)
                        <div class="col">
                            <option id="{{$upload->upload_id}}" data-img-src="{{ asset('storage/'.$upload->path('thumbnail')) }}"
                                    value="{{ asset('storage/'.$upload->path()) }}">{{$upload->name}}
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
        @endif
    </div>
@append
