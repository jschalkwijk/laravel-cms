<div id="nav">
	<nav>
		<ul>
			<li><a href="'/">Home</a></li>
			<li><a href="/about">About Me</a></li>
			<li><a href="/skills">Skills</a></li>
			<li><a href="/portfolio">Portfolio</a></li>
			<li><a href="/blog">Blog</a></li>
			<li><a href="/contact">Contact</a></li>
			<?php
			$dbc = mysqli_connect('localhost','jorn','root123','laravelcms') or die ('Error connecting to server');
			$query = "SELECT * FROM pages";
			$links = mysqli_query($dbc,$query);
			?>
			
			@while($row = mysqli_fetch_array($links)) 
				@if($row['approved'] == 1) 
					<li><a href="{{ $row['path'] }}">{{ $row['title'] }}</a></li>
				@endif
			@endwhile
		</ul>
	</nav>
</div>