@extends('front._layout.layout')

@section('seo_title','Contact Us')

@section('content')
 
<!-- Hero Section -->
<section style="background: url(/themes/front/img/hero.jpg); background-size: cover; background-position: center center" class="hero">
    <div class="container">

        <!--Bootstrap alert - Holy guacamole-->
        @if(!empty($systemMessage))
        <div class="alert alert-success alert-dismissible fade show" role="alert">                
            {{$systemMessage}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif


        <div class="row">
            <div class="col-lg-12">
                <h1>Have an interesting news or idea? Don't hesitate to contact us!</h1>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="col-lg-8"> 
            <div class="container">             

                @include('front.contact.partials.contact_form')                          

            </div>
        </main>

        <aside class="col-lg-4">

            <!-- Widget [Contact Widget]-->
            @include('front.contact.partials.widget_contact_info')

            <!-- Widget [Three Latest Posts]-->
            @include('front._layout.partials.widget_three_latest_posts')


        </aside>
    </div>
</div>

@endsection     