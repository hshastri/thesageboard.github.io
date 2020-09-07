@extends('frontend.login.app')
@section('login_content')
    @include('frontend.login.logo')
    <form class="login100-form validate-form col-md-8 offset-md-2" action="{{route('forget-password')}}" method="post">
        @csrf
        <div class="enter-mail-address">
            <span class="d-block mb-2">Forgot password, enter your email address.</span>
            <div class="form-group registered-mail validate-input m-b-20" data-validate="Type user name">
                <input class="input100 form-control" type="email" name="email" placeholder="Enter your Email" autocomplete="off">
            </div>
            <button type="submit" class="submit-button d-block mb-2">Get Verification Code</button>
            <div class="text-center">
                <span>Back to</span><a href="{{route('login')}}"> Login?</a>
            </div>
        </div>
    </form>

@endsection
