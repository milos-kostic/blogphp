<div class="btn-group">
    @if($comment->isEnabled())
    <a 
        href="{{$comment->post->getFrontUrl()}}" 
        class="btn btn-info" 
        target="_blank"
        >
        <i class="fas fa-eye"></i>
    </a> 
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#disable-modal"
        data-action="disable"
        data-id="{{$comment->id}}"
        data-name="{{$comment->body}}"
        >
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    @if($comment->isDisabled())    
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#enable-modal"
        data-action="enable"
        data-id="{{$comment->id}}"
        data-name="{{$comment->body}}"
        >
        <i class="fas fa-check"></i>
    </button>
    @endif
  
 
    <!-- Delete: -->
    <!--    
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#delete-modal"
    
            data-action="delete"
            data-id="{{$comment->id}}"
            >
            <i class="fas fa-trash"></i>
        </button>
    -->
</div>
