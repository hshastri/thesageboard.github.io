@foreach($question as $question)
<div class="widget_question">
    <h2><a href="{{route('question-details', base64_encode($question->id))}}">{{ucfirst($question->question_title)}}</a></h2>
    <span>answers: {{$question->totalanswer}}</span>
    <span>votes: {{$question->totalvote}}</span>
    <br>
    <span>asked: <a href="{{route('profile', $question->user->username)}}">{{$question->user->username}}, {{App\UserDetails::where('user_id', $question->user_id)->value('general_reputation_score')+App\UserDetails::where('user_id', $question->user_id)->value('expert_reputation_score')}}</a></span>
</div>
@endforeach
