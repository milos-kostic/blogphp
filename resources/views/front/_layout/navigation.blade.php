
<nav class="navbar navbar-expand-lg">
    <div class="search-area">
        <div class="search-area-inner d-flex align-items-center justify-content-center">
            <div class="close-btn"><i class="icon-close"></i></div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    
                    <form action="{{route('front.posts.search')}}">
                        <div class="form-group">
                            <input type="search" name="search" id="search" placeholder="What are you looking for?">
                            <button type="submit" class="submit">
                                <i class="icon-search-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <!-- Navbar Brand -->
        <div class="navbar-header d-flex align-items-center justify-content-between">
            <!-- Navbar Brand -->
            <a 
                href="{{route('front.index.index')}}" 
                class="navbar-brand"
                >
                <img src="{{url('/themes/front/img/logo.png')}}" alt="logo">
            </a>
            <!-- Toggle Button-->
            <button type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarcollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span></span><span></span><span></span></button>
        </div>

        <!-- Navbar Menu -->
        <div id="navbarcollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="{{route('front.index.index')}}" class="nav-link active">Home</a>
                </li>
                <li class="nav-item"><a href="{{route('front.posts.index')}}" class="nav-link">Blog</a>
                </li>
                <li class="nav-item"><a href="{{route('front.contact.index')}}" class="nav-link">Contact</a>
                </li>
            </ul>
            <div 
                class="navbar-text"
                id="search-button"
                >
                <a href="#" class="search-btn">
                    <i class="icon-search-1"></i>
                </a>
            </div>
        </div>
    </div>
</nav>


@push('footer_javascript')
<script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
// :: Search Form Code     
// ---------------------------------------------- //
// Search Bar
// ---------------------------------------------- //
$('.search-btn').on('click', function (e) {
    e.preventDefault();
    $('.search-area').fadeIn();
    // alert('radi'); // radi
    $(".search-form").toggleClass("active");
});
$('.search-area .close-btn').on('click', function () {
    $('.search-area').fadeOut();
}); 
</script>
@endpush