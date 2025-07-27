<div class="widget tags">       
    <header>
        <h3 class="h6">Tags</h3>
    </header>
    <ul class="list-inline">
        @foreach($tags as $tag) 
            <li class="list-inline-item">
                <a href="{{$tag->getFrontUrl()}}" class="tag">
                    {{$tag->name}}
                </a>
            </li>
        @endforeach 
    </ul>
</div>