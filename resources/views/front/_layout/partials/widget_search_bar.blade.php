<div class="widget search">
    <header>
        <h3 class="h6">Search the blog</h3>
    </header>

    <form  
        action="{{route('front.posts.search')}}" 
        id="search-form"
        name="search"
        class="search-form"
        method="get"
        >

        <div class="form-group">
            <input  
                type="search" 
                name="search"
                placeholder="What are you looking for?" 
                class="form-control @if($errors->has(['search'])) is-invalid @endif" 
                >
            @include('front._layout.partials.form_errors',['fieldName'=>'search'])
            <button 
                type="submit" 
                class="submit"
                data-search-term="search-term"
                >
                <i class="icon-search"></i>
            </button>

        </div>
    </form>
</div>


@push('footer_javascript')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>

<script type="text/javascript">
$('#search-form').validate({
    rules: {
        "search": {
            "required": true
        }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});

</script>

@endpush