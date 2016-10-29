@extends('layout')
@section('content')
	<div id="main-content">
		<div class="display">
			<h1>All Cards</h1>
			<ul>
			@foreach ($cards as $card)
				<li><a href="/cards/{{ $card->id }}">{{ $card->title }}</a><li>
			@endforeach
			</ul>
		</div>	
	</div>
@stop