<!--<div class="widget tags">-->   
<div class="post-tags">  
    <!--    <header>
            <h3 class="h6">Tags</h3>
        </header>-->
    <ul class="list-inline">
        @foreach($post->tags as $tag)
        <li class="list-inline-item">
            <a href="{{$tag->getFrontUrl()}}" class="tag">
                #{{$tag->name}}
            </a>
        </li> 
        @endforeach
    </ul>
</div>