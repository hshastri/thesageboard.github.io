@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="row">
                <div class="col-6 col-md-3 mb-3 mb-sm-3 mb-md-0 mb-lg-0">
                    <div class="wallet in-progress text-center shadow">
                        <a href="{{route('in-progress')}}">
                            <span class="earning amount">${{$pending_amount}}</span>
                            <span class="earning title">Escrowed</span>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3 mb-sm-3 mb-md-0 mb-lg-0">
                    <div class="wallet available text-center shadow">
                        <a href="{{route('balance')}}">
                            <span class="earning amount">${{$balance}}</span>
                            <span class="earning title">Account Balance</span>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="wallet available text-center shadow">
                        <a href="{{route('costs')}}">
                            <span class="earning amount">$ {{$cost}}</span>
                            <span class="earning title">Paid for Private Questions</span>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="wallet available text-center shadow">
                        <a href="{{route('earnings')}}">
                            <span class="earning amount">$ {{App\UserDetails::where('user_id',Auth::user()->id)->value('balance')}}</span>
                            <span class="earning title">Total Earnings</span>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="payment-settings">
                        <span class="show-settings fas fa-ellipsis-h"></span>
                        <ul class="sub-settings shadow">
                            <li><a href="{{route('payment-settings')}}">Payment Settings</a></li>
                            <li><a href="{{route('disbursement')}}">Withdrawal</a></li>
                            <li><a href="{{route('refund')}}">Refund Details</a></li>
                            <li><a href="{{route('referel-history')}}">Referrel Payment</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3 mb-5 sage-transactions">
            <h2>Last Transaction History (within 30 days)</h2>
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
@push('js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
