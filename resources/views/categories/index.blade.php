@extends('layout')
@section('content')
	<div id="main-content">
		<div class="display">
			<h1>All Categories</h1>
			<ul>
			@foreach ($categories as $cat)
				<li><a href="/categories/{{ $cat->category_id }}">{{ $cat->title }}</a><li>
			@endforeach
			</ul>
		</div>	
	</div>
@stop