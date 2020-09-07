<div>
    @if(Auth::check() && Auth::user()->id)
    <div class="post-comment mb-3 post-qsn">
        <form id="cmntForm">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control cmntradious inputformPrevent" name="questioncomment"  placeholder="Add Comment" onkeyup="toggleButton(this, 'addcomment')" autocomplete="off">

                <div class="input-group-append">
                    <button type="button" class="btn btn-success btn-sm cmntradious" disabled="disabled" id="addcomment" onclick="postFormData('{{route('question-comment', $id)}}', 'cmntForm')">Add Comment</button>
                </div>
            </div>
        </form>
    </div>
    @else
     <a href="javascript:void(0)" onclick="popupConfirm()" class="addcomment">add a comment</a>
    @endif

    @foreach($comment as $qsncmt)
        <div class="single-comment-wrapper mb-4">
            <div class="single-comment px-3">
                <div class="author-box d-flex align-items-center">
                    <span class="author-avatar"><img src="{{($qsncmt->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$qsncmt->user->avatar)}}" alt=""></span>
                    <span class="author-name ml-2"><a href="{{route('profile', base64_encode($qsncmt->user->username))}}">{{$qsncmt->user->first_name}} {{$qsncmt->user->last_name}}</a></span>
                    <span class="posting-time ml-2"> UTC {{date('Y-m-d h:i A', strtotime($qsncmt->created_at))}}</span>
                </div>
                <div class="comment-box">
                    <p id="boxqsnchild{{$qsncmt->id}}">{{$qsncmt->comment}}</p>
                    <p class="mt-2">
                        <a class="reply-button" href="javascript:void(0)" onclick="addQsnReply('{{route('question-child-comment', base64_encode($qsncmt->id))}}','qsnchild{{$qsncmt->id}}')"><i class="icon-reply-outline"></i> Reply</a>
                        @if(Auth::check() &&  Auth::user()->id == $qsncmt->user_id)
                            <a class="edit-comment ml-3" href="javascript:void(0)" onclick="editQsnReplyDiv('boxqsnchild{{$qsncmt->id}}' ,'{{route('edit-qsn-child-comment' , $qsncmt->id)}}','boxqsnchild{{$qsncmt->id}}')">Edit</a>
                            <a class="ml-3 delete-comment" href="javascript:void(0)" style="color: red" onclick="delete_qsn_comment('{{route('delete-qsn-child-comment',base64_encode($qsncmt->id))}}')" >Delete</a>
                        @endif
                </div>
            </div>
            <div class="post-comment my-3 px-3 qsnreplydiv" id="qsnchild{{$qsncmt->id}}">

            </div>
            <ul class="ml-4 mt-3">
                @foreach($qsncmt->childComment as $child)
                <li>
                    <div class="single-comment px-3 mb-4">
                        <div class="author-box d-flex align-items-center">
                            <span class="author-avatar"><img src="{{($child->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$child->user->avatar)}}" alt=""></span>
                            <span class="author-name ml-2"><a href="{{route('profile', $child->user->username)}}">{{$child->user->first_name}} {{$child->user->last_name}}</a></span>
                            <span class="posting-time ml-2"> UTC {{date('Y-m-d h:i A', strtotime($child->created_at))}}</span>
                        </div>
                        <div class="comment-box">
                            <p id ="boxqsnSub{{$child->id}}">{{$child->comment}} </p>
                            <p class="mt-2"><a class="reply-button" href="javascript:void(0)" onclick="addSubQsnReply('{{route('question-sub-child-comment', base64_encode($child->id))}}','qsnSubchild{{$child->id}}')"><i class="icon-reply-outline"></i> Reply </a>
                            @if(Auth::check() &&  Auth::user()->id == $child->user_id)
                                <a class="edit-comment ml-3" href="javascript:void(0)" onclick="editQsnReplyDiv('boxqsnSub{{$child->id}}' ,'{{route('edit-sub-child-comment' , $child->id)}}','boxqsnSub{{$child->id}}')">Edit</a>
                                <a class="ml-3 delete-comment" href="javascript:void(0)" style="color: red" onclick="delete_qsn_comment('{{route('delete-qsn-sub-comment',base64_encode($child->id))}}')" >Delete</a>
                            @endif
                        </div>
                    </div>
                    <div class="post-comment my-3 px-3 qsnreplydiv" id="qsnSubchild{{$child->id}}">

                    </div>
                    <ul class="ml-4">
                        @foreach($child->subComment as $subchild)
                            <li>
                                <div class="single-comment px-3 mb-4">
                                    <div class="author-box d-flex align-items-center">
                                        <span class="author-avatar"><img src="{{($subchild->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$subchild->user->avatar)}}" alt=""></span>
                                        <span class="author-name ml-2"><a href="{{route('profile', $subchild->user->username)}}">{{$subchild->user->first_name}} {{$subchild->user->last_name}}</a></span>
                                        <span class="posting-time ml-2"> UTC {{date('Y-m-d h:i A', strtotime($subchild->created_at))}}</span>
                                    </div>
                                    <div class="comment-box">
                                        <p id="boxqsnSubChild{{$subchild->id}}">{{$subchild->comment}} </p>

                                        @if(Auth::check() &&  Auth::user()->id == $subchild->user_id)
                                            <a class="edit-comment ml-3" href="javascript:void(0)" onclick="editQsnReplyDiv('boxqsnSubChild{{$subchild->id}}' ,'{{route('edit-qsn-sub-child-comment' , $subchild->id)}}','boxqsnSubChild{{$subchild->id}}')">Edit</a>
                                            <a class="ml-3 delete-comment" href="javascript:void(0)" style="color: red" onclick="delete_qsn_comment('{{route('delete-qsn-sub-comment',base64_encode($subchild->id))}}')" >Delete</a>
                                        @endif

                                    </div>
                                </div>
                             </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
     @endforeach
</div>
