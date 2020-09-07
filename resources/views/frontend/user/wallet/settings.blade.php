@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">

        <div class="col-md-8 pb-5 my-5 offset-md-2">
            <div class="profile-bg shadow">
                <h2>To access this page first you have to verify yourself again!</h2>
                <p>To secure your most sensitive information, we need you to re-inter your password.</p>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#sage-secure-payment-settings">Verify Yourself</button>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal animated bounceInDown sage-modal-box" id="sage-secure-payment-settings" tabindex="-1" role="dialog" aria-labelledby="secure settings" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalCenterTitle">Re-enter Your password</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('setup-payment')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="sage-profile-password" class="col-sm-4">Your password</label>
                                <div class="col-md-8">
                                    <input type="password" name="password" id="sage-profile-password" class="mb-0 form-control-plaintext" value="hajfalsdkfjlsdjf" required>
                                </div>
                            </div>
                            <div class="form-group row remember-password justify-content-end">
                                <div class="col-md-8">
                                    <input type="checkbox" name="" id="remember-password" class="sage-check-box">
                                    <label class="d-inline-block" for="remember-password">Remeber Password</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
