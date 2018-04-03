@extends('templates.default.layout')
@section('content')
	<div id="main-content">
		<div class="display">
			<h1>All posts</h1>
		</div>
		<div class="container">	
			@foreach ($posts as $post)
					<article>
						<h1><a class="article-title"  href="/posts/{{ $post->post_id }}">{{ $post->title }}</a></h1>
						<p class="article-meta"><img class="glyph-small" src="/images/author.png"/>
							<span>{{ $post->author }}</span> <img class="glyph-small" src="/images/time.png"/>
							<img class="glyph-small" src="/images/category.png"/>
							<span><a href="/categories/{{ $post->category['category_id'] }}"> {{ $post->category['title'] }} </a></span>
							<img class="glyph-small" src="/images/comments.png"/>
							<span> 5 </span>
						</p>
						<div class="article-content"><p>{{ $post->description }}</p>
						<button class="read-more"><a href="/posts/{{ $post->post_id }}">Read More</a></button></div><br />
					</article>	
			@endforeach
		</div>
	</div>
@stop