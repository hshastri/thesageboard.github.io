@foreach($user as $user)
    @if(@$user->user->id!=null && $user->user->role=="Expertise")
        <div class="small_expert_area">
        <img src="{{($user->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$user->user->avatar)}}" class="avatar" alt="">
        <div class="details">
            <h3><a href="{{route('profile', $user->user->username)}}">{{$user->user->first_name.' '.$user->user->last_name}}</a></h3>
            <p>{{$user->profession}}</p>
            <span>points: {{$user->general_reputation_score+$user->expert_reputation_score}}</span>
            <span>answers: {{App\Answer::where('user_id', $user->user_id)->count()}}</span>
            <span>questions: {{App\AskQuestion::where('user_id', $user->user_id)->count()}}</span>
        </div>
    </div>
    @endif
@endforeach

