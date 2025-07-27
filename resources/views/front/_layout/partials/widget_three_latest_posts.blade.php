     
<div class="widget latest-posts">

    <header>
        <h3 class="h6">Latest Posts</h3>
    </header>

    <div class="blog-posts">
        
        @foreach($lastThreePostsMostVisitedLastMonth as $singlePost)
        <a href="{{$singlePost->getFrontUrl()}}">  
            <div class="item d-flex align-items-center">
                <div class="image"><img src="{{url($singlePost->getPhoto1ThumbUrl())}}" alt="..." class="img-fluid"></div>
                <div class="title"><strong>{{$singlePost->name}}</strong>
                    <div class="d-flex align-items-center">
                        <div class="views"><i class="icon-eye"></i>
                            {{$singlePost->views}}
                        </div>
                        <div class="comments"><i class="icon-comment"></i>
                             {{$singlePost->comments->count()}} 
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
        
    </div>

</div>