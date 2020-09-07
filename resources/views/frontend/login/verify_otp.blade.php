@extends('frontend.login.app')
@section('login_content')
    @include('frontend.login.logo')
    <form class="login100-form validate-form col-md-8 offset-md-2" action="{{route('verify_otp')}}" method="post">
        @csrf
        <div class="verify-otp">
            <input type="hidden" name="email" autocomplete="off" value="{{@$user_mail}}">
            <span class="d-block mb-2">Please enter your code</span>
            <div class="form-group registered-mail validate-input m-b-20" data-validate="Type user name">
                <input class="input100 form-control" type="number" name="token" placeholder="Enter your OTP" autocomplete="off">
            </div>
            <button type="submit" class="submit-button d-block mb-2">Verify Now</button>
            <div class="text-center">
                <span class="txt1">Back to</span><a href="{{route('login')}}"> Login?</a>
            </div>
        </div>
    </form>
@endsection
