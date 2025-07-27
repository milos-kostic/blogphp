    
@extends('front._layout.layout')

@section('seo_title', $user->name)
@section('seo_image', $user->getPhotoUrl())

@section('content')


<div class="container">
    <div class="row">

        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3 author d-flex align-items-center flex-wrap">
                    <div class="avatar">
                        <img src="{{url($user->getPhotoUrl())}}" alt="..." class="img-fluid rounded-circle">
                    </div>
                    <div class="title">
                        <span>Posts by author "{{$user->name}}"</span>
                    </div>
                </h2>
                <hr>
                <div class="row">


                    @foreach($relatedPosts as $singlePost)

                    <!-- post -->
                    <div class="post col-xl-6">
                        <div class="post-thumbnail">
                            <a href="{{$singlePost->getFrontUrl()}}">
                                <img src="{{url($singlePost->getPhoto1Url())}}" alt="..." class="img-fluid">
                            </a>
                        </div>
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <div class="date meta-last">
                                    {{\Carbon\Carbon::parse($singlePost->created_at)->isoFormat('DD MMM | YYYY')}}  
                                </div>
                                <div class="category"> 
                                    @if($singlePost->category->name!="Uncategorized")
                                    <a href="{{$singlePost->category->getFrontUrl()}}">
                                        {{$singlePost->category->name}}
                                    </a>
                                    @else
                                    <a href="#">Uncategorized</a>
                                    @endif 
                                </div>
                            </div>

                            <a href="{{$singlePost->getFrontUrl()}}">                                    
                                <h3 class="h4">{{$singlePost->name}}</h3>
                            </a>

                            <p class="text-muted">{{$singlePost->description}}</p>
                            <footer class="post-footer d-flex align-items-center">
                                <a href="#" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar">
                                        <img src="{{url($user->getPhotoUrl())}}" alt="..." class="img-fluid"></div>
                                    <div class="title">
                                        <span>
                                            {{optional($singlePost->user)->name}}
                                        </span>
                                    </div>
                                </a>
                                <div class="date"><i class="icon-clock"></i>
                                    {{$singlePost->updated_at->diffForHumans()}}  
                                </div>
                                <div class="comments meta-last">
                                    <i class="icon-comment"></i>
                                    {{$singlePost->comments->count()}} 
                                </div>
                            </footer>
                        </div>
                    </div>
                    @endforeach

                </div>

                <hr>
                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-template d-flex justify-content-center">
      
                        {{$relatedPosts->withQueryString()->links('pagination::bootstrap-4')}} 
                    </ul>
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