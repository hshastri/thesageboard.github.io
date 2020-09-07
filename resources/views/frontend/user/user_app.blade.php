@extends('frontend.layout.app')
@section('main')
    <section class="private-profile-body">
        <div class="gap"></div>
        <div class="custom-container">
            <div class="row">
                @include('frontend.user.side_nav')
                <div class="col-md-12 col-sm-12 col-lg-10 col-xl-9" style="min-height: 70vh">
                    @if(Auth::user()->role=='Expertise' && Auth::user()->complete_step!=3)
                    <div class="alert alert-danger py-4 mb-4 border-0 rounded-0" role="alert">
                        Please complete your profile <a class="submit-button d-inline-block ml-2" href="{{route('expert-bio')}}">GO TO PROFILE WIZARD</a>
                    </div>
                    @endif
                    @yield('user_content')
                </div><!-- End main -->
            </div><!-- End row -->
        </div>
    </section>
@endsection
