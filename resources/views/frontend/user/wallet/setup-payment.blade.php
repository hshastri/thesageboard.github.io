@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 account-setup mt-2 mb-5 pb-5">
            <div class="profile-bg clearfix">
                <h1>Bank Account Setup</h1>
                <form action="{{route('payment-settings')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="paypal-account" class="col-sm-2">Paypal Email</label>
                        <div class="col-md-6">
                            <input type="email" name="paypalEmail" id="paypal-account" class="mb-0 form-control-plaintext" placeholder="example@example.com" required>
                            <small id="passwordHelpBlock" class="form-text text-muted">Be careful here, We will send your money to this email.</small>
                        </div>
                        <span><i class="verified fas fa-check"></i> Verified</span>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Save" class="btn btn-success float-right">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
