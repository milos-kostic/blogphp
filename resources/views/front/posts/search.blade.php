
@extends('front._layout.layout')

@section('seo_title','Blog Category')

@section('content')


<div class="container">

    <div class="row">

        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">

                @if($search)
                <h2 class="mb-3">Search results for "{{$search}}"</h2>
                @endif

                <div class="row">

                    @foreach($posts as $post)
                    <!-- post -->
                    <div class="post col-xl-6">
                        <div class="post-thumbnail">
                            <a href="{{$post->getFrontUrl()}}">
                                <img src="{{url($post->getPhoto1Url())}}" alt="..." class="img-fluid">
                            </a>
                        </div>                  
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <div class="date meta-last">20 May | 2016</div>
                                <div class="category">
                                    <a href="#">{{$post->category->name}}</a></div>
                            </div><a href="{{$post->getFrontUrl()}}">
                                <h3 class="h4">
                                    {{$post->name}}
                                </h3>
                            </a>
                            <p class="text-muted">
                                {{$post->description}}
                            </p>
                            <footer class="post-footer d-flex align-items-center">
                                <a href="{{route('front.posts.author',['user'=>$post->user])}}" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar">
                                        <img src="{{url($post->user->getPhotoUrl())}}" alt="..." class="img-fluid">
                                    </div>
                                    <div class="title">
                                        <span>
                                            {{optional($post->user)->name}}
                                        </span>
                                    </div>
                                </a>
                                <div class="date"><i class="icon-clock"></i>
                                    {{$post->updated_at->diffForHumans()}}  
                                </div>
                                <div class="comments meta-last"><i class="icon-comment"></i>12</div>
                            </footer>
                        </div>
                    </div>
                    @endforeach

                </div>

                <!-- Pagination -->
                
            </div>

            <!-- Pagination Area -->
            <div class="shop_pagination_area mt-30">
                <nav aria-label="Page navigation">
                    {{$posts->withQueryString()->links('pagination::bootstrap-4')}}
                </nav>
            </div>


        </main>
 

        <aside class="col-lg-4">


            <!-- Widget [Search Bar Widget]-->
            @include('front._layout.partials.widget_search_bar')


            <!-- Widget [Latest Posts Widget]        -->           
            @include('front._layout.partials.widget_three_latest_posts')

            <!-- Widget [Categories Widget]-->
            @include('front._layout.partials.widget_categories') 


            <!-- Widget [Tags Cloud Widget]-->
            @include('front._layout.partials.widget_tags')
 
        </aside>

    </div>
</div>

@endsection