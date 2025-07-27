
<!--ova strana ne treba po zadatku-->

@extends('admin._layout.layout')

@section('seo_title',__('Add new Post'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Add new Post')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.posts.index')}}">@lang('Posts')</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @lang('Add new Post')
                    </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->



<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Enter data for the Post')</h3>
                    </div>
                    <!-- /.card-header -->

                    <!-- form start -->
                    <form 
                        role="form"

                        action="{{route('admin.posts.insert')}}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="entity-form"                        
                        >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>User</label>
                                        <select 
                                            name="user_id"  
                                            class="form-control @if($errors->has('user_id')) is-invalid @endif"
                                            >
                                            <option value="">-- Choose User --</option>
                                            @foreach(
                                            \App\Models\User::query()->orderBy('name')->get()
                                            as 
                                            $user
                                            )
                                            <option 
                                                value="{{$user->id}}"
                                                @if($user->id == old('user_id'))
                                                selected
                                                @endif
                                                >{{$user->name}}
                                            </option>
                                            @endforeach                                            
                                        </select>
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'user_id'])
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select 
                                            name="category_id" 
                                            class="form-control @if($errors->has('category_id')) is-invalid @endif"
                                            >
                                            <option value="">-- Choose Category --</option>
                                            @foreach($categories as $category)
                                            <option  
                                                value="{{$category->id}}"
                                                @if($category->id == old('category_id'))
                                                selected
                                                @endif
                                                >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'category_id'])
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input 
                                            name="name"
                                            value="{{old('name')}}"
                                            type="text" 
                                            class="form-control @if($errors->has('name')) is-invalid @endif" 
                                            placeholder="Enter name"
                                            >
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'name'])
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea 
                                            name="description"
                                            class="form-control @if($errors->has('description')) is-invalid @endif" 
                                            placeholder="Enter Description"
                                            rows="5"
                                            >{{old('description')}}</textarea>
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'description'])
                                    </div>
  

                                    <div class="form-group">
                                        <label>Status:</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="status-disabled" 
                                                name="status" 
                                                class="custom-control-input"
                                                value="0"
                                                @if(0 == old('status'))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="status-disabled">Disabled</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="status-enabled" 
                                                name="status" 
                                                class="custom-control-input"
                                                value="1"
                                                @if(1 == old('status'))
                                                @endif
                                                >
                                            <label class="custom-control-label" for="status-enabled">Enabled</label>
                                        </div>
                                        <!-- za ispis greske sa bekenda za radio dugme - poseban nevidljib div -->
                                        <div style="display:none;" class="form-control @if($errors->has('status')) is-invalid @endif"></div>
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'status'])
                                    </div>


                                    <div class="form-group">
                                        <label>Important:</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="on-index-page-no" 
                                                name="index_page" 
                                                class="custom-control-input"
                                                value="0"
                                                @if(0 == old('index_page'))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="on-index-page-no">No</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="on-index-page-yes" 
                                                name="index_page" 
                                                class="custom-control-input"
                                                value="1"
                                                @if(1 == old('index_page'))
                                                checked
                                                @endif
                                                >
                                            <label class="custom-control-label" for="on-index-page-yes">Yes</label>
                                        </div>
                                        <!-- za ispis greske sa bekenda za radio dugme - poseban nevidljib div -->
                                        <div style="display:none;" class="form-control @if($errors->has('index_page')) is-invalid @endif"></div>
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'index_page'])
                                    </div>

                                    <div class="form-group">
                                        <label>Tags</label>
                                        <select 
                                            name="tag_id[]"
                                            class="form-control @if($errors->has('tag_id')) is-invalid @endif" 
                                            multiple
                                            >
                                            @foreach($tags as $tag)
                                            <option 
                                                value="{{$tag->id}}"
                                                @if(
                                                is_array(old('tag_id')) 
                                                && in_array($tag->id, old('tag_id'))
                                                )
                                                selected
                                                @endif
                                                >{{$tag->name}}</option>
                                            @endforeach

                                        </select>
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'tag_id'])

                                    </div>

                                    <div class="form-group">
                                        <label>Choose New Post Photo</label>
                                        <input 
                                            name="photo" 
                                            value="{{old('photo')}}"
                                            type="file" 
                                            class="form-control @if($errors->has('photo')) is-invalid @endif"
                                            >
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'photo'])

                                    </div>
                                     
                                    <div class="form-group">
                                        <label>Post</label>
                                        <textarea 
                                            name="body"
                                            class="form-control @if($errors->has('body')) is-invalid @endif" 
                                            placeholder="Enter Post"
                                            rows="5"
                                            >{{old('body')}}</textarea>
                                         @include('admin._layout.partials.form_errors',['fieldName'=>'body'])

                                    </div>
                                     
                                  
                                </div>
                                
                                <div class="offset-md-1 col-md-5">
                                    
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{route('admin.posts.index')}}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>


<!-- /.content -->
@endsection

@push('footer_javascript')
<script src="{{url('/themes/admin/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/admin/plugins/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script type="text/javascript">
 $('#entity-form [name="body"]').ckeditor({
    "height": "400px",
            "filebrowserBrowserUrl": "{{route('elfinder.ckeditor')}}" // ? NE RADI BROWSER ZA IMAGE 
           
    });
    // select2 plugin
//    $('#entity-form select').select2({
//        "theme": "bootstrap4"
//    });

    // select name=user_id
    $('#entity-form [name="user_id"]').select2({
        "theme": "bootstrap4"
    });
    // select name=category_id
    $('#entity-form [name="category_id"]').select2({
        "theme": "bootstrap4"
    });
      
    $('#entity-form [name="tag_id[]"]').select2({
        "theme": "bootstrap4"
    });


    $('#entity-form').validate({
        rules: {
            "user_id": {
                "required": true
            },
//            "category_id": {
//                "required": false
//            },
            "name": {
                "required": true,
                "minlength": 20,
                "maxlength": 255
            },
            "description": {
                "required": true,
                "minlength": 50, 
                "maxlength": 500
            },
            "body": {
                "required": true,
                "minlength": 25,
                "maxlength": 4000
            },
            "index_page": {
                "required": true
            },
            "status": {
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