  
<div class="widget categories">
    <header>
        <h3 class="h6">Comments</h3>
    </header>
    
        @foreach($post->comments as $comment)
            <div class="item d-flex justify-content-between">
                <a href="#">
                    {{$comment->name}}
                </a>
                <!--ime korisnika?-->
                <span> 
                    ({{$comment->post_id}})
                </span>
            </div>
        @endforeach
     
</div>
