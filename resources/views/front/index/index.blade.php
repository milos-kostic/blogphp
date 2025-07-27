
@extends('front._layout.layout')

@section('seo_title','Blog Home')

@section('content')

<!-- Hero Section-->
<div id="index-slider" class="owl-carousel">    
    @foreach($slides as $slide)
    @include('front.index.single_slide', [
    'slide' => $slide
    ])
    @endforeach
</div>


<!-- Intro Section-->
<section class="intro">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="h3">Some great intro here</h2>
                <p class="text-big">Place a nice <strong>introduction</strong> here <strong>to catch reader's attention</strong>.</p>
            </div>
        </div>
    </div>
</section>



<!--Three latest important posts-->
<section class="featured-posts no-padding-top">
    <div class="container"> 
        <!-- Posts -->
        @for($i = 0; $i<3; $i++)
        @include('front.index.partials.single_post',['i'=>$i])
        @endfor        
    </div>
</section>



<!-- Divider Section-->
<section style="background: url(/themes/front/img/divider-bg.jpg); background-size: cover; background-position: center bottom" class="divider">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</h2>
                <a href="{{route('front.contact.index')}}" class="hero-link">Contact Us</a>
            </div>
        </div>
    </div>
</section>


<!-- Latest 12 Posts -->
<section class="latest-posts"> 
    <div class="container">
        <header> 
            <h2>Latest from the blog</h2>
            <p class="text-big">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </header>
        <div class="owl-carousel" id="latest-posts-slider">             
            @include('front.index.partials.latest_12_posts')             
        </div>        
    </div>
</section>


<!-- Gallery Section-->
<section class="gallery no-padding">    
    <div class="row">
        @include('front.index.partials.gallery')
    </div>
</section>


@endsection