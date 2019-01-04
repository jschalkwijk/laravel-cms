<!-- ##### Header Area Start ##### -->
<header class="header_area">
	<div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
		<!-- Classy Menu -->
		<nav class="classy-navbar" id="templateNav">
			<!-- Logo -->
			<a class="nav-brand" href="../index"><img src="#" alt=""></a>
			<!-- Navbar Toggler -->
			<div class="classy-navbar-toggler">
				<span class="navbarToggler"><span></span><span></span><span></span></span>
			</div>
			<!-- Menu -->
			<div class="classy-menu">
				<!-- close btn -->
				<div class="classycloseIcon">
					<div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
				</div>
				<!-- Nav Start -->
				<div class="classynav">
					<ul>
						<li><a href="#">Shop</a>
							<div class="megamenu">
								<ul class="single-mega cn-col-4">
									<li class="title">Women's Collection</li>
									<li><a href="../shop">Dresses</a></li>
									<li><a href="../shop">Blouses &amp; Shirts</a></li>
									<li><a href="../shop">T-shirts</a></li>
									<li><a href="../shop">Rompers</a></li>
									<li><a href="../shop">Bras &amp; Panties</a></li>
								</ul>
								<ul class="single-mega cn-col-4">
									<li class="title">Men's Collection</li>
									<li><a href="../shop">T-Shirts</a></li>
									<li><a href="../shop">Polo</a></li>
									<li><a href="../shop">Shirts</a></li>
									<li><a href="../shop">Jackets</a></li>
									<li><a href="../shop">Trench</a></li>
								</ul>
								<ul class="single-mega cn-col-4">
									<li class="title">Kid's Collection</li>
									<li><a href="../shop">Dresses</a></li>
									<li><a href="../shop">Shirts</a></li>
									<li><a href="../shop">T-shirts</a></li>
									<li><a href="../shop">Jackets</a></li>
									<li><a href="../shop">Trench</a></li>
								</ul>
								<div class="single-mega cn-col-4">
									<img src="/vendor/jornschalkwijk/LaravelCMS/templates/shop/img/bg-img/bg-6.jpg" alt="">
								</div>
							</div>
						</li>
						<li><a href="#">Pages</a>
							<ul class="dropdown">
								<li><a href="../index">Home</a></li>
								<li><a href="../shop">Shop</a></li>
								<li><a href="../single-product-details">Product Details</a></li>
								<li><a href="../checkout">Checkout</a></li>
								<li><a href="../blog">Blog</a></li>
								<li><a href="../single-blog">Single Blog</a></li>
								<li><a href="../regular-page">Regular Page</a></li>
								<li><a href="../contact">Contact</a></li>
							</ul>
						</li>
						<li><a href="../blog">Blog</a></li>
						<li><a href="../contact">Contact</a></li>
					</ul>
				</div>
				<!-- Nav End -->
			</div>
		</nav>

		<!-- Header Meta Data -->
		<div class="header-meta d-flex clearfix justify-content-end">
			<!-- Search Area -->
			<div class="search-area">
				<form action="#" method="post">
					<input type="search" name="search" id="headerSearch" placeholder="Type for search">
					<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</form>
			</div>
			<!-- Favourite Area -->
			<div class="favourite-area">
				<a href="#"><img src="/vendor/jornschalkwijk/laravelcms/templates/shop/img/nav/heart.svg" alt=""></a>
			</div>
			<!-- User Login Info -->
			<div class="user-login-info">
				<a href="#"><img src="/vendor/jornschalkwijk/laravelcms/templates/shop//img/nav/user.svg" alt=""></a>
			</div>
			<!-- Cart Area -->
			<div class="cart-area">
				<a href="#" id="templateCartBtn"><img src="/vendor/jornschalkwijk/laravelcms/templates/shop/img/cart/bag.svg" alt=""> <span>{{$cart->itemCount()}}</span></a>
			</div>
		</div>

	</div>
</header>
<!-- ##### Header Area End ##### -->