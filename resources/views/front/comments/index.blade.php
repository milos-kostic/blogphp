@extends('front._layout.layout')

@section('seo_title', 'Comments')

@section('content')
<!-- Breadcumb Area -->
<div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>Comments</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('front.index.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Comments</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->

<!-- Checkout Step Area -->
<div class="checkout_steps_area">
    <a class="complated" href="{{route('front.comments.index')}}"><i class="icofont-check-circled"></i>Comments</a>
    <a class="active" href="{{route('front.checkout.index')}}"><i class="icofont-check-circled"></i> Checkout</a>
    <a href="{{route('front.checkout.index')}}" class="btn btn-primary d-block">Proceed To Checkout</a>
</div>
 
  
<!-- Cart Area -->
<div class="cart_area section_padding_100_70 clearfix" id="comments_table">

</div>
<!-- Cart Area End -->

@endsection
 

@push('footer_javascript')
<script>

</script>
@endpush