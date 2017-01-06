<nav>
	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="/admin">Dashboard</a></li>
		<li><a href="/admin/posts">Posts</a></li>
		<li><a href="/admin/pages">Pages</a></li>
		<li><a href="/admin/uploads">Files</a></li>
		<li><a href="/admin/contacts">Contacts</a></li>
		<li><a href="/admin/users">Users</a></li>
		<li><a href="/admin/products">Products</a></li>
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
	</ul>
</nav>
<div id="main">
    <div id="main-content" class="container-fluid">