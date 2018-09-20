@section('content')
    <div class="container-fluid">
        <div class="row" >
            <h1 class="my-4 text-center text-lg-left">Selected Gallery</h1>
        </div>

        <div class="row text-center text-lg-left">
            @foreach($uploads as $upload)
            <div class="col-lg-3 col-md-4 col-xs-6">
                <a href="{{asset('storage/'.$upload->path()) }}" class="d-block mb-4 h-100">
                    <img class="img-thumbnail" src="{{asset('storage/'.$upload->path('thumbnail'))}}" alt="">
                </a>
            </div>
            @endforeach
        </div>

    </div>
@stop