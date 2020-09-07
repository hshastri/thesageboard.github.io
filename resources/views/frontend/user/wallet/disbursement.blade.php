@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 available-balance mb-5">
            <div class="d-flex balance-get-paid border-bottom border-success bg-white p-4">
                <h1 class="mb-0">Balance <span class="font-weight-bold text-success">${{$balance}}</span></h1>
                @if($balance>1)
                     <a href="{{route('get-paid')}}" class="ml-auto text-dark btn btn-success">Get Withdraw Now</a>
                @endif
            </div>
        </div>
        <div class="col-md-12 mb-5">
            <div class="profile-bg">
                <h1>Payment Details</h1>
                <h3>last Payments</h3>
                @foreach($payments as $payment)

                    <div class="transaction-item border-bottom border-success mb-3 py-3 px-3">

                        <h4><a href="">{{$payment->title}}</a></h4>
                        <div class="row">
                           {{-- <div class="col-md-3 transaction-meta">
                                <span class="meta-desc">Author : </span>
                                <small class="meta-value"><a href="{{route('user-profile', base64_encode($question->user_id))}}">{{App\User::where('id', $question->user_id)->value('username')}}</a></small>
                            </div>--}}
                            <div class="col-md-3 transaction-meta">
                                <span class="meta-desc">Action at : </span>
                                <time class="meta-value">{{date('Y-m-d ', strtotime($payment->created_at))}}</time>
                            </div>
                            <div class="col-md-3 transaction-meta">
                                <span class="meta-desc">Status : </span>
                                <span class="meta-value {{$payment->status}}">{{$payment->status}}</span>
                            </div>
                            <div class="col-md-3 transaction-meta">
                                <span class="meta-desc">Amount </span>
                                <span class="meta-value amount">${{$payment->amount}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
               {{-- <div class="payment-methods clearfix mt-5">
                    <h3>Payment Methods <a href="#" class="float-right shadow-sm py2 px-4 add-method">Add Method</a></h3>
                    <p class="methods border-bottom py-3 mb-0"><i class="fab fa-paypal"></i> Direct Paypal Transfer <span class="font-weight-bold">cha.......12@gmail.com</span></p>
                    <p class="methods border-bottom py-3"><i class="fab fa-payoner"></i> Direct Paypal Transfer <span class="font-weight-bold">cha.......12@gmail.com</span></p>
                </div>--}}
            </div>
            <div>
                {{$payments->links()}}
            </div>
        </div>
    </div>
@endsection
