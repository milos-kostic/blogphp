@extends('admin._layout.layout')

@section('seo_title', __('Edit Slides'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit Slide')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.users.index')}}">@lang('Slides')</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @lang('Edit Slide')
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
                        <h3 class="card-title">
                            @lang('Editing slide')
                            #{{$slide->id}}
                            -
                            {{$slide->name}}
                        </h3>
                    </div>
                    <!-- /.card-header -->

                    <!-- form start -->
                    <form 
                        id="entity-form"
                        action="{{route('admin.slides.update', ['slide' => $slide->id])}}"
                        method="post"
                        enctype="multipart/form-data"
                        role="form"
                        >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input 
                                            name="name"
                                            value="{{old('name', $slide->name)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('name')) is-invalid @endif" 
                                            placeholder="Enter name"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                                    </div>

                                    <div class="form-group">
                                        <label>Button Name</label>
                                        <input 
                                            name="button_name"
                                            value="{{old('button_name', $slide->button_name)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('button_name')) is-invalid @endif" 
                                            placeholder="Enter name"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'button_name'])
                                    </div>

                                    <div class="form-group">
                                        <label>Button Url</label>
                                        <input 
                                            name="button_url"
                                            value="{{old('button_url', $slide->button_url)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('button_url')) is-invalid @endif" 
                                            placeholder="Enter name"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'button_url'])
                                    </div>


                                    <div class="form-group">
                                        <label>Enabled</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="on-index-page-no" 
                                                name="status" 
                                                class="custom-control-input"
                                                value="0"
                                                @if(0 == old('status', $slide->status))
                                            checked
                                            @endif
                                            >
                                            <label class="custom-control-label" for="on-index-page-no">No</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input 
                                                type="radio" 
                                                id="on-index-page-yes" 
                                                name="status" 
                                                class="custom-control-input"
                                                value="1"
                                                @if(1 == old('status', $slide->status))
                                            checked
                                            @endif
                                            >
                                            <label class="custom-control-label" for="on-index-page-yes">Yes</label>
                                        </div>
                                        <!-- za ispis greske sa bekenda za radio dugme - poseban nevidljib div -->
                                        <div style="display:none;" class="form-control @if($errors->has('status')) is-invalid @endif"></div>
                                        @include('admin._layout.partials.form_errors',['fieldName'=>'status'])

                                    </div>
 

                                    <div class="form-group">
                                        <label>Choose New Photo</label>
                                        <input 
                                            name="photo" 
                                            type="file" 
                                            class="form-control @if($errors->has('photo')) is-invalid @endif"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'photo'])
                                    </div>


                                </div>
                                <div class="offset-md-3 col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Photo</label>
                                                <div class="text-right">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-action="delete-photo"
                                                        >
                                                        <i class="fas fa-remove"></i>
                                                        Delete Photo
                                                    </button>
                                                </div>
                                                <hr>
                                                <div class="text-center">
                                                    <img 
                                                        src="{{$slide->getPhoto1Url()}}" 
                                                        alt="" 
                                                        class="img-fluid"
                                                        data-container="photo"
                                                        >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{route('admin.slides.index')}}" class="btn btn-outline-secondary">Cancel</a>
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

    $('#entity-form').on('click', '[data-action="delete-photo"]', function (e) {
        e.preventDefault();

        let photo = $(this).attr('data-photo'); //'photo1' ili 'photo2'

        $.ajax({
            "url": "{{route('admin.slides.delete_photo', ['slide' => $slide->id])}}",
            "type": "post",
            "data": {
                "_token": "{{csrf_token()}}"
            }
        }).done(function (response) {

            toastr.success(response.system_message);

            $('img[data-container="photo"]').attr('src', response.photo_url);

        }).fail(function () {
            toastr.error('Error while deleteing photo');
        });
    });

    $('#entity-form').validate({
        rules: {
            "name": {
                "required": true,
                "maxlength": 255
            },
            "button_name": {
                "required": false,
                //    "minlength": 5,
                "maxlength": 255
            },
            "button_url": {
                "required": false,
                //  "minlength": 5,
                "maxlength": 255
            },
            "status": {
                "required": false 
                //  "in:1,0",
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