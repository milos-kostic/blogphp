<!-- Comments -->
<!-- DEFINICIJE AJAX FUNKCIJA -->
<div class="cart-area" id="comments_ajax">

</div>

@push('footer_javascript')
<script type="text/javascript">

    function commentsFrontRefresh_ajax() {
        $.ajax({
            "url": "{{route('front.front_comments.content')}}",
            "type": "POST",
            "data": {
                "_token": "{{csrf_token()}}",
                "post_id": "{{$post->id}}"
            }
        }).done(function (response) {
            $('#comments_ajax').html(response);
            console.log('Zavrseno ucitavanje komentara');
            //  alert(response);
            //  console.log(response);
        }).fail(function (jqXHR, textStatus, error) {
            console.log('Greska prilikom ucitavanja komentara');
            // toastr.error(textStatus);
        });
    }


//*******************************/
// DODAVANJE KOMENTARA:
    function commentsFrontAdd_ajax(postId, userName, userEmail, commentBody) {
        $.ajax({
            "url": "{{route('front.front_comments.add')}}",
            "type": "POST",
            "data": {
                "_token": "{{csrf_token()}}",
                "post_id": postId,
                "body": commentBody,
                "user_name": userName,
                "user_email": userEmail
            }
        }).done(function (response) {
            console.log(response);
            // alert(response.system_message); 
            toastr.success(response.system_message);
            //osvezi ispis:
            commentsFrontRefresh_ajax();
            commentsFrontClearInputs_afterSuccess();
            // $('#comments_ajax').html(response); // ukucava sav response u html
        }).fail(function (jqXHR, textStatus, error) {
            console.log('Neuspesno dodavanje komentara');
            // toastr.error(textStatus);
        });
    }

    //
    function commentsFrontClearInputs_afterSuccess() {
        // $('#add-comment-form')
        $('#add-comment-form [name="user_name"]').val("");
        $('#add-comment-form [name="user_email"]').val("");
        $('#add-comment-form [name="comment_body"]').val("");
    }
 
    // commentsFrontRefresh_ajax(); // prvo ucitavanje. pozivam u single.blade

</script>
@endpush