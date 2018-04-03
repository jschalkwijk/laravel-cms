@extends('templates.default.layout')
@section('content')
	<div id="main-content">
		<div class="display">
			<h1>{{ $category->title }}</h1>
			
				<h2>Posts</h2>
				@foreach($category->posts as $post)
					{{$post->title}}
				@endforeach	
		</div>	
	</div>
@stop