@extends('admin._layout.layout')

@section('seo_title', __('Edit Categories'))

@section('content')
  
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit Category')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.categories.index')}}">@lang('Post Categories')</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @lang('Edit Category')
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
            <!--<div class="col-md-12">-->
           <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            @lang('Editing category')
                            #{{$category->id}}
                            -
                            {{$category->name}}
                        </h3>
                    </div>
                    <!-- /.card-header -->                    
                    <!-- form start -->
                    <form 
                        id="entity-form"
                        action="{{route('admin.categories.update', ['category' => $category->id])}}"
                        method="post" 
                        role="form"
                        >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input 
                                            name="name"
                                            value="{{old('name', $category->name)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('name')) is-invalid @endif" 
                                            placeholder="Enter name"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                                    </div>                                
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea 
                                            name="description"
                                            class="form-control @if($errors->has('description')) is-invalid @endif" 
                                            placeholder="Enter Description"
                                            rows="4"
                                            >{{old('description',$category->description)}}</textarea>
                                    </div> 
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{route('admin.categories.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
<script type="text/javascript">
    $('#entity-form').validate({
        rules: {
//            "email": {
//                "required": true,
//                "maxlength": 255,
//                "email": true
//            },
            "name": {
                "required": true,
                "minlength": 10,
                "maxlength": 255
            },
            "description": {
                "required": true,
                "minlength": 30,
                "maxlength": 255
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

