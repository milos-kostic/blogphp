
@extends('front._layout.layout')

@section('seo_title', $category->name) 
@section('seo_description', $category->description)  

@section('content')


<div class="container">

    <div class="row">

        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3">Search results for "cubes"</h2>
                <div class="row">
                    <!-- post -->
                    <div class="post col-xl-6">
                        <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-post-1.jpeg" alt="..." class="img-fluid"></a></div>
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <div class="date meta-last">20 May | 2016</div>
                                <div class="category"><a href="blog-category.html">Business</a></div>
                            </div><a href="blog-post.html">
                                <h3 class="h4">Alberto Savoia Can Teach You About Interior</h3></a>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                            <footer class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar"><img src="img/avatar-3.jpg" alt="..." class="img-fluid"></div>
                                    <div class="title"><span>John Doe</span></div></a>
                                <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                                <div class="comments meta-last"><i class="icon-comment"></i>12</div>
                            </footer>
                        </div>
                    </div>
                    <!-- post             -->
                    <div class="post col-xl-6">
                        <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-post-2.jpg" alt="..." class="img-fluid"></a></div>
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <div class="date meta-last">20 May | 2016</div>
                                <div class="category"><a href="blog-category.html">Business</a></div>
                            </div><a href="blog-post.html">
                                <h3 class="h4">Alberto Savoia Can Teach You About Interior</h3></a>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                            <div class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar"><img src="img/avatar-2.jpg" alt="..." class="img-fluid"></div>
                                    <div class="title"><span>John Doe</span></div></a>
                                <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                                <div class="comments meta-last"><i class="icon-comment"></i>12</div>
                            </div>
                        </div>
                    </div>
                    <!-- post             -->
                    <div class="post col-xl-6">
                        <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-post-3.jpeg" alt="..." class="img-fluid"></a></div>
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <div class="date meta-last">20 May | 2016</div>
                                <div class="category"><a href="blog-category.html">Business</a></div>
                            </div><a href="blog-post.html">
                                <h3 class="h4">Alberto Savoia Can Teach You About Interior</h3></a>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                            <div class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar"><img src="img/avatar-3.jpg" alt="..." class="img-fluid"></div>
                                    <div class="title"><span>John Doe</span></div></a>
                                <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                                <div class="comments meta-last"><i class="icon-comment"></i>12</div>
                            </div>
                        </div>
                    </div>
                    <!-- post -->
                    <div class="post col-xl-6">
                        <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-post-4.jpeg" alt="..." class="img-fluid"></a></div>
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <div class="date meta-last">20 May | 2016</div>
                                <div class="category"><a href="blog-category.html">Business</a></div>
                            </div><a href="blog-post.html">
                                <h3 class="h4">Alberto Savoia Can Teach You About Interior</h3></a>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                            <div class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar"><img src="img/avatar-1.jpg" alt="..." class="img-fluid"></div>
                                    <div class="title"><span>John Doe</span></div></a>
                                <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                                <div class="comments meta-last"><i class="icon-comment"></i>12</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-template d-flex justify-content-center">
                        <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-left"></i></a></li>
                        <li class="page-item"><a href="#" class="page-link active">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link"> <i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </main>

        <aside class="col-lg-4">

            <!-- Widget [Search Bar Widget]-->
            @include('front._layout.partials.widget_search_bar')


            <!-- Widget [Latest Posts Widget]        -->           
            @include('front._layout.partials.widget_three_latest_posts')

            <!-- Widget [Categories Widget]-->
            @include('front._layout.partials.widget_categories') 


            <!-- Widget [Tags Cloud Widget]-->
            @include('front._layout.partials.widget_tags')


        </aside>

    </div>
</div>

@endsection      