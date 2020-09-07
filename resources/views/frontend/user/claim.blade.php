@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 mb-5">
            <div class="profile-bg">
                <h1>Claim Details</h1>
                @foreach($payments as $payment)

                    <div class="transaction-item border-bottom border-success mb-3 py-3 px-3">
                        @php
                            $question =  App\AskQuestion::where('id', $payment->question_id)->first();
                        @endphp
                        <h4><a href="javascript:void(0)">{{ucfirst($question->question_title)}}</a></h4>
                        <div class="row">
                            <div class="col-md-4 transaction-meta">
                                <span class="meta-desc">Author : </span>
                                <small class="meta-value"><a href="{{route('profile', $payment->expert->username )}}">{{App\User::where('id', $question->user_id)->value('username')}}</a></small>
                            </div>
                            <div class="col-md-4 transaction-meta">
                                <span class="meta-desc">Expert  : </span>
                                <small class="meta-value"><a href="{{route('profile', $payment->expert->username )}}">{{$payment->expert->username}}</a></small>
                            </div>
                            <div class="col-md-4 transaction-meta">
                                <span class="meta-desc">Action at : </span>
                                <time class="meta-value">{{date('Y-m-d ', strtotime($payment->created_at))}}</time>
                            </div>
                            <div class="col-md-4 transaction-meta">
                                <span class="meta-desc">Status : </span>
                                <span class="meta-value {{$payment->status}}">{{$payment->status}}</span>
                            </div>
                            <div class="col-md-4 transaction-meta">
                                <span class="meta-desc">Amount </span>
                                <span class="meta-value amount">${{$payment->amount}}</span>
                            </div>
                            <div class="col-md-4 transaction-meta">
                                <a href="{{route('chat-admin', base64_encode($payment->id))}}" class="btn btn-primary">Claim Against Refund</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="pull-left">
            {{$payments->links()}}
        </div>
    </div>
@endsection
@push('js')

@endpush
