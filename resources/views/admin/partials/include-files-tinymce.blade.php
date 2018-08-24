@section('content')
	<h2>Files</h2>
	<h2>Files</h2>
	<div class="row">
		<select id="image-selector" multiple="multiple" class="image-picker">
		@foreach ($files as $file)
			<div class="col-md-6">
				<option data-img-src="{{ asset('storage/'.$file->path('thumbnail')) }}"
						value="{{ asset('storage/'.$file->path()) }}">{{$file->name}}
				</option>
			</div>
		@endforeach
		</select>
	</div>

	<div class="row">
		<div class="col-md-6">
			<button id="add-multiple" name="add-multiple">Add Selection</button>
		</div>
	</div>

	{{--<div class="row text-center text-lg-left">--}}
		{{--@foreach ($files as $file)--}}
			{{--<div class="">--}}
				{{--<!--			// the value of the radio button corresponds to the actual file path -->--}}
				{{--<!--			// we can get this value with JS and then add the image with the correct src.-->--}}

				{{--<a class="d-block image_link" href="#">--}}
					{{--<input class="checkbox left" type="checkbox" name="checkbox[]" value="{{asset('storage/'.$file->path('thumbnail')) }}#{{ asset('storage/'.$file->path())}}"/>--}}

					{{--<img class="img-thumbnail image" src="{{ asset('storage/'.$file->path('thumbnail')) }}"--}}
						 {{--name="{{ asset('storage/'.$file->path()) }}"/>--}}
				{{--</a>--}}
			{{--</div>--}}
		{{--@endforeach--}}
	{{--</div>--}}
@endsection