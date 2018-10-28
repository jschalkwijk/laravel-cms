@section('content')
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="row">
                @if(isset($folders))
                    @foreach($folders as $folder)
                        <div class="col">
                            <a href="{{ route('folders.show',$folder->id()) }}">
                                <img src="{{asset('/vendor/jornschalkwijk/LaravelCMS/assets/images/folder.png')}}">{{ $folder->name }}
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop