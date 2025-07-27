@extends('admin._layout.layout')

@section('seo_title', __('Add Slides'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Add Slide')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.slides.index')}}">@lang('Slides')</a></li>
                    <li class="breadcrumb-item active">@lang('Add Slide')</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Enter data for new Slide')</h3>
                    </div>
                    <!-- /.card-header -->

                    <!-- form start -->
                    <form 
                        role="form" 
                        action="{{route('admin.slides.insert')}}" 
                        method="POST" 
                        id="entity-form" 
                        enctype="multipart/form-data" 
                        >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input 
                                    type="text" 
                                    class="form-control @if($errors->has('name')) is-invalid @endif" 
                                    placeholder="@lang('Enter name')"

                                    name="name"
                                    value="{{old('name')}}"
                                    >
                                @include('admin._layout.partials.form_errors',['fieldName'=>'name'])

                            </div>

                            <div class="form-group">
                                <label>Button Name</label>
                                <input 
                                    type="text" 
                                    class="form-control @if($errors->has('button_name')) is-invalid @endif" 
                                    placeholder="@lang('Enter Button name')"

                                    name="button_name"
                                    value="{{old('button_name')}}"
                                    >
                                @include('admin._layout.partials.form_errors',['fieldName'=>'button_name'])

                            </div>

                            <div class="form-group">
                                <label>Button Url</label>
                                <input 
                                    type="text" 
                                    class="form-control @if($errors->has('button_url')) is-invalid @endif" 
                                    placeholder="@lang('Enter Button Url')"

                                    name="button_url"
                                    value="{{old('button_url')}}"
                                    >
                                @include('admin._layout.partials.form_errors',['fieldName'=>'button_url'])

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
                            <div class="offset-md-1 col-md-5">

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a class="btn btn-outline-secondary" href="{{route('admin.categories.index')}}">@lang('Cancel')</a>
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
            "name": {
                "required": true,
                "maxlength": 255
            },
            "button_name": {
                "required": false,
                "maxlength": 255
            },
            "button_url": {
                "required": false,
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