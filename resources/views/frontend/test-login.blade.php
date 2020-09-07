<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="icon" href="{{ URL::asset('assets/thesageboard-favicon.png') }}" type="image/x-icon"/>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/login/main.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/sweetalert2.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/fontello/css/fontello.css')}}">
        <!--===============================================================================================-->
    </head>
    <body>
        <section class="login-page-wrapper">
            <div class="login-area shadow-lg p-3 px-md-4 py-md-4 py-lg-5">
                <div class="row">
                    <div class="col-md-12 text-center mb-2 mb-md-4">
                        <a href="{{route('/')}}" class="logo d-block m-auto">
                            <img src="{{asset('assets/front/images/logo.png')}}" alt="" class="myimg">
                        </a>
                        <h4 class="w-75 m-auto">An On-Demand Advice Platform for All of Life's Questions</h4>
                    </div>
                    <div class="col-md-5 pr-3 pr-md-0">
                        <a class="social-login facebook" href="{{ route('social.login', ['provider' => 'facebook']) }}" class="login100-form-btn-facebook"><i class="font-facebook-1"></i>Sign In With Facebook</a>
                        <a class="social-login google" href="{{ route('social.login', ['provider' => 'google']) }}" class="login100-form-btn-google"><i class="font-google"></i>Sign In With Google</a>
                        <p class="mt-4"><a href="{{route('expert-register')}}">Sign Up with Email</a>.By Signing up you indicate that your have read and agree to Sage's <a target="_blank" href="{{route('terms')}}" style="color: #00df73">Terms of Service and Privacy policy</a></p>
                    </div>
                    <div class="col-md-1 col-lg-2 text-center px-0">
                        <span class="vertical-line"></span>
                    </div>
                    <div class="col-md-6 col-lg-5 py-2 pl-3 pl-md-0">
                        <form class="validate-form" action="{{route('authenticated')}}" method="post">
                            @csrf
                            <span class="d-block mb-2">Account Login</span>
                            <div class="form-group validate-input" data-validate="Type user name">
                                <input type="text" name="email" class="form-control" placeholder="Email/Username">
                            </div>
                            <div class="form-group validate-input" data-validate="Type password">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input id="terms-condition" type="checkbox" name="checkbox" class="sage-check-box">
                                <label for="terms-condition" class="d-inline-block mb-3 mb-sm-0">Remeber Me</label>
                            </div>
                            <button type="submit" class="submit-button d-block mb-2">Sign In</button>
                            <a href="{{route('forget-password')}}">Forgot passwrod?</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>