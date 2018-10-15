@section('content')
	<div class="row">
		<h2>Files</h2>
		<select id="image-search-selector" multiple="multiple" class="image-picker">
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
			<button id="add-from-search" name="add-from-search">Add Selection</button>
		</div>
	</div>
@endsection