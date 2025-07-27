<!-- Comments -->
<!--sav ajax za comments -->
<div class="cart-area" id="shopping_cart_top">

</div>

@push('footer_javascript')
<script type="text/javascript">

    function commentsFrontRefreshTable() {
        if ($('#comments_table').length <= 0) { 
            return;    
        }
        //
        $.ajax({
            "url": "{{route('front.comments.table')}}",
            "type": "get",  
            "data": {}
        }).done(function (response) {
            $('#comments_table').html(response);
            console.log('Zavrseno ucitavanje komentara');
            //console.log(response);
        }).fail(function (jqXHR, textStatus, error) {
            console.log('Greska prilikom ucitavanja komentara');
            //    console.log(textStatus);
            //    console.log(error);
        });
    }

 
    function commentsFrontAddComment(commentId, userId = null, email = null) { // quantity) {
        $.ajax({

            "url": "{{route('front.comments.add_comment')}}",
            "type": "POST",
            "data": {
                "_token": "{{csrf_token()}}",
                "comment_id": commentId 
            }
        }).done(function (response) {
            console.log(response);
            //alert(response.system_message);
            toastr.success(response.system_message);
            //    commentsFrontRefreshTop();
            commentsFrontRefreshTable();
        }).fail(function () {
            toastr.error('Unable to add comment to post');
        });
    }
  
    $('[data-action="add_comment_to_post"]').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let productId = $(this).attr('data-post-id');
        //let postId = $(this).data('post_id');
        let quantity = $(this).attr('data-count');
        commentsFrontAddComment(postId);
    });
   
    //   commentsFrontRefreshTop(); //kada se ucita stranica prvi put ucitaj i korpu
    commentsFrontRefreshTable(); // SVAKI PUT NA OSVEZAVANJE
</script>
@endpush