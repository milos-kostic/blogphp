<section 
    style="background:url({{$slide->getPhotoUrl('photo')}}); background-size: cover; background-position: center center" class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1>{{$slide->name}}</h1>
                <a href="{{$slide->button_url}}" class="hero-link">{{$slide->button_name}}</a>
            </div>
        </div>
    </div>
</section>