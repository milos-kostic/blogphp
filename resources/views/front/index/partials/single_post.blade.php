<div class="row d-flex align-items-stretch">
    @if($i%2)
    <!--<div class="image col-lg-5">-->   
    <div class="col-lg-5">         
        <img src="{{url($lastThreeImportantPosts[$i]->getPhoto1Url())}}" alt="..."  class="img-fluid">
    </div>
    <div class="text col-lg-7">
        <div class="text-inner d-flex align-items-center">
            <div class="content">
                <header class="post-header">
                    <div class="category">
                        <a href="{{optional($lastThreeImportantPosts[$i]->category)->getFrontUrl()}}">
                            {{optional($lastThreeImportantPosts[2]->category)->name}}
                        </a>
                    </div>
                    <a href="{{$lastThreeImportantPosts[$i]->getFrontUrl()}}">
                        <h2 class="h4">{{$lastThreeImportantPosts[$i]->name}}</h2>
                    </a>
                </header>
                <p>{{Str::limit($lastThreeImportantPosts[$i]->description,200)}}</p>
                <footer class="post-footer d-flex align-items-center">
                    <a href="{{$lastThreeImportantPosts[$i]->user->getFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                        <div class="avatar">
                            <img src="{{url($lastThreeImportantPosts[$i]->user->getPhotoUrl())}}" alt="..." class="img-fluid"></div>
                        <div class="title">
                            <span>
                                {{$lastThreeImportantPosts[$i]->user->name}}
                            </span>
                        </div>
                    </a>
                    <div class="date"><i class="icon-clock"></i>
                        {{$lastThreeImportantPosts[$i]->updated_at->diffForHumans()}} 
                    </div>
                    <div class="comments"><i class="icon-comment"></i>
                        {{$lastThreeImportantPosts[$i]->comments->count()}} 
                    </div>
                </footer>
            </div>
        </div>
    </div>   
    @else  
    <div class="text col-lg-7">
        <div class="text-inner d-flex align-items-center">
            <div class="content">
                <header class="post-header">
                    <div class="category">
                        <a href="{{optional($lastThreeImportantPosts[$i]->category)->getFrontUrl()}}">
                            {{optional($lastThreeImportantPosts[$i]->category)->name}}
                        </a>
                    </div>
                    <a href="{{$lastThreeImportantPosts[$i]->getFrontUrl()}}">
                        <h2 class="h4">{{$lastThreeImportantPosts[$i]->name}}</h2>
                    </a>
                </header>
                <p>{{Str::limit($lastThreeImportantPosts[$i]->description,200)}}</p>
                <footer class="post-footer d-flex align-items-center">
                    <a href="{{$lastThreeImportantPosts[$i]->user->getFrontUrl()}}" class="author d-flex align-items-center flex-wrap">
                        <div class="avatar">
                            <img src="{{url($lastThreeImportantPosts[$i]->user->getPhotoUrl())}}" alt="..." class="img-fluid"></div>
                        <div class="title">
                            <span>
                                {{$lastThreeImportantPosts[$i]->user->name}}
                            </span>
                        </div>
                    </a>
                    <div class="date"><i class="icon-clock"></i>
                        {{$lastThreeImportantPosts[$i]->updated_at->diffForHumans()}} 
                    </div>
                    <div class="comments"><i class="icon-comment"></i>
                        {{$lastThreeImportantPosts[$i]->comments->count()}} 
                    </div>
                </footer>
            </div>
        </div>
    </div>   
    <!--<div class="image col-lg-5">-->         
    <div class="col-lg-5">         
        <img src="{{url($lastThreeImportantPosts[$i]->getPhoto1Url())}}" alt="..."  class="img-fluid">
    </div>
    @endif
</div>