
<form 
    action="{{route('front.contact.send_message')}}" 
    method='post' 
    id="main_contact_form" 
    class="commenting-form"
    >
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <input 
                type="text" 
                value="{{old('your_name')}}"
                name="your_name" 
                placeholder="Your Name" 
                class="form-control @if($errors->has(['your_name'])) is-invalid @endif"
                >

            @include('front._layout.partials.form_errors',['fieldName'=>'your_name'])

        </div>
        <div class="form-group col-md-6">
            <input 
                type="email" 
                value="{{old('your_email')}}"
                name="your_email" 
                placeholder="Email Address (will not be published)" 
                class="form-control @if($errors->has(['your_email'])) is-invalid @endif"
                >
            @include('front._layout.partials.form_errors',['fieldName'=>'your_email'])
        </div>
        <div class="form-group col-md-12">
            <textarea 
                placeholder="Type your message" 
                name="your_message" 
                class="form-control @if($errors->has(['your_message'])) is-invalid @endif" 
                rows="18"
                >{{old('your_message')}}</textarea>
            @include('front._layout.partials.form_errors',['fieldName'=>'your_message'])
        </div>

        <!--google recaptcha-->
        <div 
            class="form-group col-md-12 g-recaptcha" 
            data-sitekey="{{config('services.recaptcha.key')}}"
            >            
        </div> 
        @if(Session::has('g-recaptcha-response'))
        <p class="form-group col-md-6 alert {{Session::get('alert-class','alert-info')}}">
            {{Session::get('g-recaptcha-response')}}
        </p>
        @endif
        <div 
            class="@if($errors->has(['g-recaptcha-response'])) is-invalid @endif" 
            data-sitekey="{{config('services.recaptcha.key')}}"
            >            
        </div> 
        
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-secondary">Submit Your Message</button>
        </div>
    </div>
</form>

@push('head_css')
@endpush

@push('footer_javascript')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>

<script type="text/javascript">
$('#main_contact_form').validate({
    rules: {
        "your_name": {
            "required": true,
            "minlength": 10,
            "maxlength": 255
        },
        "your_email": {
            "required": true,
            "minlength": 10,
            "maxlength": 255
        },
        "your_message": {
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
</script>

@endpush