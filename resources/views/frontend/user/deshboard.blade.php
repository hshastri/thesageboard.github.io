@extends('frontend.user.user_app')
@section('user_content')
    @php
       $users =  App\UserDetails::where('user_id', Auth::user()->id)->first();
    @endphp
    <div class="row user-profile">
        <div class="col-md-12 profile-header">
            <div class="header-flex shadow">
                <div class="user-profile-img">
                    <img src="{{(Auth::user()->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.Auth::user()->avatar)}}" alt="admin">
                </div>
                <div class="header-content">
                    <a class="d-block" href="{{route('profile', Auth::user()->username) }}">
                        <h2 class="profile-name">{{Auth::user()->first_name}} {{Auth::user()->last_name}} </h2>
                    </a>
                    <h3 class="profile-title">{{@$user_details->profession}}</h3>
                    <a class="mb-2 d-block" style="color: #2f3239;font-family: 'Nunito', sans-serif;" target="_blank" href="{{@$user_details->website}}">{{@$user_details->website}}</a>
                    <span><a target="_blank" href="{{@$user_details->googleplus}}"><i class="fab fa-instagram"></i>Instagram</a></span>
                    <span><a target="_blank" href="{{@$user_details->twitterlink}}"><i class="fab fa-twitter"></i>Twitter</a></span>
                    <span><a target="_blank" href="{{@$user_details->fblink}}"><i class="fab fa-facebook"></i>Facebook</a></span>
                    <span><a target="_blank" href="{{@$user_details->linkedin}}"> <i class="fab fa-linkedin"></i>Linkedin</a></span>
                </div>
                @php
                    $score =  $user_details->general_reputation_score + $user_details->expert_reputation_score;
                @endphp
                @if($score>=0)
                <div class="repuation-score text-center">
                    <div class="answer-fee shadow text-left">
                        <span class="fee fee-text">Answer fees:</span>
                        <span class="fee fee-amount">${{@$user_details->expertise_rate}}</span>
                    </div>
                    <div class="profile-reputation shadow mt-4">
                        <span class="score">{{$score}}</span>
                        <p class="badge badge-icon"><i class="{{App\Badge::where('score','<=',$score)->orderBy('id', 'DESC')->value('icon')}}"></i></p>
                        <p class="badge badge-title"><span class="badge-name">
                                {{App\Badge::where('score','<=',$score)->orderBy('id', 'DESC')->value('name')}}
                            </span>
                        </p>
                    </div>
                </div>
                    @endif
            </div>
        </div>
        <div class="col-md-12 mt-3 mt-md-5">
            <div class="profile-bg private-general-info">
                <h1>Biography</h1>
                <div class="row">
                    <div class="col-md-12 profile-bio">
                        <p>{!! @$user_details->bio !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3 mt-md-5">
            <div class="profile-bg">
                <h1>Basic Information</h1>
                <div class="private-basic-information">
                    <div class="education-levels profile-sub-item mb-3">
                        <h4>Education Summary</h4>
                        <p>{{@$user_details->graduation}}</p>
                        <p>{{@$user_details->college}}</p>
                    </div>
                    <div class="contact-informatin profile-sub-item mb-3">
                        <h4>Contact Information</h4>
                        <p><span>Country : </span><span>{{@$user_details->country}}</span></p>
                        <p><span>Location: </span><span>{{@$user_details->hometown}}</span></p>
                        <p><span>Address: </span><span>{{@$user_details->contactmail}}</span></p>
                        <p><span>Telephone Number: </span><span>{{@$user_details->phone}}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3 mt-md-5">
            <div class="profile-bg">
                <h1>User Statistics</h1>
                <div class="user-porfile-statistics pb-4">
                    <div class="user-stat">
                        <span>Avg. Response time : </span>
                        <span> {{$art}}</span>
                    </div>
                    <div class="user-stat">
                        <span>Answers : </span>
                        <span> {{$total_answer}}</span>
                    </div>
                    <div class="user-stat">
                        <span>Answer Acceptance</span>
                        <span> {{$aap}}%</span>
                    </div>
                    <div class="user-stat">
                        <span>Questions : </span>
                        <span>{{App\AskQuestion::where('user_id',Auth::user()->id)->count()}}</span>
                    </div>
                </div>
            </div>
        </div>
        @if($topics = json_decode(@$user_details->expert_category))
        <div class="col-md-12 my-3 my-md-5">
            <div class="profile-bg">
                <h1>Expertise Area</h1>
                <div class="user-expertise-topic-sub-topics">
                    @foreach($topics as $cat)
                        <div class="topic-items-with-tags mb-3 profile-sub-item">
                            @php
                                $dcategory = App\Category::where('id', $cat)->first();
                            @endphp
                            <h4>{{$dcategory->name}}</h4>
                            @foreach(json_decode(@$user_details->expert_subcategory) as $subcat)
                                @php
                                    $dsubcategory =  App\SubCategory::where('id', $subcat)->first();
                                @endphp
                                @if($dsubcategory && $dsubcategory->category_id == $dcategory->id )
                                    <span>{{$dsubcategory->name}}</span>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div><!-- End user-profile -->
@endsection
