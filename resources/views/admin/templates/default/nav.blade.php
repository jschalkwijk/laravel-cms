{{--<nav>--}}
	{{--<ul>--}}
		{{--<li><a href="/">Home</a></li>--}}
		{{--<li><a href="/admin">Dashboard</a></li>--}}
		{{--<li><a href="/admin/posts">Posts</a></li>--}}
		{{--<li><a href="/admin/pages">Pages</a></li>--}}
		{{--<li><a href="/admin/uploads">Files</a></li>--}}
		{{--<li><a href="/admin/contacts">Contacts</a></li>--}}
		{{--<li><a href="/admin/users">Users</a></li>--}}
		{{--<li><a href="/admin/products">Products</a></li>--}}
		{{--<li><a href="/admin/cart">Cart(0)</a></li>--}}
		{{--<li><a href="/admin/search"><img class="glyph-medium" alt="search" src="search-1.png"/></a></li>--}}
        {{--<li>--}}
            {{--<a href="{{ url('/logout') }}"--}}
                {{--onclick="event.preventDefault();--}}
                {{--document.getElementById('logout-form').submit();">--}}
                {{--Logout--}}
            {{--</a>--}}
            {{--<form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">--}}
                {{--{{ csrf_field() }}--}}
            {{--</form>--}}
        {{--</li>--}}
	{{--</ul>--}}
{{--</nav>--}}
{{--<div class="navbar navbar-inverse navbar-fixed-left">--}}
	{{--<a class="navbar-brand" href="#">Brand</a>--}}
	{{--<ul class="nav navbar-nav">--}}
		{{--<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>--}}
			{{--<ul class="dropdown-menu" role="menu">--}}
				{{--<li><a href="#">Sub Menu1</a></li>--}}
				{{--<li><a href="#">Sub Menu2</a></li>--}}
				{{--<li><a href="#">Sub Menu3</a></li>--}}
				{{--<li class="divider"></li>--}}
				{{--<li><a href="#">Sub Menu4</a></li>--}}
				{{--<li><a href="#">Sub Menu5</a></li>--}}
			{{--</ul>--}}
		{{--</li>--}}
		{{--<li><a href="#">Link2</a></li>--}}
		{{--<li><a href="#">Link3</a></li>--}}
		{{--<li><a href="#">Link4</a></li>--}}
		{{--<li><a href="#">Link5</a></li>--}}
	{{--</ul>--}}
{{--</div>--}}
{{--<div class="container">--}}
	{{--<div class="row">--}}
		{{--<h2>Left side Navigation bar (Fixed)</h2>--}}

		{{--<p>Left side Navigation</p>--}}
	{{--</div>--}}
{{--</div>--}}
<nav class="navbar navbar-inverse bg-inverse navbar-fixed-left">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="#">CMS</a>
		</div>
		<div id="navbar" class="nav-collapse collapse show">
			<ul class="nav navbar-nav navbar-inverse">
				<li><a href="/">Home</a></li>
				<li><a href="/admin">Dashboard</a></li>
				<li class="dropdown">
					<a href="{{route('posts.index')}}">Posts</a>
					<a href="{{route('posts.index')}}" class="dropdown-toggle" data-toggle="dropdown" role="link" aria-haspopup="true" aria-expanded="false"></a>
					<ul class="dropdown-menu navbar-inverse bg-inverse">
						<li><a href="{{route('posts.create')}}">New Post</a></li>
						<li class="dropdown-header">Categories</li>
						<li><a href="{{route('categories.index')}}">Categories</a></li>
						<li><a href="{{route('categories.create')}}">New Category</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="{{route('pages.index')}}">Pages</a>
					<a href="{{route('pages.index')}}" class="dropdown-toggle" data-toggle="dropdown" role="link" aria-haspopup="true" aria-expanded="false"></a>
					<ul class="dropdown-menu navbar-inverse bg-inverse">
						<li><a href="{{route('pages.create')}}">New Page</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="{{route('uploads.index')}}">Uploads</a>
					<a href="{{route('uploads.index')}}" class="dropdown-toggle" data-toggle="dropdown" role="link" aria-haspopup="true" aria-expanded="false"></a>
					<ul class="dropdown-menu navbar-inverse bg-inverse">
						<li><a href="{{route('uploads.create')}}">New File</a></li>
						<li class="dropdown-header">Folders</li>
						<li><a href="{{route('folders.index')}}">Folders</a></li>
						<li><a href="{{route('folders.create')}}">New Folder</a></li>
					</ul>
				</li>
				<li><a href="/admin/contacts">Contacts</a></li>
				<li class="dropdown">
					<a href="{{route('users.index')}}">Users</a>
					<a href="{{route('users.index')}}" class="dropdown-toggle" data-toggle="dropdown" role="link" aria-haspopup="true" aria-expanded="false"></a>
					<ul class="dropdown-menu navbar-inverse bg-inverse">
						<li><a href="{{route('users.create')}}">New User</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="{{route('products.index')}}">Products</a>
					<a href="{{route('products.index')}}" class="dropdown-toggle" data-toggle="dropdown" role="link" aria-haspopup="true" aria-expanded="false"></a>
					<ul class="dropdown-menu navbar-inverse bg-inverse">
						<li><a href="{{route('products.create')}}">Create</a></li>
						<li class="dropdown-header">Categories</li>
						<li><a href="{{route('categories.index')}}">Categories</a></li>
						<li><a href="{{route('categories.create')}}">New Category</a></li>
					</ul>
				</li>
				<li><a href="/admin/cart">Cart(0)</a></li>
				<li><a href="/admin/search"><img class="glyph-medium" alt="search" src="search-1.png"/></a></li>
				<li>
					<a href="{{ url('/logout') }}"
					   onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
						Logout
					</a>
					<form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</li>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown </a>
				<ul class="dropdown-menu navbar-inverse bg-inverse">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li role="separator" class="divider"></li>
					<li class="dropdown-header">Nav header</li>
					<li><a href="#">Separated link</a></li>
					<li><a href="#">One more separated link</a></li>
				</ul>
			</li>
			<form class="form-inline" method="GET" action="{{route('search.index')}}">
				<input class="form-control mr-sm-2" type="search" name='search' placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</div>
</nav>
    <div class="container-fluid">