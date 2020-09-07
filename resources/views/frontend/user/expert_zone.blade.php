@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 mb-4 activity-questions-answers">
            <div class="profile-bg">
                {{--<h3 class="mb-2 mb-md-0 mb-lg-0 mb-xl-0">My Expert Contents</h3>--}}
                <form action="{{route('expert-zone')}}" method="GET">
                    @csrf
                    <h4 class="d-flex">
                        <div class="zone-link">
                            <input type="radio" name="question" id="my-questions" value="1" {{($setdata==1)?"checked":''}}  onclick="this.form.submit()">
                            <label for="my-questions">My Questions</label>
                        </div>
                        <div class="zone-link">
                            <input type="radio" name="question" id="answer-request" value="2" {{($setdata==2)?"checked":''}} onclick="this.form.submit()">
                            <label for="answer-request">Answer Requests <span>{{App\AskQuestion::whereRaw('JSON_SEARCH(experties_ids, "one","'.Auth::user()->id.'") IS NOT NULL')->where(['viewed'=>'0','question_label'=>'Premium'])->count()}}</span></label>
                        </div>
                    </h4>
                </form>
                @foreach($questions as $question)
                <div class="row mt-3 shadow-sm">
                    <div class="col-md-8">
                        <div class="top-question-single mb-0">
                            <div class="row">
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 pl-lg-0 pr-lg-0 statistics">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 stat-box">
                                            <div class="stat-wrap">
                                                <span class="stat-num">{{sign_vote($question->total_vote($question->id))}}</span>
                                                <span class="votes-icon">Votes</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12 stat-box">
                                            <div class="stat-wrap">
                                                <span class="stat-num">{{$question->totalanswer}}</span>
                                                <span class="comments-icon">Answers</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12 stat-box">
                                            <div class="stat-wrap">
                                                <span class="stat-num">{{$question->totalview}}</span>
                                                <span class="views-icon">Views</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-10 col-sm-10 col-md-10 col-lg-10 pt-2 question-details">
                                    <h3><a href="#">{{ucfirst($question->question_title)}}</a>@if($question->viewed == 0 && $question->user_id != Auth::user()->id) <span class="pull-right badge badge-info">New</span> @endif</h3>
                                    <p>{{ substr(strip_tags($question->description),0,200)  }}..</p>
                                    <div class="cats">
                                        <span class="cat">{{$question->tags}}</span>
                                    </div>
                                    <div class="author-box">
                                        <span class="time">Posted: {{$question->created_at}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 pt-md-2 px-md-4 text-center">
                        @php
                            $isResolved = $question->isSolved=='yes'?'resolved':'unresolved';
                            $isPaid     = $question->isSolved=='yes'?'Paid':'Escrowed';
                        @endphp
                        <span class="expert-zone-status d-inline-block tooltip-n d-md-block {{$isResolved}} shadow-sm" original-title="Question Status"><i class="fas fa-check-circle"></i>{{ucfirst($isResolved)}}</span>
                        <span class="expert-zone-status d-inline-block tooltip-n d-md-block {{$isResolved}} shadow-sm" original-title="Payment Status"><i class="fas fa-check-circle"></i>{{ucfirst($isPaid)}}</span>
                    </div>
                    @if($question->user_id == Auth::user()->id)
                    <div class="col-md-2 pt-2">
                        <span class="expert-zone-status talk-action d-block">Talk to Sage</span>
                        @foreach(json_decode(@$question->experties_ids) as $expert)
                            @php
                                $user = App\User::where('id', $expert)->first();
                                $user_details = App\UserDetails::where('user_id', $expert)->first();
                            @endphp
                            <div class="single-expert-wrapper">
                                <a href="{{route('user-question-details',['qid'=>base64_encode($question->id) , 'uid'=>base64_encode($expert)])}}" class="single-expert d-block">{{$user->first_name}} {{$user->last_name}}</a>
                                <span class="show-summary"><i class="fas fa-info-circle"></i></span>
                                <div class="expert-summary shadow d-flex">
                                    <img src="{{($user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$user->avatar)}}" alt="image">
                                    <div class="summary">
                                        <h3>{{$user->username}} <span>{{App\Badge::where('score','<=',$user_details->general_reputation_score + $user_details->expert_reputation_score)->orderBy('id', 'DESC')->value('name')}}</span></h3>
                                        <h4>{{$user_details->profession}}</h4>
                                        <div class="expert-statistics mt-2">
                                            <span>Response Time: {{$user->art($user->id)}}</span>
                                            <span>Answers: {{ App\Answer::where('user_id')->count() }}</span>
                                            <span>Acceptance: {{$user->acceptence($user->id)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @else
                        <div class="col-md-2 pt-2">
                            <span class="expert-zone-status talk-action d-block">Talk to Seeker</span>
                        @foreach(json_decode(@$question->experties_ids) as $expert)
                            @if($expert== Auth::user()->id)
                                @php
                                    $user = App\User::where('id', $question->user_id)->first();
                                    $user_details = App\UserDetails::where('user_id', $question->user_id)->first();
                                @endphp
                                <div class="single-expert-wrapper">
                                    <a href="{{route('user-question-details',['qid'=>base64_encode($question->id) , 'uid'=>base64_encode($expert)])}}" class="single-expert d-block">{{$user->first_name}} {{$user->last_name}}</a>
                                    <span class="show-summary"><i class="fas fa-info-circle"></i></span>
                                    <div class="expert-summary shadow d-flex">
                                        <img src="{{($user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$user->avatar)}}" alt="image">
                                        <div class="summary">
                                            <h3>{{$user->username}} <span>{{App\Badge::where('score','<=',$user_details->general_reputation_score + $user_details->expert_reputation_score)->orderBy('id', 'DESC')->value('name')}}</span></h3>
                                            <h4>{{$user_details->profession}}</h4>
                                            <div class="expert-statistics mt-2">
                                                <span>Response Time: {{$user->art($user->id)}}</span>
                                                <span>Answers: {{ App\Answer::where('user_id')->count() }}</span>
                                                <span>Acceptance: {{$user->acceptence($user->id)}}</span>
                                            </div>
                                        </div>
                                    </div>
                             </div>
                            @endif
                        @endforeach
                        </div>
                    @endif

                </div>
                @endforeach
            </div>
        </div>
        <div class="pagination">
            {{ $questions->appends(['question' =>$setdata])->links() }}
        </div>
    </div>
@endsection
@push('js')
    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        $(document).ready(function() {
            $('body').on('click', function(e) {
                if($(e.target).parents('.expert-summary').length > 0) return;
                if($(e.target).parent('.show-summary').length > 0) {
                    var targetElement = $(e.target).parent('.show-summary'),
                        shownTargetDom = targetElement.parent('.single-expert-wrapper').siblings('.single-expert-wrapper').find('.expert-summary'),
                        shownTargetDomBoolean = shownTargetDom.hasClass('show');
                    if(shownTargetDom) {
                        shownTargetDom.removeClass('show');
                    }
                    targetElement.next('.expert-summary').toggleClass('show');
                } else {
                    $('.expert-summary').removeClass('show');
                }
            });
        });
    </script>
@endpush
