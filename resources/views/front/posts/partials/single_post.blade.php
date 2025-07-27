<!-- post -->
<div class="post col-xl-6">
    <div class="post-thumbnail">
        <a href="blog-post.html">
            <img 
                src="{{url($post->getPhoto1ThumbUrl())}}" 
                alt="..." 
                class="img-fluid"
                >
        </a>
    </div>
    <div class="post-details">
        <div class="post-meta d-flex justify-content-between">
            <div class="date meta-last">20 May | 2016</div>
            <div class="category"><a href="blog-category.html">Business</a></div>
        </div><a href="{{$post->getFrontUrl()}}">
            <h3 class="h4">{{$post->name}}</h3></a>
        <p class="text-muted">{{$post->short_description}}</p>
        <footer class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                <div class="avatar">
                    <img src="{{url('/themes/front/img/avatar-3.jpg')}}" alt="..." class="img-fluid"></div>
                <div class="title"><span>John Doe</span></div></a>
            <div class="date"><i class="icon-clock"></i> 2 months ago</div>
            <div class="comments meta-last"><i class="icon-comment"></i>12</div>
        </footer>
    </div>
</div>