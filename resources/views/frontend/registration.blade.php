@extends('frontend.layout.app')
@section('main')
    <section class="registration-wrapper">
        <div class="gap"></div>
        <div class="custom-container">
            <div class="row sage-margin-right">
                <div class="col-md-2 sage-guidline pr-0">
                </div>
                <div class="col-md-8 pl-5 pb-4">
                    <div class="page-content">
                        <h2 class="mb-4">Seeker Registration</h2>
                        <form action="{{route('register')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <input type="text" name="first_name" class="form-control" required value="{{old('first_name')}}" placeholder="First Name (required)">
                                                @if($errors->has('first_name'))
                                                    <span class="form-text text-danger"> {{$errors->first('first_name')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <input type="text" name="last_name"  class="form-control" required value="{{old('last_name')}}" placeholder="Last Name (required)">
                                                @if($errors->has('last_name'))
                                                    <span class="form-text text-danger"> {{$errors->first('last_name')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control" required="" placeholder="username (required)" autocomplete="off" value="{{old('username')}}">
                                        @if($errors->has('username'))
                                            <span class="form-text text-danger"> {{$errors->first('username')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" required="" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" aria-required="true" required placeholder="E-mail Address (required)" autocomplete="off">
                                        @if($errors->has('email'))
                                            <span class="form-text text-danger"> {{$errors->first('email')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{old('phone')}}">
                                        @if($errors->has('phone'))
                                            <span class="form-text text-danger"> {{$errors->first('phone')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="Password" name="password" class="form-control" required placeholder="Password">
                                                @if($errors->has('password'))
                                                    <span class="form-text text-danger"> {{$errors->first('password')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm Password">
                                                @if($errors->has('confirm_password'))
                                                    <span class="form-text text-danger"> {{$errors->first('confirm_password')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-checkbox">
                                <input id="terms-condition" type="checkbox" name="checkbox" class="sage-check-box" required>
                                <label for="terms-condition" class="d-inline-block">I agree to the <a target="_blank" href="{{route('terms')}}" style="color: #00df73">Terms and Conditions</a></label>
                               {{-- <label for="terms-condition" class="container" style=" margin-top: -1.5em; margin-left: .5em;">I agree to the <a href="javascript:void(0)" onclick="show_policy_modal()"  class="text" style="color: #00d773">Terms and Conditions</a></label>--}}
                                @if($errors->has('checkbox'))
                                    <span class="form-text text-danger"> {{$errors->first('checkbox')}}</span>
                                @endif
                            </div>
                            <div class="form-row-last mt-5">
                                <input type="submit" name="register" class="submit-button" value="Register">
                            </div>

                        </form>
                    </div><!-- End page-content -->
                </div><!-- End col-md-6 -->
                {{--<div class="col-md-4 sage-guidline pr-0">
                    <div class="page-content pb-5 ">
                        <div class="form-style form-style-3 pb-5">
                            <h2 class="mt-2">Guidline</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Et molestie ac feugiat sed. Diam volutpat commodo. Eu ultrices: Vitae auctor eu augue ut. Malesuada nunc vel risus commodo viverra. Praesent elementum facilisis leo vel.</p>
                            <h2>Save Time</h2>
                            <p>Our platform is developed to save your valuable time. It's much more simple and easier to use. Always we keen to catch your attention</p>
                            <a href="{{route('login')}}" class="btn btn-success ml-5">Have an Account</a>
                            <a href="{{route('expert-register')}}" class="btn btn-primary ml-5 mt-2">Become an Expert</a>
                        </div>
                    </div>
                </div>--}}
            </div><!-- End row -->
        </div><!-- End login -->
    </section>

    <!-- Modal -->


    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        function show_policy_modal(){
            $.get('{{ route('policy') }}', function(data){
                $('#modal-content').html(data);
                $('#exampleModalLong').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endpush
