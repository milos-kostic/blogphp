<div class="post col-md-4">
    <div class="post-thumbnail">
        <a href="{{$post->getFrontUrl()}}">

            <img src="{{url($post->getPhoto1Url())}}" alt="..." class="img-fluid">
<!--            <img src="{{url($post->getPhoto2ThumbUrl())}}" alt="..." class="img-fluid">-->
        </a>
    </div>
    <div class="post-details">
        <div class="post-meta d-flex justify-content-between">
            <div class="date">20 May | 2016</div>
            <div class="category">
                <a href="{{$post->category->getFrontUrl()}}">
                    {{$post->category->name}}
                </a>
            </div>
        </div>
        <a href="{{$post->getFrontUrl()}}">
            <h3 class="h4">{{$post->name}}</h3>
        </a>
        <p class="text-muted">{{$post->description}}</p>
    </div>
</div>             