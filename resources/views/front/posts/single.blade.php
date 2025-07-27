
@extends('front._layout.layout')

@section('seo_title', $post->name)
@section('seo_description', $post->description)
@section('seo_image', $post->getPhoto1Url())
@section('seo_og_type', 'post')

@section('head_meta')
<meta property="post:visits:amount" content="{{$post->counter}}">
<meta property="post:visits:comment" content="times visited">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="post blog-post col-lg-8"> 
            <div class="container">
                <div class="post-single">
                    <div class="post-thumbnail">
                        <img src="{{$post->getPhoto1Url()}}" alt="..." class="img-fluid">
                    </div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="category">
                                @if(optional($post->category)->name!="Uncategorized")
                                <a href="{{optional($post->category)->getFrontUrl()}}">
                                    {{optional($post->category)->name}}
                                </a>
                                @else
                                <a href="#">Uncategorized</a>
                                @endif 
                            </div>
                            <div class="date meta-last">
                                {{\Carbon\Carbon::parse($post->created_at)->isoFormat('DD MMM | YYYY')}} 
                            </div>
                        </div>
                        <h1>{{$post->name}}<a href="#">
                                <i class="fa fa-bookmark-o"></i>
                            </a>
                        </h1>      
                        <div class="post-footer d-flex align-items-center flex-column flex-sm-row">
                            <a href="{{$post->user->getFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar">
                                    <img src="{{url($post->user->getPhotoUrl())}}" alt="..." class="img-fluid">
                                </div>
                                <div class="title">
                                    <span>{{$post->user->name}}</span>
                                </div>
                            </a>
                            <div class="d-flex align-items-center flex-wrap">       
                                <div class="date"><i class="icon-clock"></i>
                                    {{$updatedTimeBeforeIncrementViews->diffForHumans()}}   
                                </div>
                                <div class="views"><i class="icon-eye"></i>
                                    {{$post->views}} 
                                </div>
                                <div class="comments meta-last">
                                    <a href="#post-comments">
                                        <i class="icon-comment"></i>
                                        {{$post->comments->count()}} 
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="post-body">
                            <p class="lead">{{$post->description}}</p>
                            <!--<p>{{html_entity_decode($post->body)}}</p>-->
                            <p>{!!($post->body)!!}</p>
                        </div> 

                        <!-- [ Related Tags Partial ]-->
                        @include('front.posts.partials.related_tags',['post'=>$post])


                        <!--Prev Next post-->
                        <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">
                            <a href="{{optional($post->previous())->getFrontUrl()}}" class="prev-post text-left d-flex align-items-center">
                                <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                                <div class="text">
                                    <strong class="text-primary">
                                        Previous Post
                                    </strong>
                                    <h6>{{\Str::limit(optional($post->previous())->name,25)}}</h6>
                                </div>
                            </a>
                            <a href="{{optional($post->next())->getFrontUrl()}}" class="next-post text-right d-flex align-items-center justify-content-end">
                                <div class="text">
                                    <strong class="text-primary">
                                        Next Post
                                    </strong>
                                    <h6>{{\Str::limit(optional($post->next())->name,25)}}</h6>
                                </div>
                                <div class="icon next"><i class="fa fa-angle-right">   </i></div>
                            </a>
                        </div>



                        <!-- COMMENTS -->
                        <div class="post-comments" id="post-comments">
                            
                            <!--AJAX UCITAVA KOMENTARE:--><!-- [ Comments AJAX ]-->                           

                            @include('front._layout.comments_ajax',[
                            'post'=>$post,
                            ]) 

                            <!-- ajax list comments end -->

 

                        </div>
                        <!-- /.card-body -->

                        <!--                        
                        <div class="card-footer clearfix">

                        </div>
                        -->

                        <!-- ADD COMMENT: -->
                        <div class="add-comment">
                            <header>
                                <h3 class="h6">Leave a reply</h3>
                            </header>

                            @include('front.posts.partials.add_comment_form_ajax',[
                            'post'=>$post,
                            ])
                            <!--dostupan je parametar i ako se ne prosledi ali je praksa ovako-->

                        </div>
                        <!-- add comment. -->


                    </div>
                </div>
            </div>
        </main>

 
        <aside class="col-lg-4">

            <!-- Widget [Search Bar Widget]-->
            @include('front._layout.partials.widget_search_bar')


            <!-- Widget [Latest Posts Widget]        -->           
            @include('front._layout.partials.widget_three_latest_posts', [
            'relatedPosts'=>$relatedPosts,
            ])

            <!-- Widget [Categories Widget]-->
            @include('front._layout.partials.widget_categories') 


            <!-- Widget [Tags Cloud Widget]-->
            @include('front._layout.partials.widget_tags')

        </aside>

    </div>
</div>
@endsection
 

@push('footer_javascript')
<script type="text/javascript">

    commentsFrontRefresh_ajax(); //  

</script>
@endpush