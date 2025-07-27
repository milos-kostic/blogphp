<header>
    <h3 class="h6">
        Post Comments
        <span class="no-of-comments">
            ({{$comments->count()}})
        </span>
    </h3>
</header>

@foreach($comments AS $comment)
<div class="comment">
    <div class="comment-header d-flex justify-content-between">
        <div class="user d-flex align-items-center">
            <div class="image">
                <!--<img src="img/user.svg" alt="..." class="img-fluid rounded-circle"></div>-->
                <img src="{{optional($comment)->getUserPhoto()}}" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
                <strong>{{optional($comment)->getUserName()}}</strong>
                <span class="date"> {{\Carbon\Carbon::parse(optional($comment)->created_at)->isoFormat('DD MMM | YYYY')}} </span>
            </div>
        </div>
    </div>
    <div class="comment-body">
        <p>{{optional($comment)->body}}</p>
    </div>
</div>
@endforeach