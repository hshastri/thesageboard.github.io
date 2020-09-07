@extends('frontend.login.app')
@section('login_content')
    @include('frontend.login.logo')
    <form class="login100-form validate-form col-md-8 offset-md-2" action="{{route('change_password')}}" method="post">
        @csrf
        <div class="enter-new-password">
            <span class="d-block mb-2">Enter New Password</span>
            <input type="hidden" name="email" value="{{$user->email}}">
            <input type="hidden" name="token" value="{{$user->remember_token}}">
            <div class="form-group wrap-input100 rs2-wrap-input100 validate-input" data-validate="Type password">
                <input class="input100 form-control" type="password" name="password" placeholder="Password" autocomplete="off">
            </div>
            <div class="form-group wrap-input100 rs2-wrap-input100 validate-input" data-validate="Type password">
                <input class="input100 form-control" type="password" name="confirm" placeholder="Confirm Password" autocomplete="off">
            </div>
            <button type="submit" class="submit-button d-block mb-2">Submit</button>
            <div class="text-center">
                <span>Back to</span><a href="{{route('login')}}"> Login?</a>
            </div>
        </div>
    </form>

@endsection
