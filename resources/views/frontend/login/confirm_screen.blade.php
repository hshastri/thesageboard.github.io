@extends('frontend.layout.app')
@section('main')
    <section class="container">
        <div class="row">
            <div class="col-md-8 col-lg-6 offset-md-2 offset-lg-3 mt-5 login-confirmation">
                <div class="card mt-3 shadow">
                    <div class="card-header">
                        <h3 class="mb-2">Thank you for registering via <span>{{$provider}} oAuth</span></h3>
                        <p>Please help us complete your profile by answering a few questions.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{route('login-confirmation')}}" class="confirmation-action mt-3" id="confirmScreen">
                        @csrf
                            <div class="form-group mb-1 mb-md-2">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" value="{{$newUser->first_name}}" class="form-control-sm">
                                @if($errors->has('first_name'))
                                <span class="form-text text-danger"> {{$errors->first('first_name')}}</span>
                                @endif
                            </div>
                            <div class="form-group mb-1 mb-md-2">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" value="{{$newUser->last_name}}" class="form-control-sm">
                                @if($errors->has('last_name'))
                                <span class="form-text text-danger"> {{$errors->first('last_name')}}</span>
                                @endif
                            </div>
                            <div class="form-group mb-1 mb-md-2">
                                <label for="">Username</label>
                                <input type="text" name="username" value="{{$newUser->username}}" class="form-control-sm">
                                <small class="form-text text-muted">Display name will be shown in posts and answers.</small>
                                @if($errors->has('username'))
                                <span class="form-text text-danger"> {{$errors->first('username')}}</span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <div class="col-4 col-md-4">
                                    <div class="profile-picture">
                                    @if($fullpath!='')
                                    <img src="{{asset($fullpath)}}" alt="" style="height: 100%;width: 100%;">
                                    @else
                                    <img src="{{asset('assets/images/admin.jpg')}}" alt="" style="height: 100%;width: 100%;">
                                    @endif
                                    </div>
                                </div>
                                <div class="col-8 col-md-8 pl-0 pl-md-2 py-1 py-md-2 profile-photo">
                                    <input type="file" class="d-none">
                                    <h4>Profile Photo</h4>
                                    <p class="profile-picture-text">
                                        Adding a photo is important for your personal brand. You can update your photo in your ‘My Profile’ page.
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group text-centerK row">
                                    <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                        <label for="">Just want to ask Questions?</label>
                                        @if(Session::has('redirect_question_id'))
                                            <button type="submit" class="submit-button" name="answer" value="answer">Continue Your Answer</button>
                                        @else
                                            <button type="submit" class="submit-button" name="home" value="home">Continue to Home Page</button>
                                        @endif

                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <label for="">Become a Sage</label>
                                        <button type="submit" class="submit-button" name="profile" value="profile">Complete your Profile</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
<script>
    $(function(){
        $("#confirmScreen").validate
        ({
            rules: {
                username:{
                    required: true,
                    remote:{
                        url:"{{route('check-username')}}",
                        type:"get"
                    }
                },
                first_name: {required:true},
                last_name: {required:true},
            },
            messages:{
                username:{
                    remote:"Username Already Exist"
                },
            }
        });
    })
</script>
@endpush
