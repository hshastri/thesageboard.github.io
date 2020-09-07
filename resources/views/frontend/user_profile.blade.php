@extends('frontend.layout.app')
@section('main')

    <section class="profile-header">
        <div class="container header-container">
            <div class="row">
                <div class="col-md-12 header-flex">
                    <div class="user-profile-img">
                        <img src="{{($users->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$users->avatar)}}" alt="admin">
                    </div>
                    <div class="header-content">
                        <h2 class="profile-name">{{$users->first_name}} {{$users->last_name}} </h2>
                        <h3 class="profile-title mb-2">{{@$user_details->profession}}</h3>
                        {{--<span><i class="fas fa-location-arrow"></i>St. Colridge</span>--}}
                        <span><a target="_blank" href="{{@$user_details->googleplus}}"><i class="fab fa-twitter"></i>Instagram</a></span>
                        <span><a target="_blank" href="{{@$user_details->twitterlink}}"><i class="fab fa-twitter"></i>Twitter</a></span>
                        <span><a target="_blank" href="{{@$user_details->fblink}}"><i class="fab fa-facebook"></i>Facebook</a></span>
                        <span><a target="_blank" href="{{@$user_details->linkedin}}"> <i class="fab fa-linkedin"></i>Linkedin</a></span>
                    </div>
                    @php
                        $score =  $user_details->general_reputation_score + $user_details->expert_reputation_score;
                    @endphp
                    <div class="repuation-score text-center">
                        <div class="answer-fee shadow text-left">
                            <span class="fee fee-text">Answer fees:</span>
                            <span class="fee fee-amount">${{@$user_details->expertise_rate}}</span>
                        </div>
                        <div class="profile-reputation shadow mt-4">
                            <span class="score">{{$score}}</span>
                            <p class="badge badge-icon"><i class="{{App\Badge::where('score','<=',$score)->orderBy('id', 'DESC')->value('icon')}}"></i></p>
                            <p class="badge badge-title">
                                <span class="badge-name">
                                    {{App\Badge::where('score','<=',$score)->orderBy('id', 'DESC')->value('name')}}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="profile-body mt-5">
        <div class="container profile-body-container pb-5">
            <div class="row px-4">
                <div class="col-md-4 pl-2">
                    <div class="ul_list ul_list-icon-ok about-user">
                        <ul>
                            <li><i class="fas fa-school"></i>Education Summary:   <span>{{(@$user_details->graduation!='')?@$user_details->graduation:@$user_details->college}}</span></li>
                            <li><i class="fas fa-plus"></i>Registered : <span>{{date('Y-m-d h:i', strtotime($user_details->created_at))}}</span></li>
                            <li><i class="fas fa-map-marker"></i>Country : <span>{{@$user_details->country}}</span></li>
                            <li><i class="fas fa-map-marker-alt"></i>Location : <span>{{@$user_details->hometown}}</span></li>
                            <li><i class="fas fa-globe"></i>Website : <a target="_blank" href="{{$user_details->website}}">{{$user_details->website}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 pr-2 profile-bio">
                    <h2>Overview</h2>
                    <p>{!! @$user_details->bio !!}</p>
                </div>
            </div>
            <div class="row px-4 profile-activity">
                <div class="col-md-6">
                    <div class="user-expertise">
                        @if(@$user_details->expert_category)
                        <h2>Expertise Area</h2>
                        @foreach(json_decode(@$user_details->expert_category) as $category)
                        <div class="expertise-item mt-3">
                            @php
                              $category = App\Category::where('id', $category)->first();
                            @endphp
                            <span class="topic">{{$category->name}}</span>
                            @foreach(json_decode(@$user_details->expert_subcategory) as $subcategory)
                                @php
                                    $subcategory =  App\SubCategory::where('id', $subcategory)->first();
                                @endphp
                                @if($subcategory  && $subcategory->category_id == $category->id )
                                    <span><a href="javascript:void(0)">{{$subcategory->name}}</a></span>
                                @else
                                @endif
                            @endforeach

                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>User Activity</h2>
                    <div class="profile-statistics">
                        <p>
                            <span class="activity">Avg. Response Time : </span><span class="activity-value">{{$art}}</span>
                        </p>
                        <p>
                            <span class="activity">Answers : </span><span class="activity-value">{{App\Answer::where(['user_id'=> $users->id,'type'=> 1])->count()}}</span>
                        </p>
                        <p>
                            <span class="activity">Questions : </span><span class="activity-value">{{App\AskQuestion::where('user_id', $users->id)->count()}}</span>
                        </p>
                        <span>Answers acceptance</span>
                        <div class="progress mb-3" style="height:25px">
                            <div class="progress-bar bg-color" role="progressbar" style="max-width: {{$aap}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$aap}}%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row px-4 mt-5">
                <div class="col-md-6">
                    <div class="repuation-distribution">
                        <h3>Points Allocation:</h3>
                        <ul class="score-header">
                            <li>Tags</li>
                            <li>Points</li>
                        </ul>
                        @if(count($reputation) > 0 )
                        @foreach($reputation as $reputation)
                        <div class="score-wrap">
                            <span class="user-tags">{{$reputation->tag}}</span>
                            <span class="user-points">{{$reputation->point}}</span>
                        </div>
                        @endforeach
                        @else
                            <div class="alert-message error">
						        <i class="fas fa-flag"></i>
						        <p>You have not earned points yet.</p>
						    </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="tabs-warp">
                        <ul class="tabs">
                            <li class="tab"><a href="#" class="current">Top Question</a></li>
                            <li class="tab"><a href="#" class="">Top Answers</a></li>
                        </ul>
                        <div class="tab-inner-warp" style="">
                            <div class="tab-inner" id="widget_question">
                                @php
                                  $qsn = App\AskQuestion::where('user_id', $users->id)->limit(4)->get();
                                @endphp
                                @foreach($qsn as $questions)
                                <div class="widget_question">
                                    <h2><a href="{{route('question-details', base64_encode($questions->id))}}">{{$questions->question_title}}</a></h2>
                                    <p class="question-content">{{substr(strip_tags( $questions->description ),0,300)}}</p>
                                    <span>answers: {{$questions->totalanswer}}</span>
                                    <span>votes: {{$questions->totalvote}}</span>
                                    <span>{{($questions->isSolved=='yes')?'Solved':'Not Solved'}}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-inner-warp">
                            <div class="tab-inner" id="small_expert_area">
                               {{-- @php
                                    $answers =   App\Answer::where('user_id', $users->id)->limit(4)
                                @endphp--}}
                                @foreach($answers as $ans)
                                @php
                                    $question = App\AskQuestion::where('id', $ans->question_id)->first()
                                @endphp
                                <div class="widget_question">
                                    <h2><a href="{{route('question-details', base64_encode($question->id))}}">{{$question->question_title}}</a></h2>
                                    <p class="question-content">{{substr(strip_tags( $ans->answer ),0,300)}}</p>
                                    <span>answers: {{$question->totalanswer}}</span>
                                    <span>votes: {{$question->totalvote}}</span>
                                    <span>{{($question->isSolved=='yes')?'Solved':'Not Solved'}}</span>
                                    {{-- <h2><a href="{{route('question-details', base64_encode($ans->question_id))}}"><p>{{substr(strip_tags( $ans->answer ),0,300)}}</p></a></h2>
                                   <span>ans: 0</span>
                                    <span>votes: 1</span>
                                    <span>{{$ans->accepted}}</span>--}}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@push("js")

@endpush
