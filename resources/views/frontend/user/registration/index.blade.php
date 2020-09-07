@extends('frontend.layout.app')
@section('main')
    <section class="py-4 registration-steps" style="background:#3e3e3e">
        <div class="custom-container mt-3">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <ul class="process-steps">
                        <li>
                            <div class="icon">1</div>
                            <div class="title">Basic Info</div>
                        </li>
                        <li>
                            <div class="icon">2</div>
                            <div class="title">Sub-Topic</div>
                        </li>
                        <li>
                            <div class="icon">3</div>
                            <div class="title">Type</div>
                        </li>
                        <li>
                            <div class="icon">4</div>
                            <div class="title">Expert List</div>
                        </li>
                        <li>
                            <div class="icon">5</div>
                            <div class="title">Payment</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="registration-wrapper">
        <div class="container">
            <div class="row sage-margin-right">
                <div class="col-md-8 offset-md-2 pb-md-4">
                    <h2 class="my-4 my-sm-4 my-md-5 text-center">Let's fill out Basic Information</h2>
                    <form action="{{route('expert-register')}}" method="post">
                        @csrf
                        @if(@$referral->email)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="referrer" class="col-sm-4">Referred By</label>
                                    <div class="col-md-8">
                                        <input type="text" name="reffer_by" class="form-control"  required autocomplete="off" {{(@$referral->email)?'readonly':''}} value="{{@$user->first_name.' '.@$user->last_name}}">
                                        @if($errors->has('email'))
                                            <span class="form-text text-danger"> {{$errors->first('email')}}</span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <input type="text" name="first_name" class="form-control" required placeholder="First Name (required)" value="{{@$referral->first_name}}">
                                            @if($errors->has('first_name'))
                                                <span class="form-text text-danger"> {{$errors->first('first_name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <input type="text" name="last_name"  class="form-control" required placeholder="Last Name (required)" value="{{@$referral->last_name}}">
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
                                    <input type="text" name="email" class="form-control"  pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" aria-required="true" required placeholder="E-mail Address (required)" autocomplete="off" {{(@$referral->email)?'readonly':''}} value="{{@$referral->email}}">
                                    @if($errors->has('email'))
                                        <span class="form-text text-danger"> {{$errors->first('email')}}</span>
                                    @endif
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

                        {{--<div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{old('phone')}}">
                                    @if($errors->has('phone'))
                                        <span class="form-text text-danger"> {{$errors->first('phone')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>--}}

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
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <input id="terms-condition" type="checkbox" name="checkbox" class="sage-check-box" required>
                                <label for="terms-condition" class="d-inline-block mb-3 mb-sm-0">I agree to the <a target="_blank" href="{{route('policy')}}" style="color: #00df73">Terms and Conditions</a></label>
                                @if($errors->has('checkbox'))
                                    <span class="form-text text-danger"> {{$errors->first('checkbox')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" name="register" class="submit-button float-sm-right" value="Next">
                            </div>
                        </div>
                    </form>
                </div><!-- End col-md-6 -->
            </div><!-- End row -->
        </div><!-- End login -->
    </section>

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
