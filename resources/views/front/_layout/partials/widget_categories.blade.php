  
<div class="widget categories">
    <header>
        <h3 class="h6">Categories</h3>
    </header>
    
        @foreach($firstFiveCategories as $singleCategory)
            @if($singleCategory->name!="Uncategorized")
                <div class="item d-flex justify-content-between">
                    <a href="{{$singleCategory->getFrontUrl()}}">
                        {{$singleCategory->name}}
                    </a>
                    <span> 
                        ({{$singleCategory->posts_count}})
                    </span>
                </div>
            @endif
        @endforeach
     
</div>
