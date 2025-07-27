
@extends('front._layout.layout')

@section('seo_title','Blog Home')
@section('seo_description', 'Read our posts')

@section('content')


<div class="container">
    <div class="row">

        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 


            <div class="container">


                <div class="row">



                    @foreach($allPostsByDate as $singlePost)

                    <!-- post -->
                    <div class="post col-xl-6">
                        <div class="post-thumbnail">
                            <a href="{{$singlePost->getFrontUrl()}}">
                                <img 
                                    src="{{url($singlePost->getPhoto1Url())}}" 
                                    alt="..." 
                                    class="img-fluid"
                                    >
                            </a>
                        </div>
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <!--                         format:  20 May | 2016 -->
                                <div 
                                    class="date meta-last"
                                    >
                                    {{\Carbon\Carbon::parse($singlePost->created_at)->isoFormat('DD MMM | YYYY')}}                                  
                                </div>
                                <div class="category"> 
                                    @if(optional($singlePost->category)->name!="Uncategorized")
                                    <a href="{{optional($singlePost->category)->getFrontUrl()}}">
                                        {{optional($singlePost->category)->name}}
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

                                <a href="{{$singlePost->user->getFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar">
                                        <img src="{{url($singlePost->user->getPhotoUrl())}}" alt="..." class="img-fluid">
                                    </div>
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
 
                    <!--  Pagination Area -->
                    
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-template d-flex justify-content-center">
                            {{$allPostsByDate->withQueryString()->links('pagination::bootstrap-4')}} 
                        </ul>
                    </nav>
                </div>

        </main>
 

        <aside class="col-lg-4">


            <!-- Widget [Search Bar Widget]-->
            @include('front._layout.partials.widget_search_bar')

            <!-- Widget [Latest Posts Widget]        -->        
            @include('front._layout.partials.widget_three_latest_posts')


<!--             Widget [Categories Widget] first five categories -->
            @include('front._layout.partials.widget_categories')


            <!-- Widget [Tags Cloud Widget]-->
            @include('front._layout.partials.widget_tags')

 
        </aside>


    </div>
</div>


@endsection


