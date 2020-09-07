@extends('frontend.layout.app')
@section('main')
    <section class="get-paid-action-wrapper p-1 p-md-5">
        <div class="container">
            <div class="row">
                <div class="offset-md-2 col-md-8">
                   <div class="get-paid-action shadow-lg p-3 p-md-5 my-2 my-md-4">
                       <h2>Good News. You are going to withdraw!</h2>
                       <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deleniti fugit harum repellat corporis autem quam</p>
                       <h3 class="border-bottom pb-2 pb-md-3 mb-2 mb-md-4">You have ${{$user->balance}}</h3>
                       <form action="{{route('get-paid')}}" method="post">
                           <input type="hidden" value="{{$token}}" name="token">
                           @csrf
                           <div class="form-group row">
                               <label for="sage-get-paid" class="col-sm-2">Title</label>
                               <div class="col-md-8">
                                   <input type="text" class="form-control" name="title" id="sage-get-paid" class="mb-2" required>
                               </div>
                           </div>
                            <div class="form-group row">
                                <label for="sage-get-paid" class="col-sm-2">Get Paid</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="withdraw_amount" value="{{$user->balance}}"id="sage-get-paid" class="mb-2" min="0" max="{{$user->balance}}" required>
                                   {{-- <p>Our service fee is 10%. You will get <span class="font-weight-bold">$90</span></p>--}}
                                </div>
                            </div>
                           <div class="form-group row">
                               <label for="sage-get-paid" class="col-sm-2">Paypal Email </label>
                               <div class="col-md-8">
                                   <input type="text" class="form-control" name="account" id="sage-get-paid" class="mb-2" value="{{$user->paypalEmail}}" required>
                               </div>
                           </div>
                            <div class="form-group row">
                                <div class="offset-md-2 col-md-8 text-right">
                                    <a href="{{route('wallet')}}" class="btn btn-primary mr-3">Cancel</a>
                                    <button type="submit" class="btn btn-success">Withdrow</button>
                                </div>
                            </div>
                       </form>
                   </div>
                </div>
            </div>
        </div>
    </section>
@endsection
