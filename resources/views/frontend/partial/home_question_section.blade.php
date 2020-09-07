<h2>Latest Questions</h2>
<div class="row">
    @foreach($question as $question)
        <div class="col-md-12">
            <div class="top-question-single">
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
                    <div class="col-10 col-sm-10 col-md-10 col-lg-10 question-details">
                        <h3><a href="{{route('question-details', [base64_encode($question->id), $question->slug] )}}">{{ucfirst($question->question_title)}}</a></h3>

                        <p>{{ strip_tags($question->description) }}</p>
                        <div class="cats">
                            <span class="cat">{{$question->tags}}</span>
                        </div>
                        <div class="author-box">
                            <span class="time">asked: UTC {{date('Y-m-d h:i A', strtotime($question->created_at))}}</span>
                            <div class="author-details">
                                <img src="{{($question->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$question->user->avatar)}}" alt="image">
                                <span class="author">
                                    <a href="{{route('profile', $question->user->username)}}" class="author-name">{{$question->user->username}}</a>
                                    <span class="score">({{App\UserDetails::where('user_id', $question->user_id)->value('general_reputation_score') + App\UserDetails::where('user_id', $question->user_id)->value('expert_reputation_score')}})</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<a href="{{route('questions')}}" class="float-right link-button">All Questions</a>
