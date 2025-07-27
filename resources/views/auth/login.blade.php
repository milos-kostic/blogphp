
@extends('auth._layout.layout')

@section('content')

<p class="login-box-msg">Sign in to start your session</p>


<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="input-group mb-3 @error('email') is-invalid @enderror">                            
        <input id="email" type="email" class="form-control input-group @error('email') is-invalid @enderror"  placeholder="E-mail" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
 

    <div class="input-group mb-3 @error('password') is-invalid @enderror"> 
        <input id="password" type="password" class="form-control input-group @error('password') is-invalid @enderror"  placeholder="Password" name="password" required autocomplete="current-password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
 

    <div class="row">
        <div class="col-8">
            <div class="icheck-primary"> 
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label for="remember">
                    Remember Me
                </label>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
        <!-- /.col -->
    </div>


</form>

 

<!-- /.social-auth-links -->

<p class="mb-1">
    <a href="{{ route('password.request') }}">I forgot my password</a>
</p>
<!--                   
                    <p class="mb-0">
                        <a href="register.html" class="text-center">Register a new membership</a>
                    </p>
-->



@endsection
