<div>
    @if(count($notification)==0)
        <div class="col-12 notification-item unviewed">
            <p>No Notification yet</p>
        </div>
    @endif
    @foreach($notification as $noty)
    <div class="col-12 notification-item {{($noty->is_read==0)?'':'unviewed'}}" >
        @if($noty->type==2 || $noty->type==3 || $noty->type==8 || $noty->type==5)
            @php
                $question = App\AskQuestion::where('id',$noty->question_id)->first();
            @endphp
            @if($question->user_id==Auth::user()->id)
            <a class="d-block" href="{{route('user-question-details',['qid'=>base64_encode($noty->question_id) , 'uid'=>base64_encode($noty->create_user_id)])}}" onclick="return readNotication('{{route('readNoty' , $noty->id)}}')">
            @else
              <a class="d-block" href="{{route('user-question-details',['qid'=>base64_encode($noty->question_id) , 'uid'=>base64_encode($noty->notify_user_id)])}}" onclick="return readNotication('{{route('readNoty' , $noty->id)}}')">
             @endif

         @elseif($noty->type==7)
            <a class="d-block" href="{{route('earnings')}}" onclick="return readNotication('{{route('readNoty' , $noty->id)}}')">
         @else
            <a class="d-block" href="{{route('question-details', [base64_encode($noty->question_id), $noty->question->slug] )}}" onclick="return readNotication('{{route('readNoty' , $noty->id)}}')">
         @endif
            <div class="row py-2">
                <div class="col-2 pr-0">
                    <div class="author-avatar">
                        <img src="{{($noty->user->avatar =='')?asset('assets/images/avatar.png'): asset('public/'.$noty->user->avatar)}}" alt="image">
                    </div>
                </div>
                <div class="col-10 pl-0">
                    <div class="notification-action-title">
                        @if($noty->type==1)
                            <h5 class="mb-0">{{$noty->user->first_name}} {{$noty->user->last_name}} has submitted an answer to your question.</h5>
                        @elseif($noty->type==2)
                            <h5 class="mb-0">{{$noty->user->first_name}} {{$noty->user->last_name}} has updated your private question.</h5>
                        @elseif($noty->type==3)
                            <h5 class="mb-0">{{$noty->user->first_name}} {{$noty->user->last_name}} Asked you a private Question.</h5>
                        @elseif($noty->type==4 || $noty->type==5)
                            <h5 class="mb-0">{{$noty->user->first_name}} {{$noty->user->last_name}} has accepted your answer.</h5>
                        @elseif($noty->type==6)
                            <h5 class="mb-0">{{$noty->user->first_name}} {{$noty->user->last_name}} has commented on your question.</h5>
                        @elseif($noty->type==7)
                            <h5 class="mb-0">Payment Received ! {{$noty->user->first_name}} {{$noty->user->last_name}} accepted your answer.</h5>
                        @elseif($noty->type==8)
                            <h5 class="mb-0">{{$noty->user->first_name}} {{$noty->user->last_name}} posted a new reply to your private question.</h5>
                        @elseif($noty->type==9)
                            <h5 class="mb-0">{{$noty->user->first_name}} {{$noty->user->last_name}} has upvoted your question.</h5>
                        @elseif($noty->type==10)
                            <h5 class="mb-4">{{$noty->user->first_name}} {{$noty->user->last_name}} Sage Support has asked a question in one of your expertise areas.</h5>
                        @elseif($noty->type==11)
                            <h5 class="mb-0">{{$noty->user->first_name}} {{$noty->user->last_name}} has upvoted your answer.</h5>
                        @endif
                    </div>
                </div>
                <div class="col-10 pl-0 offset-2 notification-content">
                    <div class="notification-action-desc">
                        <p>{!! $noty->notify_title !!}</p>
                        <div class="notificaiton-meta">
                            <span class="meta-item-badge time"><i class="fas fa-clock"></i>{{convert_time($noty->created_at)}} ago</span>
                            @if($noty->type==1)
                                <span class="meta-item-badge comment"><i class="fas fa-comment"></i>Answer</span>
                            @elseif($noty->type==2)
                                <span class="meta-item-badge comment"><i class="fas fa-question-circle"></i>Answer Private Question</span>
                            @elseif($noty->type==3)
                                <span class="meta-item-badge comment"><i class="fas fa-question"></i>Ask Private Question</span>
                            @elseif($noty->type==4 || $noty->type==5)
                                <span class="meta-item-badge comment"><i class="fas fa-comment"></i>Answer Acceptance</span>
                            @elseif($noty->type==6)
                                <span class="meta-item-badge comment"><i class="fas fa-comment"></i>Comment</span>
                            @elseif($noty->type==7)
                                <span class="meta-item-badge comment"><i class="fas fa-comment-dollar"></i>Payment</span>
                            @elseif($noty->type==8)
                                <span class="meta-item-badge comment"><i class="fas fa-reply"></i>Reply</span>
                            @elseif($noty->type==9 || $noty->type==11)
                                <span class="meta-item-badge comment"><i class="fas fa-question"></i>Reply</span>
                            @elseif($noty->type==10)
                                <span class="meta-item-badge comment"><i class="{{$noty->question->category->icon}}"></i>{{$noty->question->category->name}} :: {{$noty->question->subcategory->name}}</span>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
