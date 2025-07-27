<div class="btn-group">
    <a 
        href="{{$post->getFrontUrl()}}" 
        class="btn btn-info" 
        target="_blank"
        >
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{route('admin.posts.edit',['post'=>$post->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <!-- Status: -->
    @if($post->isEnabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#disable-modal"
        data-action="disable"
        data-id="{{$post->id}}"
        data-name="{{$post->name}}"
        >
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    @if($post->isDisabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#enable-modal"
        data-action="enable"
        data-id="{{$post->id}}"
        data-name="{{$post->name}}"
        >
        <i class="fas fa-check"></i>
    </button>
    @endif
    <!--
                index_page - Important: 
    -->
    @if($post->isImportant())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#unimportant-modal"
        data-action="unimportant"
        data-id="{{$post->id}}"
        data-name="{{$post->name}}"
        >
        <i class="fas fa-exclamation-circle"></i>
    </button>
    @endif
    @if($post->isNotImportant())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#important-modal"
        data-action="important"
        data-id="{{$post->id}}"
        data-name="{{$post->name}}"
        >
        <i class="fas fa-exclamation"></i>
    </button>
    @endif
    <!-- Delete: -->
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"

        data-action="delete"
        data-id="{{$post->id}}"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>
