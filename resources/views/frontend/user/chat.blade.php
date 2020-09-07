@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 mb-5">
            <div class="profile-bg">
                <h1>Chats</h1>
                <div class="transaction-item border-bottom border-success mb-3 py-3 px-3">
                    <div class="tab-pane fade show active" id="{{$refund->expert->username}}">
                        <ul class="media-list media-chat mb-3">
                            @php
                                $chats = App\Chat::where(['user_id'=>$refund->expert_id,'question_id'=>$refund->question_id])->get();
                            @endphp
                            @foreach($chats as $chat)
                                @if($chat->admin==0)
                                    <li class="media">
                                        <div class="mr-3">
                                            <a href="#">
                                                <img src="{{($refund->expert->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$refund->expert->avatar)}}" class="rounded-circle" width="40" height="40" alt="">
                                            </a>
                                        </div>

                                        <div class="media-body">
                                            <div class="media-chat-item">{{$chat->massage}}</div>
                                            <div class="font-size-sm text-muted mt-2">{{$chat->created_at}} <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>
                                        </div>
                                    </li>
                                @else
                                    <li class="media media-chat-item-reverse">
                                        <div class="media-body">
                                            <div class="media-chat-item">{{$chat->massage}}</div>
                                            <div class="font-size-sm text-muted mt-2">{{$chat->created_at}} <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>
                                        </div>
                                        <div class="ml-3">
                                            <a href="#">
                                                <img src="{{asset('assets/images/face1.jpg')}}" class="rounded-circle" width="40" height="40" alt="">
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        <form action="{{route('chat')}}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$refund->expert_id}}">
                            <input type="hidden" name="question_id" value="{{$refund->question_id}}">
                            <textarea name="message" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..." required></textarea>
                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto"><b><i class="icon-paperplane"></i></b> Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('js')

@endpush
