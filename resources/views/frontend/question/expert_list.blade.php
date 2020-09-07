@extends('frontend.layout.app')
@section('main')
    <section class="container main-content" style="min-height: 450px">
        <div class="row mt-5">
            <div class="col-md-12">
                <ul class="process-steps clearfix">
                    <li class="acttive" style="width: 50%">
                        <div class="icon">1</div>
                        <div class="title">Expert List</div>
                    </li>
                    <li style="width: 50%">
                        <div class="icon">2</div>
                        <div class="title">Payment</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-2">
                <div class="page-content page-shortcode mt-5">
                    <div class="box_icon">
                        <h2>Select your Sage(s)</h2>
                        <div style="height: 30px">
                            <h5 id="totalAmount" style="display: none"></h5>
                        </div>
                        <div class="gap"></div>
                        <div class="poll_2">
                            <form class="form-style form-style-3" method="post" action="{{route('chosen-expert',$id)}}">
                                @csrf
                                <div class="row">
                                    @if(count($experts_by_subtopic) > 0)
                                        @foreach($experts_by_subtopic as $exp)
                                            @php
                                                $expert = App\User::where(['role'=>'Expertise','id'=>$exp->user_id])->where('id','!=', Auth::user()->id)->first();
                                            @endphp
                                            @if($expert)
                                                @include('frontend.partial.expertlist')
                                            @endif
                                        @endforeach
                                    @elseif(count($experts_by_topic) > 0)
                                        <div class="col-md-12 mb-5">
                                            <div class="alert-message warning">
                                                <i class="fas fa-exclamation"></i>
                                                <h3>Oh no! It looks like we don’t have an expert for this subject yet.</h3>
                                                <p>Do you know someone? Share “Sage” with them as a referral so that you can earn money anytime they answer a question in this topic. Go to <a href="{{route('referral')}}">My Referrals</a> and send them a referral.</p>
                                            </div>
                                            <p>These are experts in the topic for your question and may be able to help, even though they don’t list the sub-topic as an expertise.</p>
                                        </div>
                                        @foreach($experts_by_topic as $exp)
                                            @php
                                                $expert = App\User::where(['role'=>'Expertise','id'=>$exp->user_id])->where('id','!=', Auth::user()->id)->first();
                                            @endphp
                                            @if($expert)
                                                @include('frontend.partial.expertlist')
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="col-md-12">
                                            <div class="alert-message warning">
                                                <i class="fas fa-exclamation"></i>
                                                <h3>Oh no! It looks like we don’t have an expert for this subject yet.</h3>
                                                <p>Do you know someone? Share “Sage” with them as a referral so that you can earn money anytime they answer a question in this topic. Go to <a href="{{route('referral')}}">My Referrals</a> and send them a referral.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="gap"></div>
                                <div>
                                    <a type="button" href="{{ URL::previous() }}" class="button medium gray-button custom-button" style="float: left">Back</a>
                                    <button type="submit" class="button medium lime-green-button custom-button paybutton" style="display: none ; float:right;">Pay Now</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- End main -->
        </div>
        <!-- End row -->
    </section><!-- End container -->
@endsection
@push("js")
    <script>
        let total= 0;
        function setAmount(id){
            if($("#"+id).prop('checked') == true){
                let amount = $('#amt_'+id).attr('data-amt');
                let addsubtotal= parseFloat(amount)*0.03;
                let withComm = 0.3 + (addsubtotal+parseFloat(amount));
                total =  parseFloat(total) + parseFloat(withComm);
            }else{
                let amount = $('#amt_'+id).attr('data-amt');
                let removesubtotal= parseFloat(amount)*0.03;
                let removeComm = (removesubtotal+parseFloat(amount))+.3;
                total =  parseFloat(total) - parseFloat(removeComm);
            }
             $('#totalAmount').html('Total Fees:  ' + parseFloat(total).toFixed(2));
             if(total>0){
                 $('#totalAmount').css('display','block')
                 $('.paybutton').css('display','block')
             }else{
                 $('#totalAmount').css('display','none')
                 $('.paybutton').css('display','none')
             }
        }
        $(document).ready(function() {
            $('.show-exp-summary').on('click', function(e) {
                $(this).parents('.expert-details').find('.expert-summary').addClass('show');
            });
            $('.expert-summary .close').on('click', function() {
                $(this).parent('.expert-summary').removeClass('show');
            })
        });
    </script>
 @endpush
