
<div class="row">
    @for($i=1;$i<4;$i++)
    <div class="post col-md-4">
        <div class="post-thumbnail">
            <a href="{{$last12Posts[$i-1]->getFrontUrl()}}">
                <img src="{{url($last12Posts[$i-1]->getPhoto1Url())}}" alt="..." class="img-fluid">
            </a>
        </div>
        <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
                <div class="date">
                    {{\Carbon\Carbon::parse($last12Posts[$i-1]->created_at)->isoFormat('DD MMM | YYYY')}}                                  
                </div>
                <div class="category">
                    <a href="{{optional($last12Posts[$i-1]->category)->getFrontUrl()}}">
                        {{optional($last12Posts[$i-1]->category)->name}}
                    </a>
                </div>
            </div>
            <a href="{{$last12Posts[$i-1]->getFrontUrl()}}">
                <h3 class="h4">{{$last12Posts[$i-1]->name}}</h3>
            </a>
            <p class="text-muted">{{$last12Posts[$i-1]->description}}</p>
        </div>
    </div>                    
    @endfor
</div>

<div class="row">
    @for($i=4;$i<7;$i++)
    <div class="post col-md-4">
        <div class="post-thumbnail">
            <a href="{{$last12Posts[$i-1]->getFrontUrl()}}">
                <img src="{{url($last12Posts[$i-1]->getPhoto1Url())}}" alt="..." class="img-fluid">
            </a>
        </div>
        <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
                <div class="date">
                    {{\Carbon\Carbon::parse($last12Posts[$i-1]->created_at)->isoFormat('DD MMM | YYYY')}}                                  
                </div>
                <div class="category">
                    <a href="{{optional($last12Posts[$i-1]->category)->getFrontUrl()}}">
                        {{optional($last12Posts[$i-1]->category)->name}}
                    </a>
                </div>
            </div>
            <a href="{{$last12Posts[$i-1]->getFrontUrl()}}">
                <h3 class="h4">{{$last12Posts[$i-1]->name}}</h3>
            </a>
            <p class="text-muted">{{$last12Posts[$i-1]->description}}</p>
        </div>
    </div>                    
    @endfor
</div>

<div class="row">
    @for($i=7;$i<10;$i++)
    <div class="post col-md-4">
        <div class="post-thumbnail">
            <a href="{{$last12Posts[$i-1]->getFrontUrl()}}">
                <img src="{{url($last12Posts[$i-1]->getPhoto1Url())}}" alt="..." class="img-fluid">
            </a>
        </div>
        <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
                <div class="date">
                    {{\Carbon\Carbon::parse($last12Posts[$i-1]->created_at)->isoFormat('DD MMM | YYYY')}}                                  
                </div>
                <div class="category">
                    <a href="{{optional($last12Posts[$i-1]->category)->getFrontUrl()}}">
                        {{optional($last12Posts[$i-1]->category)->name}}
                    </a>
                </div>
            </div>
            <a href="{{$last12Posts[$i-1]->getFrontUrl()}}">
                <h3 class="h4">{{$last12Posts[$i-1]->name}}</h3>
            </a>
            <p class="text-muted">{{$last12Posts[$i-1]->description}}</p>
        </div>
    </div>                    
    @endfor
</div>

<div class="row">
    @for($i=10;$i<13;$i++)
    <div class="post col-md-4">
        <div class="post-thumbnail">
            <a href="{{$last12Posts[$i-1]->getFrontUrl()}}">
                <img src="{{url($last12Posts[$i-1]->getPhoto1Url())}}" alt="..." class="img-fluid">
            </a>
        </div>
        <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
                <div class="date">
                    {{\Carbon\Carbon::parse($last12Posts[$i-1]->created_at)->isoFormat('DD MMM | YYYY')}}                                  
                </div>
                <div class="category">
                    <a href="{{optional($last12Posts[$i-1]->category)->getFrontUrl()}}">
                        {{optional($last12Posts[$i-1]->category)->name}}
                    </a>
                </div>
            </div>
            <a href="{{$last12Posts[$i-1]->getFrontUrl()}}">
                <h3 class="h4">{{$last12Posts[$i-1]->name}}</h3>
            </a>
            <p class="text-muted">{{$last12Posts[$i-1]->description}}</p>
        </div>
    </div>                    
    @endfor
</div>
