@extends('frontend.login.app')
@section('login_content')
    @include('frontend.login.logo')
    <div class="col-md-5 pr-3 pr-md-0">
        <a class="social-login facebook" href="{{ route('social.login', ['provider' => 'facebook']) }}" class="login100-form-btn-facebook"><i class="font-facebook-1"></i>Continue with Facebook</a>
        <a class="social-login google" href="{{ route('social.login', ['provider' => 'google']) }}" class="login100-form-btn-google"><i class="font-google"></i>Continue with Google</a>
        <p class="mt-4"><a href="{{route('expert-register')}}">Sign up with e-mail</a>. By Signing up, you indicate that you have read and agree to Sage's <a target="_blank" href="{{route('terms-and-conditions')}}" style="color: #00df73">Terms and Conditions</a> and <a target="_blank" href="{{route('policy')}}" style="color: #00df73">Privacy Policy</a>.</p>
    </div>
    <div class="col-md-1 col-lg-2 text-center px-0">
        <span class="vertical-line"></span>
    </div>
    <div class="col-md-6 col-lg-5 py-2 pl-3 pl-md-0">
        <form class="validate-form" action="{{route('authenticated')}}" method="post">
            @csrf
            <span class="d-block mb-2">Account Login</span>
            <div class="form-group validate-input" data-validate="Type user name">
                <input type="text" name="email" class="form-control input100" placeholder="Username/Email">
            </div>
            <div class="form-group validate-input" data-validate="Type password">
                <input type="password" name="password" class="form-control input100" placeholder="Password">
            </div>
            <div class="form-group">
                <input id="terms-condition" type="checkbox" name="checkbox" class="sage-check-box">
                <label for="terms-condition" class="d-inline-block mb-3 mb-sm-0">Remember Me</label>
            </div>
            <button type="submit" class="submit-button d-block mb-2">Sign In</button>
            <a href="{{route('forget-password')}}">Forgot password?</a>
        </form>
    </div>
@endsection
