@extends('frontend.user.user_app')
@section('user_content')

        <div class="row">
            <div class="col-md-12 user-activity-analysis">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="user-activity text-center shadow">
                            <a href="">
                                <span class="activity amount">{{$total_answer}}</span>
                                <span class="activity title">Answers</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="user-activity text-center shadow">
                            <a href="">
                                <span class="activity amount">{{$aap}}%</span>
                                <span class="activity title">Answers Acceptance</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="user-activity text-center shadow">
                            <a href="">
                                <span class="activity amount">{{$art}}</span>
                                <span class="activity title">Response Time</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="user-activity text-center shadow">
                            <a href="">
                                <span class="activity amount">{{$total_question}}</span>
                                <span class="activity title">Questions</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 my-5 activity-questions-answers">
                <div class="profile-bg">
                    <h3>My Postings</h3>
                    <h4>
                        <a class="page-links" href="{{route('user-activity')}}">My Questions</a>
                        <a  class="page-links" href="{{route('user-answer')}}">My Answers</a>
                        <a  class="page-links active" href="{{route('score-allocation')}}">Score Allocation</a>
                    </h4>
                    <div class="row mt-3">

                        <div class="col-md-8 repuation-distribution">
                            <ul class="score-header">
                                <li>Tags</li>
                                <li>Points</li>
                            </ul>
                            @foreach($reputation as $reputation)
                            <div class="score-wrap">
                                <span class="user-tags">{{$reputation->tag}}</span>
                                <span class="user-points">{{$reputation->point}}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
