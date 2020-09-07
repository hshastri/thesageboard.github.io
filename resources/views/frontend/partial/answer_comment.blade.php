<div>
    @if(Auth::check() && Auth::user()->id)
        <div class="post-comment mb-3">
            <form id="ansCmntForm">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control cmntradious inputformPrevent" name="anscomment" placeholder="Add Comment" onkeyup="toggleButton(this, 'addAnsComment')" autocomplete="off">

                    <div class="input-group-append">
                        <button type="button" class="btn btn-success btn-sm cmntradious" disabled="disabled" id="addAnsComment" onclick="postAnswerComment('{{route('comment', $id)}}','{{$id}}')">Add Comment</button>
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
                        <span class="author-name ml-2"><a href="{{route('profile', $qsncmt->user->username)}}">{{$qsncmt->user->first_name}} {{$qsncmt->user->last_name}}</a></span>
                        <span class="posting-time ml-2"> UTC {{date('Y-m-d h:i A', strtotime($qsncmt->created_at))}}</span>
                    </div>
                    <div class="comment-box">
                        <p id="editableSubChild{{$qsncmt->id}}">{{$qsncmt->comment}}</p>
                        <p class="mt-2">
                            <a class="reply-button" href="javascript:void(0)" onclick="addAnsChildReply('{{route('ans-child-comment', ['id'=> base64_encode($qsncmt->id) , 'ansId'=> $qsncmt->answer_id ] )}}','anschild{{$qsncmt->id}}')"><i class="icon-reply-outline"></i> Reply </a>
                            @if(Auth::check() &&  Auth::user()->id == $qsncmt->user_id)
                            <a class="edit-comment ml-3" href="javascript:void(0)" onclick="editReplyDiv('anschild{{$qsncmt->id}}' ,'{{route('edit-answer-child-comment' , $qsncmt->id)}}','editableSubChild{{$qsncmt->id}}')">Edit</a>
                            <a class="ml-3 delete-comment" href="javascript:void(0)" style="color: red" onclick="delete_comment('{{route('delete-answer-child-comment',base64_encode($qsncmt->id))}}')" >Delete</a>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="post-comment my-3 px-3 ansreplydiv" id="anschild{{$qsncmt->id}}">

                </div>

                <ul class="ml-4 mt-3">
                    @foreach($qsncmt->replies as $child)
                        <li>
                            <div class="single-comment px-3 mb-4">
                                <div class="author-box d-flex align-items-center">
                                    <span class="author-avatar"><img src="{{($child->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$child->user->avatar)}}" alt=""></span>
                                    <span class="author-name ml-2"><a href="{{route('profile', $child->user->username)}}">{{$child->user->first_name}} {{$child->user->last_name}}</a></span>
                                    <span class="posting-time ml-2"> UTC {{date('Y-m-d h:i A', strtotime($child->created_at))}}</span>
                                </div>
                                <div class="comment-box">
                                    <p id="editableChild{{$child->id}}">{{$child->comment}}</p>

                                    <p class="mt-2">
                                        <a class="reply-button" href="javascript:void(0)" onclick="addAnsSubChildReply('{{route('ans-child-comment', ['id'=> base64_encode($child->id) , 'ansId'=> base64_decode($id) ] )}}','ansSubchild{{$child->id}}')">
                                            <i class="icon-reply-outline"></i>
                                            Reply
                                        </a>
                                        @if(Auth::check() &&  Auth::user()->id == $child->user_id)
                                        <a class="edit-comment ml-3" href="javascript:void(0)" onclick="editReplyDiv('ansSubchild{{$child->id}}' ,'{{route('edit-answer-sub-child-comment' , $child->id)}}','editableChild{{$child->id}}')">Edit</a>
                                        <a class="ml-3 delete-comment" href="javascript:void(0)" style="color: red" onclick="delete_comment('{{route('delete-answer-sub-child-comment',base64_encode($child->id))}}')" >Delete</a>
                                        @endif
                                    </p>

                                </div>
                            </div>

                            <div class="post-comment my-3 px-3 qsnreplydiv" id="ansSubchild{{$child->id}}">

                            </div>
                            <ul class="ml-4">
                                @foreach($child->replies as $subchild)
                                    <li>
                                        <div class="single-comment px-3 mb-4">
                                            <div class="author-box d-flex align-items-center">
                                                <span class="author-avatar"><img src="{{($subchild->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$subchild->user->avatar)}}" alt=""></span>
                                                <span class="author-name ml-2"><a href="{{route('profile', $subchild->user->username)}}">{{$subchild->user->first_name}} {{$subchild->user->last_name}}</a></span>
                                                <span class="posting-time ml-2"> UTC {{date('Y-m-d h:i A', strtotime($subchild->created_at))}}</span>
                                            </div>
                                            <div class="comment-box">
                                                <p id="editableSubSub{{$subchild->id}}">{{$subchild->comment}}</p>
                                                <p>
                                                    @if(Auth::check() && Auth::user()->id == $subchild->user_id)
                                                    <a class="edit-comment ml-3" href="javascript:void(0)" onclick="editReplyDiv('subsub{{$subchild->id}}' ,'{{route('edit-sub-sub-child-comment' , $subchild->id)}}','editableSubSub{{$subchild->id}}')">Edit</a>
                                                    <a class="ml-3 delete-comment" href="javascript:void(0)" style="color: red" onclick="delete_comment('{{route('delete-sub-sub-child-comment',base64_encode($subchild->id))}}')" >Delete</a>
                                                    @endif
                                                </p>

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
