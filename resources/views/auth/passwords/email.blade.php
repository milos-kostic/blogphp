
@extends('auth._layout.layout')

@section('content')

<!--AKO IMA NEKA PORUKA PRIKAZI NA VRHU:-->
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
                    

<p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>


<form action="{{ route('password.email') }}" method="post">
    @csrf
    
    <div class="input-group mb-3 @error('email') is-invalid @enderror"> 
        <input id="email"  name="email"  type="email" class="form-control @error('email') is-invalid @enderror"  placeholder="E-mail" value="{{ old('email') }}" required autocomplete="email" autofocus>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
                                
                                
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
        </div>
        <!-- /.col -->
    </div>
    
</form>

<p class="mt-3 mb-1">
    <a href="{{route('login')}}">Login</a>
</p>



@endsection



