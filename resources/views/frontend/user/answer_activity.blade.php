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
                        <a  class="page-links active" href="{{route('user-answer')}}">My Answers</a>
                        <a  class="page-links" href="{{route('score-allocation')}}">Score Allocation</a>
                    </h4>
                    @foreach($answers  as $ans)
                    <div class="row mt-3 shadow-sm">
                        <div class="col-md-9">
                            <div class="top-question-single mb-0">
                                <div class="row">
                                    <div class="col-2 col-sm-2 col-md-2 col-lg-2 pl-lg-0 pr-lg-0 statistics">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 stat-box">
                                                <div class="stat-wrap">
                                                    <span class="stat-num">{{App\Voting::where('answer_id', $ans->id)->count()}}</span>
                                                    <span class="votes-icon">Votes</span>
                                                </div>
                                            </div>
                                           {{-- <div class="col-md-12 col-lg-12 stat-box">
                                                <div class="stat-wrap">
                                                    <span class="stat-num">20</span>
                                                    <span class="comments-icon">Answers</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12 stat-box">
                                                <div class="stat-wrap">
                                                    <span class="stat-num">30</span>
                                                    <span class="views-icon">Views</span>
                                                </div>
                                            </div>--}}
                                        </div>
                                    </div>
                                    <div class="col-10 col-sm-10 col-md-10 col-lg-10 pt-2 question-details">
                                        @php
                                            $question = App\AskQuestion::where('id', $ans->question_id)->first()
                                        @endphp
                                        <h3><a href="{{route('question-details', base64_encode($question->id))}}">{{$question->question_title}}</a></h3>
                                        <p>{{substr(strip_tags( $ans->answer ),0,300)}}</p>
                                        <div class="cats">
                                            <span class="cat">{{$question->tags}}</span>
                                        </div>
                                        <div class="author-box">
                                            <span class="time">Posted: {{date('h:i A Y-m-d ', strtotime($ans->created_at))}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 pt-2  text-center">
                            <a class="question-edit-send shadow-sm" href="{{route('answer-edit', base64_encode($ans->id))}}"><i class="fas fa-edit"></i>Edit Answer</a>
                        </div>
                        {{--<div class="col-md-2 pt-2 text-center">
                            <a class="question-edit-send shadow-sm" href="#"><i class="far fa-paper-plane"></i>Send To Expert</a>
                        </div>--}}
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pagination">
                {{ $answers->links() }}
            </div>

        </div>
@endsection
