@extends('frontend.user.user_app')
@section('user_content')

        <div class="row">
            <div class="col-md-12 user-activity-analysis">
                <div class="row">
                    <div class="col-6 col-md-3 mb-3 mb-sm-3 mb-md-0 mb-lg-0">
                        <div class="user-activity text-center shadow">
                            <a href="">
                                <span class="activity amount">{{$total_answer}}</span>
                                <span class="activity title">Answers</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3 mb-sm-3 mb-md-0 mb-lg-0">
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
            <div class="col-md-12 my-3 my-sm-4 my-md-4 activity-questions-answers">
                <div class="profile-bg">
                    <h3>My Postings</h3>
                    <h4>
                        <a class="page-links active" href="{{route('user-activity')}}">My Questions</a>
                        <a  class="page-links" href="{{route('user-answer')}}">My Answers</a>
                        <a  class="page-links" href="{{route('score-allocation')}}">Score Allocation</a>
                    </h4>
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
                                        <h3>
                                            <a href="{{route('question-details', base64_encode($question->id) )}}">{{ucfirst($question->question_title)}}</a>
                                        </h3>
                                        <p>{{substr(strip_tags($question->description),0,300)}}fgfg.</p>
                                        <div class="cats">
                                            <span class="cat">{{$question->tags}}</span>
                                        </div>
                                        <div class="author-box">
                                            <span class="time">Posted: {{date('h:i A Y-m-d ', strtotime($question->created_at))}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-2 pt-2  text-center">
                            <a class="question-edit-send shadow-sm" href="{{route('question-edit', base64_encode($question->id))}}"><i class="fas fa-edit"></i>Edit Question</a>
                        </div>
                        <div class="col-md-2 pt-2 text-center">
                            <a class="question-edit-send shadow-sm" href="{{route('chosen-expert', base64_encode($question->id) )}}"><i class="far fa-paper-plane"></i>Send To Expert</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12 mb-2 mb-md-3">
                <div class="pagination">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
@endsection
