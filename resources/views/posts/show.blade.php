@extends('layout')
@section('content')
	<div id="main-content">
		<div class="display">
				<h1>{{ $post->title }}</h1>
				<div class="container medium">
					{!! $post->content !!}
					{{ $post->category->title }}
				</div>
		</div>	
	</div>
@stop