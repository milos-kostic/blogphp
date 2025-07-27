
<form  id="add-comment-form"    
       action="{{route('front.front_comments.add')}}" 
       class="commenting-form"
       >                           
    <div class="row">
        <div class="form-group col-md-6">
            <input 
                type="text" 
                name="user_name"  
                placeholder="Name" 
                class="form-control @if($errors->has(['user_name'])) is-invalid @endif" 
                value="{{old('user_name')}}"
                >
            @include('front._layout.partials.form_errors',['fieldName'=>'user_name']) 
        </div>
        <div class="form-group col-md-6">
            <input 
                type="email" 
                name="user_email"  
                placeholder="Email Address (will not be published)" 
                class="form-control @if($errors->has(['user_email'])) is-invalid @endif" 
                value="{{old('user_email')}}"
                >
            @include('front._layout.partials.form_errors',['fieldName'=>'user_email'])
        </div>
        <div class="form-group col-md-12">
            <textarea 
                name="comment_body"  
                placeholder="Type your comment" 
                class="form-control @if($errors->has(['comment_body'])) is-invalid @endif" 
                >{{old('comment_body')}}</textarea>
            @include('front._layout.partials.form_errors',['fieldName'=>'comment_body'])
        </div>

        <div class="form-group col-md-12">
            <button 
                type="submit" 
                class="btn btn-secondary"
                data-action="add_comment"
                data-post-id="{{$post->id}}" 
                >
                Submit Comment
            </button>
        </div>

    </div>
</form>

@push('footer_javascript') 
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>


<script type="text/javascript">

$('#add-comment-form').validate({
    rules: {
        "user_name": {
            "required": true,
            "minlength": 10,
            "maxlength": 255
        },
        "user_email": {
            "required": true,
            "minlength": 10,
            "maxlength": 255
        },
        "comment_body": {
            "required": true,
            "minlength": 25,
            "maxlength": 4000
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
  
 
$('#add-comment-form').on('submit', function (e) {
    e.preventDefault();
    e.stopPropagation();

    // alert('Add comment Submit');
    let userName = $('#add-comment-form [name="user_name"]').val();
    let userEmail = $('#add-comment-form [name="user_email"]').val();
    let commentBody = $('#add-comment-form [name="comment_body"]').val();
    let postId = "{{$post->id}}";
 
    // alert('Parametar: '  + userName + ' dalje poziv Ajax: ');

    // AJAX POZIV:
    commentsFrontAdd_ajax(postId, userName, userEmail, commentBody);

});
 


</script>
@endpush


