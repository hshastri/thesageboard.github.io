@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumbs px-3">
                <a href="{{route('wallet')}}">Wallet <i class="fas fa-chevron-right mx-2"></i></a>Earning
            </div>
        </div>
        <div class="col-md-12 available-balance mb-5">
            <div class="d-flex balance-get-paid border-bottom border-success bg-white p-4">
                <h1 class="mb-0">Balance: <span class="font-weight-bold text-success">${{$balance}}</span></h1>
                @if($balance>1)
                 <a href="{{route('get-paid')}}" class="ml-auto text-dark btn btn-success">Get Withdraw Now</a>
                @endif
            </div>
        </div>
        <div class="col-md-12 mb-5 sage-transactions">
            <div class="col-md-3 pr-0 float-right">
                <div class="wallet-nav payment-settings">
                    <span class="show-settings fas fa-ellipsis-h"></span>
                    <ul class="sub-settings shadow">
                        <li><a href="{{route('in-progress')}}">In-process</a></li>
                        <li><a href="{{route('disbursement')}}">Withdrawal</a></li>
                        <li><a href="{{route('costs')}}">Costs</a></li>
                    </ul>
                </div>
            </div>
            <h2>Status: Earnings</h2>
            <div class="profile-bg">
                @foreach($payments as $payment)

                    <div class="transaction-item border-bottom border-success mb-3 py-3 px-3">
                        @php
                            $question =  App\AskQuestion::where('id', $payment->question_id)->first();
                        @endphp
                        <h4><a href="javascript:void(0)">{{ucfirst($question->question_title)}}</a></h4>
                        <div class="row">
                            <div class="col-md-3 transaction-meta">
                                <span class="meta-desc">Author : </span>
                                <small class="meta-value"><a href="{{route('user-profile', base64_encode($question->user_id))}}">{{App\User::where('id', $question->user_id)->value('username')}}</a></small>
                            </div>
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
            </div>
            <nav aria-label="...">
                {{$payments->links()}}
            </nav>
        </div>
    </div>
@endsection
