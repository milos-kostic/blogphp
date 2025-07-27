<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="logo">
                    <h6 class="text-white">Bootstrap Blog</h6>
                </div>
                <div class="contact-details">
                    <p>53 Broadway, Broklyn, NY 11249</p>
                    <p>Phone: (020) 123 456 789</p>
                    <p>Email: <a href="mailto:info@company.com">Info@Company.com</a></p>
                    <ul class="social-menu">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-behance"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="menus d-flex">
                    <ul class="list-unstyled">
                        <li> <a href="{{route('front.index.index')}}">Home</a></li>
                        <li> <a href="{{route('front.posts.index')}}">Blog</a></li>
                        <li> <a href="{{route('front.contact.index')}}">Contact</a></li>
                        <li> <a href="{{route('login')}}">Login</a></li>
                    </ul>
                    @include('front._layout.partials.footer_categories')
                </div>
            </div>

            <div class="col-md-4">
                <div class="latest-posts">

                    @foreach($lastThreePosts as $post)
                    <a href="{{$post->getFrontUrl()}}">
                        <div class="post d-flex align-items-center">
                            <div class="image"><img src="{{url($post->getPhoto1ThumbUrl())}}" alt="..." class="img-fluid"></div>
                            <div class="title">
                                <strong>{{$post->name}}</strong>
                                <span class="date last-meta">{{\Carbon\Carbon::parse($post->created_at)->isoFormat('MMMM DD, YYYY')}}</span>
                            </div> 
                        </div>
                    </a>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
    <div class="copyrights">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2017. All rights reserved. Your great site.</p>
                </div>
                <div class="col-md-6 text-right">
                    <p>Template By <a href="https://bootstrapious.com/p/bootstrap-carousel" class="text-white">Bootstrapious</a>
                        <!-- Please do not remove the backlink to Bootstrap Temple unless you purchase an attribution-free license @ Bootstrap Temple or support us at http://bootstrapious.com/donate. It is part of the license conditions. Thanks for understanding :)                         -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>