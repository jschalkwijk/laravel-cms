@extends('vendor.jornschalkwijk.laravelcms.templates.shop.layout.layout')
@section('content')
<!-- ##### Blog Wrapper Area Start ##### -->
<!-- ##### Breadcumb Area Start ##### -->
{{--<div class="breadcumb_area breadcumb-style-two bg-img">--}}
    {{--<div class="container h-100">--}}
        {{--<div class="row h-100 align-items-center">--}}
            {{--<div class="col-12">--}}
                {{--<div class="page-title text-center">--}}
                    {{--<h2>{{$post->title}}</h2>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<!-- ##### Breadcumb Area End ##### -->
<div class="single-blog-wrapper">

    <!-- Single Blog Post Thumb -->
    <div class="single-blog-post-thumb">
        <img src="{{ asset('/storage/'.$post->getFeatured()->path('large')) }}"/>
    </div>

    <!-- Single Blog Content Wrap -->
    <div class="single-blog-content-wrapper d-flex">

        <!-- Blog Content -->
        <div class="single-blog--text">
            <p>{{$post->content}}</p>
        </div>

        <!-- Related Blog Post -->
        <div class="related-blog-post">
            <!-- Single Related Blog Post -->
            <div class="single-related-blog-post">
                <img src="/vendor/jornschalkwijk/laravelcms/templates/shop/img/bg-img/rp1.jpg" alt="">
                <a href="#">
                    <h5>Cras lobortis nisl nec libero pulvinar lacinia. Nunc sed ullamcorper massa</h5>
                </a>
            </div>
            <!-- Single Related Blog Post -->
            <div class="single-related-blog-post">
                <img src="/vendor/jornschalkwijk/LaravelCMS/templates/shop/img/bg-img/rp2.jpg" alt="">
                <a href="#">
                    <h5>Fusce tincidunt nulla magna, ac euismod quam viverra id. Fusce eget metus feugiat</h5>
                </a>
            </div>
            <!-- Single Related Blog Post -->
            <div class="single-related-blog-post">
                <img src="/vendor/jornschalkwijk/LaravelCMS/templates/shop/img/bg-img/rp3.jpg" alt="">
                <a href="#">
                    <h5>Etiam leo nibh, consectetur nec orci et, tempus tempus ex</h5>
                </a>
            </div>
            <!-- Single Related Blog Post -->
            <div class="single-related-blog-post">
                <img src="/vendor/jornschalkwijk/LaravelCMS/templates/shop/img/bg-img/rp4.jpg" alt="">
                <a href="#">
                    <h5>Sed viverra pellentesque dictum. Aenean ligula justo, viverra in lacus porttitor</h5>
                </a>
            </div>
        </div>

    </div>
</div>
<!-- ##### Blog Wrapper Area End ##### -->
@stop