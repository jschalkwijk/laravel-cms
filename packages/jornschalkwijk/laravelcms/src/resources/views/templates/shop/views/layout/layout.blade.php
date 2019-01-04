
<!DOCTYPE html>
<html lang="en">

<head>

<head>

    @include('vendor.jornschalkwijk.laravelcms.templates.shop.layout.head')

</head>

<body>


@include('vendor.jornschalkwijk.laravelcms.templates.shop.layout.nav')
@include('vendor.jornschalkwijk.laravelcms.templates.shop.layout.cart')

@yield('content')

@include('vendor.jornschalkwijk.laravelcms.templates.shop.layout.footer')

</body>

</html>