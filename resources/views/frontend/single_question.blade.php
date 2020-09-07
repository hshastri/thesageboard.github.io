@extends('frontend.layout.app')

@section('meta_title'){{ $question_details->question_title .'- Sage'}}@stop

@section('meta_description'){!! substr($question_details->description, 0, 150) !!}@stop

@section('meta_keywords'){{'Sage Advice',@$question_details->category->name}},{{@$question_details->subcategory->name}}@stop

@section('org_meta_title'){{ $question_details->question_title }}@stop

@section('org_meta_description'){!! substr($question_details->description, 0, 150) !!}@stop

@section('twitter_meta_title'){{ $question_details->question_title }}@stop

@section('twitter_meta_desctiption'){!! substr($question_details->description, 0, 150) !!}@stop

@section('open_meta_title'){{ $question_details->question_title }}@stop

@section('open_meta_description'){!! substr($question_details->description, 0, 150) !!}@stop

@section('main')
    <section class="container main-content">
        <div class="gap"></div>

        <div class="row">
            <div class="col-md-10 offset-md-1">
                <article class="question single-question question-type-normal">
                    <h1>
                        <a href="">{{ucfirst(@$question_details->question_title)}}</a>
                        @if(Auth::check() && $question_details->user_id==Auth::user()->id && $question_details->isSolved=='no')
                        <a style="float: right" class="question-edit-send shadow-sm" href="{{route('question-edit', base64_encode($question_details->id))}}"><i class="fas fa-edit"></i></a>
                        @endif
                    </h1>
                    <div class="question-inner">
                        <div class="question-desc sage-asked-content mb-4">
                            <p>{!! $question_details->description !!}</p>
                        </div>
                        <div class="question-details-meta-wrapper clearfix">
                            @if($question_details->file!='')
                            <h4>Attachments</h4>
                            <ul class="d-flex mb-3">
                                @foreach (json_decode($question_details->file) as $key => $value)
                                    <li style="float: left">
                                        <a href="{{asset('public/'.$value)}}" download class="btn btn-outline-success">{{ substr(strip_tags(str_replace('uploads/','',$value)),0,5)}}.... <i class="icon-download"></i></a>
                                    </li>
                                @endforeach
                            </ul>
                            @endif

                            <div class="question-meta-item mb-4">
                                <span class="top-separate-border mb-3">&nbsp;</span>
                                <span class="meta-item d-block mb-2"><span>Topic</span> <a href="{{route('show-question',base64_encode(@$question_details->category->id))}}"><i class="{{@$question_details->category->icon}}"></i> {{@$question_details->category->name}}</a></span>
                                <span class="meta-item d-block mb-2"><span>Subtopic</span> <i class="{{@$question_details->subcategory->icon}}"></i> {{@$question_details->subcategory->name}}</span>
                                @if($question_details->tags != null)
                                <span class="meta-item d-block mb-1"><span>Tags</span>@foreach(explode(',', $question_details->tags) as $tag) <span class="tags">{{$tag}}</span> @endforeach</span>
                                @endif
                            </div>
                            <div class="question-meta-item">
                                {{--
                                @if($question_details->isSolved=='yes')
                                    <span class="meta-item question-answered question-answered-done"><i class="far fa-check-circle"></i>Solved</span>
                                @else
                                    <span class="meta-item question-answered" style="color:#ff2700;"><i class="fas fa-ban"></i>Not Solved</span>
                                @endif
                                --}}
                                <span class="meta-item question-date"><i class="fas fa-clock"></i>{{convert_time(@$question_details->created_at)}}</span>
                                <span class="meta-item question-answer"><a href="#"><i class="fas fa-book"></i> {{$question_details->totalanswer}} {{$question_details->totalanswer == 1 ? 'Answer' : 'Answers'}}</a></span>
                                <span class="meta-item question-view"><i class="far fa-eye"></i>{{$question_details->totalview}} views</span>
                                <a href="javascript:void(0)" onclick="showQuestionComment('{{route('load-question-comment',base64_encode($question_details->id))}}')"><span class="meta-item question-comment ml-5"> <i class="far fa-comments"></i> <span id="questionTotalComment"></span> </span> </a>
                                <ul class="d-flex justify-content-end single-question-vote float-right">
                                   {{-- <li>
                                        <a href="javascript:void(0)" onclick="voteing_question('{{route('vote-question', ['id'=>base64_encode($question_details->id) , 'type'=>'down'])}}','down' )" class="single-question-vote-down {{(Auth::check())?$question_details->have_down_vote_question(Auth::user()->id, $question_details->id):''}}" title="Down Vote"><i class="fas fa-thumbs-down"></i></a>
                                    </li>--}}
                                    <li>
                                        <a href="javascript:void(0)" onclick="voteing_question('{{route('vote-question', ['id'=>base64_encode($question_details->id) , 'type'=>'up'])}}','up')" class="single-question-vote-up {{(Auth::check())?$question_details->have_up_vote_question(Auth::user()->id, $question_details->id):''}}" title="Up vote" ><i class="fas fa-thumbs-up"></i></a>
                                    </li>
                                    <li class="single-question-vote-result">{{sign_vote($question_details->total_vote($question_details->id))}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </article>
                @php
                    $get_users = App\UserDetails::where('user_id', $question_details->user_id)->first();
                @endphp

                <div class="about-author clearfix">
                    <div class="author-image">
                        <a href="{{route('profile', $question_details->user->username )}}" original-title="{{$question_details->user->first_name}} {{$question_details->user->last_name}}" class="tooltip-n"><img alt="" src="{{($question_details->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$question_details->user->avatar)}}"></a>
                    </div>
                    <div class="author-bio">
                        <h4><a href="{{route('profile', $question_details->user->username )}}"> {{$question_details->user->first_name}} {{$question_details->user->last_name}}</a></h4>
                        @php
                        $sp = json_decode(@$get_users->speciality);
                        @endphp
                        @if($get_users->speciality!=null)
                        <p>Knowledge Areas :
                            @foreach(json_decode(@$get_users->speciality) as $i=>$speciality)
                            <span>{{$speciality}}</span>@if($i < count($sp) - 1)<span>,</span>@endif
                            @endforeach
                        </p>
                        @endif
                        <p class="mt-2 font-weight-bold">Reputation Score: {{$get_users->general_reputation_score+$get_users->expert_reputation_score}}</p>
                    </div>
                </div><!-- End about-author -->
                <div class="row question-comment">
                    <div class="col-md-11 offset-md-1">
                        <div class="comment-secstion-wrapper">
                            <div class="wrapper loadingwraper" style="display: none">
                                <div class="wrapper-cell">
                                    <div class="image"></div>
                                    <div class="text">
                                        <div class="text-line mt-0"></div>
                                        <div class="text-line"></div>
                                        <div class="text-line"></div>
                                        <div class="text-line"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="commnet-with-input mt-4 showwraper">

                            </div>
                        </div>
                    </div>
                </div>

                @if($question_details->answer->count()>=1)
                <div id="commentlist" class="page-content">
                    <div class="boxedtitle page-title mb-4">
                        <h2>Answers ( <span class="color">{{$question_details->totalanswer}}</span> )</h2>
                        <span class="top-separate-border mb-3">&nbsp;</span>
                    </div>
                    <ol class="commentlist clearfix">
                        @foreach($question_details->answer as $answer)
                            <li class="comment">
                                <div class="comment-body clearfix">
                                    <div class="row">
                                        <div class="col-md-1 pr-0">
                                            <div class="avatar">
                                                <img alt="" src="{{($answer->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$answer->user->avatar)}}">
                                            </div>
                                        </div>
                                        <div class="col-md-11">
                                            <div class="comment-text">
                                                <div class="comment-author mt-2">
                                                    <a href="{{route('profile', $answer->user->username)}}">{{$answer->user->first_name}} {{$answer->user->last_name}}</a>
                                                </div>
                                                {{--<a class="comment-reply" href="javascript:void(0)" onclick="reply('{{route('comment', base64_encode($answer->id))}}', '{{$answer->id}}')"><i class="fa fa-reply"></i>Reply</a>--}}
                                                <div class="mt-2 sage-asked-content" id="answerDiv_{{$answer->id}}">{!! $answer->answer !!}</div>
                                                <div class="question-meta-item mt-4">
                                                    @if(Auth::check() && Auth::user()->id == $question_details->user_id && $question_details->isSolved=='no' && Auth::user()->id!=$answer->user_id)
                                                        <a href="javascript:void(0)" onclick="accept_answer('{{route('accept-answer',base64_encode($answer->id))}}')" class="meta-item question-comment shadow-sm mr-2"><i class="fas fa-check-circle"></i></i>Accept Answer</a>
                                                    @endif
                                                    @if($answer->accepted=="yes")
                                                        <span class="meta-item mr-4 answer-accepted"><i class="fas fa-check-circle"></i></i>Accepted </span>
                                                    @endif
                                                    @if(Auth::check() && $answer->accepted=="no" && $answer->user_id==Auth::user()->id)
                                                        <a class="meta-item mr-4" style="cursor:pointer" onclick="editAnswer('{{$answer->id}}', '{{route('get-answer-edit', base64_encode($answer->id))}}')"><i class="fas fa-edit"></i>edit</a>
                                                    @endif
                                                    <span class="meta-item mr-4"><i class="fas fa-clock"></i>UTC {{date('Y-m-d h:i A', strtotime($answer->created_at))}}</span>
                                                    <a href="javascript:void(0)" onclick="loadAnsComment('{{route('load-ans-comment',base64_encode($answer->id))}}' , '{{$answer->id}}' )"> <span class="meta-item mr-4 question-comment"> <i class="far fa-comments"></i> <span id="totalCommentAns{{$answer->id}}">{{$answer->totalComment($answer->id)}} {{ $answer->totalComment($answer->id) == 1 ? 'Comment' : 'Comments'}}</span></span></a>
                                                    <ul class="d-flex justify-content-end single-question-vote float-right">
                                                        <li>
                                                            <a href="javascript:void(0)" id="icon-thumbs-up_{{$answer->id}}" onclick="voteing_answer('{{route('vote-answer', ['id'=>base64_encode($answer->id) , 'type'=>'up'])}}', '{{$answer->id}}','up')"  class="thumbs-button {{(Auth::check())?$answer->have_up_vote_answer(Auth::user()->id, $answer->id):''}}" title="Up Vote">
                                                            <i class="fas fa-thumbs-up"></i>
                                                            </a>
                                                        </li>
                                                        {{--<li><a href="javascript:void(0)" id="icon-thumbs-down_{{$answer->id}}" onclick="voteing_answer('{{route('vote-answer', ['id'=>base64_encode($answer->id) , 'type'=>'down'])}}', '{{$answer->id}}','down')" class="thumbs-button {{(Auth::check())?$answer->have_down_vote_answer(Auth::user()->id, $answer->id):''}}" title="Down Vote"><i class="fas fa-thumbs-down"></i></a></li>--}}
                                                        <li>
                                                            <span class="question-vote-result" id="answer_vote_{{$answer->id}}">{{sign_vote($answer->total_vote_answer($answer->id))}}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="row question-comment">
                                                <div class="col-md-12">
                                                    <div class="comment-secstion-wrapper">
                                                        <div class="wrapper mt-4">
                                                            <div class="wrapper" id="loadingwraper{{$answer->id}}" style="display: none">
                                                            <div class="wrapper-cell">
                                                                <div class="image"></div>
                                                                <div class="text">
                                                                    <div class="text-line mt-0"></div>
                                                                    <div class="text-line"></div>
                                                                    <div class="text-line"></div>
                                                                    <div class="text-line"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="commnet-with-input mt-4 anscomment" id="showwraper{{$answer->id}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{--<div class="comment-body clearfix commonreplydiv replybox_{{$answer->id}}"></div>--}}
                            </li>
                        @endforeach
                    </ol><!-- End commentlist -->
                </div><!-- End page-content -->
                @endif

                <div class="comment-respond page-content clearfix">
                    @if(!Auth()->check())
                    <div class="p-3 border">
                        <div class="row">
                            <p class="col-md-12 mb-3">To answer this question, you must be logged in.</p>
                            <div class="col-md-5">
                                <a class="social-login facebook m-0" href="{{ route('social.login', ['provider' => 'facebook' , 'point' => base64_encode($question_details->id)]) }}" class="login100-form-btn-facebook"><i class="font-facebook-1"></i>Continue with Facebook</a>
                                <a class="social-login google" href="{{ route('social.login', ['provider' => 'google' , 'point' => base64_encode($question_details->id)]) }}" class="login100-form-btn-google"><i class="font-google"></i>Continue with Google</a>
                                <p class="mt-3">By Signing up, you indicate that you have read and agree to Sage's <a target="_blank" href="{{route('terms-and-conditions')}}" style="color: #00df73">Terms and Conditions</a> and <a target="_blank" href="{{route('policy')}}" style="color: #00df73">Privacy Policy</a></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-3"><a href="{{route('expert-register')}}" class="submit-button d-block w-100">Create an account</a></p>
                                <p>Already have an account? <a href="{{route('login')}}" style="color: blue">Login</a>.</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="boxedtitle page-title"><h2>Submit An Answer</h2></div>
                    <form action="{{route('answer', base64_encode($question_details->id))}}" method="post" class="comment-form">
                        @csrf
                        <div id="respond-textarea">
                            <p>
                                <textarea class="comment-area" name="answer" aria-required="true" cols="58" rows="8"></textarea>
                            </p>
                            @if($errors->has('answer'))
                                <span class="form-text text-danger"> {{$errors->first('answer')}}</span>
                            @endif
                        </div>
                        <p class="form-submit">
                            @if(Auth::check() && Auth::user()->id)
                                <input name="submit" type="submit" id="submit" value="Submit" class="button small color" >
                            @else
                                <input name="button" type="button" id="submit" value="Submit" class="button small color" onclick=" popupConfirm()">
                            @endif

                        </p>
                    </form>
                    @endif
                </div>
               <!-- End post-next-prev -->
            </div><!-- End main -->
           <!-- End sidebar -->
        </div><!-- End row -->
    </section><!-- End container -->
@endsection
@push('js')

    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script type="text/javascript">
        let currentQsnValue='{{$question_details->totalComment($question_details->id)}}';
        $(function() {
            qsnTotalcmnt(0);
            applyMice();

            $(".comment-form").validate
            ({
                rules: {
                    answer: { required: true },
                    first_name: {required:true},
                    last_name: {required:true},
                },
            });
        })


        function qsnTotalcmnt(type){
            if(type==1){
                currentQsnValue++;
            }
            $('#questionTotalComment').text( currentQsnValue == 1 ? currentQsnValue + ' Comment' : currentQsnValue + ' Comments');
        }
        function decreaseCount(type){
            currentQsnValue = currentQsnValue - parseInt(type) ;
            $('#questionTotalComment').text( currentQsnValue == 1 ? currentQsnValue + ' Comment' : currentQsnValue + ' Comments');
        }


        $(document).on("keypress", ".inputformPrevent", function(e){
            if(e.which == 13){
                e.preventDefault();
            }
        });

        function applyMice(){
            var tiny = tinymce.init({
                selector: '.comment-area',
                placeholder: 'Type here...',
                menubar:false,
                min_height: 250,
                branding: false,
                plugins: 'image paste autolink link imagetools textpattern preview code lists',
                browser_spellcheck: true,
                contextmenu: false,
                body_class: 'sage-asked-content',
                content_css: '{{asset("assets/front/css/asked-content.css")}}',
                toolbar: 'undo redo | formatselect | bold italic strikethrough blockquote | numlist bullist | alignleft aligncenter alignright alignjustify | bold italic | link image | textpattern code preview',
                textpattern_patterns: [
                    {start: '*', end: '*', format: 'italic'},
                    {start: '**', end: '**', format: 'bold'},
                    {start: '#', end: '#', format: 'h1'},
                    {start: '##', format: 'h2'},
                    {start: '~', end: '~', cmd: 'createLink', value: 'https://tiny.cloud'}
                ],
                block_formats: 'Heading 1=h1; Heading 2=h2; Normal=p; Code Block=pre',
                paste_as_text: true,
                paste_data_images: true,
                a11y_advanced_options: true,
                image_advtab: true,
                image_uploadtab: true,
                imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
                automatic_uploads: true,
                images_upload_url: "{{route('upload')}}",
                relative_urls: false,
                images_upload_handler: function (blobInfo, success, failure) {

                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{route('upload')}}');
                    xhr.setRequestHeader('x-csrf-token', '{{ @csrf_token() }}');
                    xhr.onload = function() {
                        var json;
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        if(xhr.responseText) {
                            json = JSON.parse(xhr.responseText);
                            if (!json || typeof json.location != 'string') {
                                failure('Invalid JSON: ' + xhr.responseText);
                                return;
                            }
                        } else {
                            failure('You are not allowed to upload more than 2MB file size');
                            return;
                        }
                        success(json.location);
                    };
                    formData = new FormData();
                    if( typeof(blobInfo.blob().name) !== undefined ) {
                        fileName = blobInfo.blob().name;
                    } else {
                        fileName = blobInfo.filename();
                    }
                    formData.append('file', blobInfo.blob(), fileName);
                    xhr.send(formData);
                },
                force_br_newlines : false,
                force_p_newlines : true,
                forced_root_block : '',
                setup : function(editor) {
                    editor.on('PostProcess', function(ed) {
                        // we are cleaning empty paragraphs
                        ed.content = ed.content.replace(/(<p>&nbsp;<\/p>)/gi,'<br />');
                    });
                },
            });
        }
        function voteing_question(dataUrl,type){
            @if(Auth::check() && Auth::user()->id)
                @if(Auth::user()->id==$question_details->user_id)
                    showFrontendAlert('danger', 'Own vote Not Accepted');
                    return;
                @endif

            $.get(dataUrl, function(data){
                if(data[0]==1){
                    $('.single-question-vote-result').html(data[1]);
                    if(type=='up') {
                        $('.single-question-vote-up').addClass('active');
                        $('.single-question-vote-down').removeClass('active');
                    }else{
                        $('.single-question-vote-down').addClass('active');
                        $('.single-question-vote-up').removeClass('active');
                    }
                }
            });
            @else
                popupConfirm();
            @endif
        }

        function disablethis(){
            $("#submit").prop('disabled', true);
        }
        function voteing_answer(dataUrl , ansid , anstype){
            @if(Auth::check() && Auth::user()->id)
            $.get(dataUrl, function(data){
                if(data[0]==1){
                    $('#answer_vote_'+ansid).html(data[1]);
                    if(anstype=='up') {
                        $('#icon-thumbs-up_'+ansid).addClass('active');
                        $('#icon-thumbs-down_'+ansid).removeClass('active');
                    }else{
                        $('#icon-thumbs-down_'+ansid).addClass('active');
                        $('#icon-thumbs-up_'+ansid).removeClass('active');
                    }
                }else if(data==3){
                    showFrontendAlert('danger', 'Own vote Not Accepted');
                    return;
                }
            });
            @else
            popupConfirm();
            @endif
        }
        function voteing_comment(dataUrl , obj){
            @if(Auth::check() && Auth::user()->id)
            $.get(dataUrl, function(data){
                if(data[0]==1){
                }
            });
            @else
            popupConfirm();
            @endif
        }
        function reply(answer, id) {
            @if(Auth::check() && Auth::user()->id)
            $("#respond").remove();
            $('.commonreplydiv').html('');
            let replyDiv=`
            <div id="respond" class="comment-respond page-content clearfix">
                <form action='${answer}' method="post" class="comment-form">
                    @csrf
                    <div id="respond-textarea">
                        <p>
                            <label class="required" for="comment">Comment</label>
                            <textarea class="comment-area" name="comment" aria-required="true" cols="58" rows="8"></textarea>
                        </p>
                    </div>
                    <p class="form-submit">
                        <input name="submit" type="submit" id="submit" value="Post your comment" class="button small color">
                    </p>
                </form>
            </div>`
            $('.replybox_'+id).html(replyDiv);
            applyMice();
            @else
                popupConfirm();
            @endif
        }
        function accept_answer(dataUrl){
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to accept the answer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Accept it!'
            }).then((result) => {
                if (result.value) {
                    $.get(dataUrl, function(data){
                        if(data==1){
                            Swal.fire({
                                title: "Accepted !",
                                text: "Answer Accepted!",
                                type: "success"
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });

                }
            })
        }
        function editAnswer(answerid , dataUrl) {
            let changeDiv = 'answerDiv_'+answerid;
            $.get(dataUrl, function(data){
                $('#'+changeDiv).html(data);
                applyMice();
            });
        }

        function toggleButton(ref,bttnID){
            document.getElementById(bttnID).disabled = ((ref.value !== ref.defaultValue) ? false : true);
        }

        let loadAnsCom = false;
        let currentID = 0;
        function loadAnsComment(url , id) {
            if(loadAnsCom == false || currentID !=id){
                 loadAnsCom = true;
                 currentID = id;
                $('.anscomment').html('');
                $('#loadingwraper'+id).css('display', 'block');
                $.get(url, function(data){
                    if(data){
                        $('#loadingwraper'+id).css('display', 'none');
                        $('#showwraper'+id).html(data);
                    }
                });
            }else{
                loadAnsCom = false;
                currentID = 0;
                $('.anscomment').html('');
            }
        }
        function postAnswerComment(url){
            var datastring = $("#ansCmntForm").serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: datastring,
                dataType: "json",
                success: function(data) {
                    if(data['status']==200){
                         childReplyOn = false;
                         childReplyOnID = 0 ;
                         loadAnsCom = false;
                         currentID = 0;
                        loadAnsComment(data['route'], data['ansID']);
                        let current = $('#totalCommentAns'+data['ansID']).text();
                        let increase = 1+ parseInt(current);
                        $('#totalCommentAns'+data['ansID']).text( increase == 1 ? increase + ' Comment' : increase + ' Comments');
                    }
                },
                error: function() {
                    alert('Exception occur');
                }
            });
        }

        let childReplyOn = false;
        let childReplyOnID = 0 ;
        function addAnsChildReply(replyUrl , commentId) {
            if(childReplyOn== false || childReplyOnID!=  commentId){
                 childReplyOn = true;
                 childReplyOnID = commentId ;
                $('.ansreplydiv').html('');
                    @if(Auth::check() && Auth::user()->id)
                let replyDiv=`
            <form id="ansChildForm">
             @csrf
                    <div class="input-group">
                        <input type="text" autocomplete="off" class="form-control cmntradious inputformPrevent" name="ansChildComment" placeholder="Add Reply" onkeyup="toggleButton(this, 'childreply')">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success btn-sm cmntradious" disabled="disabled" id="childreply" onclick="postAnswerCommentReply('${replyUrl}', 'ansChildForm')">Reply</button>
                </div>
            </div>
            </form>`
                $('#'+commentId).html(replyDiv);
                @else
                popupConfirm();
                @endif
            }else{
                childReplyOn = true;
                childReplyOnID = 0 ;
                $('#'+commentId).html('');
            }

        }

        function postAnswerCommentReply(url, formId){
            var datastring = $("#"+formId).serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: datastring,
                dataType: "json",
                success: function(data) {
                    if(data['status']==200){
                        childReplyOn = false;
                        childReplyOnID = 0 ;
                        loadAnsCom = false;
                        currentID = 0;
                        loadAnsComment(data['route'], data['ansID']);
                        let current = $('#totalCommentAns'+data['ansID']).text();
                        let increase = 1+ parseInt(current);
                        $('#totalCommentAns'+data['ansID']).text( increase == 1 ? increase + ' Comment' : increase + ' Comments');
                    }
                },
                error: function() {
                    alert('Exception occur');
                }
            });
        }

        let childSubReplyOn = false;
        let childSubReplyOnID = 0 ;
        function addAnsSubChildReply(replyUrl , commentId) {
            if(childSubReplyOn== false || childSubReplyOnID!=  commentId){
                childSubReplyOn = true;
                childSubReplyOnID = commentId ;
                $('.ansreplydiv').html('');
                    @if(Auth::check() && Auth::user()->id)
                let replyDiv=`
                <form id="ansSubChildForm">
                 @csrf
                    <div class="input-group">
                    <input type="text" autocomplete="off" class="form-control cmntradious inputformPrevent" name="ansChildComment" placeholder="Add Reply" onkeyup="toggleButton(this, 'childreply')">
                    <div class="input-group-append">
                    <button type="button" class="btn btn-success btn-sm cmntradious" disabled="disabled" id="childreply" onclick="postAnswerCommentReply('${replyUrl}', 'ansSubChildForm')">Reply</button>
                    </div>
                     </div>
                </form>`
                $('#'+commentId).html(replyDiv);
                @else
                popupConfirm();
                @endif
            }else{
                childSubReplyOn = true;
                childSubReplyOnID = 0 ;
                $('#'+commentId).html('');
            }

        }

        let showQsnComment= false;
        function showQuestionComment(url) {
            if(showQsnComment== false){
                showQsnComment = true;
                $('.loadingwraper').css('display', 'block');
                $.get(url, function(data){
                    if(data){
                        $('.loadingwraper').css('display', 'none');
                        $('.showwraper').html(data);
                    }
                });
            }else{
                showQsnComment = false;
                $('.showwraper').html("");
            }

        }

        let childQsnReplyOn = false;
        let childQsnReplyOnID = 0 ;
        function addQsnReply(replyUrl , id) {
            if(childQsnReplyOn== false || childQsnReplyOnID!=id){
                childQsnReplyOn = true;
                childQsnReplyOnID = id;
                $('.qsnreplydiv').html('');
                    @if(Auth::check() && Auth::user()->id)
                let replyDiv=`
                <form id="childForm">
                 @csrf
                <div class="input-group">
                    <input type="text" class="form-control cmntradious inputformPrevent" name="questionchildcomment" placeholder="Add Reply" onkeyup="toggleButton(this, 'childreply')">
                <div class="input-group-append">
                 <button type="button" class="btn btn-success btn-sm cmntradious" disabled="disabled" id="childreply" onclick="postFormData('${replyUrl}', 'childForm')">Reply</button>
                </div>
                </div>
                </form>`
                $('#'+id).html(replyDiv);
                @else
                popupConfirm();
                @endif
            }else{
                childQsnReplyOn = false;
                childQsnReplyOnID = 0;
                $('#'+id).html("");
            }
        }

        let childSubQsnReplyOn = false;
        let childSubQsnReplyOnID = 0 ;
        function addSubQsnReply(replyUrl , id) {
            if(childSubQsnReplyOn== false || childSubQsnReplyOnID!=id){
                childSubQsnReplyOn = true;
                childSubQsnReplyOnID = id;
                $('.qsnreplydiv').html('');
                    @if(Auth::check() && Auth::user()->id)
                    let subreplyDiv=`
                    <form id="subChildForm">
                     @csrf
                        <div class="input-group">
                            <input type="text" class="form-control cmntradious inputformPrevent" name="questionSubChildComment" placeholder="Add Reply" onkeyup="toggleButton(this, 'childreply')">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success btn-sm cmntradious" disabled="disabled" id="childreply" onclick="postFormData('${replyUrl}', 'subChildForm')">Reply</button>
                            </div>
                        </div>
                    </form>`;
                $('#'+id).html(subreplyDiv);
                @else
                popupConfirm();
                @endif
            }else{
                childSubQsnReplyOn = false;
                childSubQsnReplyOnID = 0;
                $('#'+id).html("");
            }
        }

        function postFormData(url, formId){
            var datastring = $("#"+formId).serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: datastring,
                dataType: "json",
                success: function(data) {
                    if(data['status']==200){
                        showQsnComment = false;
                        childQsnReplyOn = false;
                        childQsnReplyOnID = 0;
                        childSubQsnReplyOn = false;
                        childSubQsnReplyOnID = 0;
                        showQuestionComment('{{route('load-question-comment',base64_encode($question_details->id))}}')
                        qsnTotalcmnt(1);
                    }
                },
                error: function() {
                    alert('Exception occur');
                }
            });
        }

        let qsneditbleFalseInput = false;
        let qsneditcontent;
        let qsneditableID =0;
        function editQsnReplyDiv(tagdata , editUrl , id) {
            if(qsneditbleFalseInput==false || qsneditableID != id){
                if(qsneditableID != 0 && qsneditableID != id){
                    let prepairDiv =`<p id=${qsneditableID}>${qsneditcontent}</p>`;
                    $('#'+qsneditableID).html(prepairDiv);
                }
                qsneditcontent = $('#'+id).text();
                qsneditbleFalseInput = true;
                qsneditableID = id;
                let editDiv=`
                    <form class="post-comment" id="editForm">
                     @csrf
                    <div class="input-group">
                    <input type="text" class="form-control cmntradious inputformPrevent" name="commentEdit" value="${qsneditcontent}" onkeyup="toggleButton(this, 'childreply')">
                        <div class="input-group-append">
                         <button type="button" class="btn btn-success btn-sm cmntradious" disabled="disabled" id="childreply" onclick="editQsnCommentData('${editUrl}', 'editForm')">Update</button>
                        </div>
                    </div>
                    </form>`
                $('#'+id).html(editDiv);
            }else{

                let prepairDiv =`<p id=${id}>${qsneditcontent}</p>`;
                $('#'+id).html(prepairDiv);
                qsneditableID = 0;
                qsneditbleFalseInput = false;
            }
        }

        function editQsnCommentData(url, formId){
            var datastring = $("#"+formId).serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: datastring,
                dataType: "json",
                success: function(data) {
                    if(data['status']==200){
                        showQsnComment = false;
                        childQsnReplyOn = false;
                        childQsnReplyOnID = 0;
                        childSubQsnReplyOn = false;
                        childSubQsnReplyOnID = 0;
                        qsneditableID = 0;
                        qsneditbleFalseInput = false;
                        showQuestionComment('{{route('load-question-comment',base64_encode($question_details->id))}}')
                    }
                },
                error: function() {
                    alert('Exception occur');
                }
            });
        }

        function delete_qsn_comment(dataUrl){
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to delete the comment!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.value) {
                    $.get(dataUrl, function(data){
                        if(data['status']==200){
                            Swal.fire({
                                title: "Deleted !",
                                text: "Comment Deleted!",
                                type: "success"
                            }).then((result) => {
                                showQsnComment = false;
                                childQsnReplyOn = false;
                                childQsnReplyOnID = 0;
                                childSubQsnReplyOn = false;
                                childSubQsnReplyOnID = 0;
                                showQuestionComment('{{route('load-question-comment',base64_encode($question_details->id))}}');
                                decreaseCount(data['count'])

                            });
                        }
                    });

                }
            })
        }

        let editbleFalseInput = false;
        let editcontent;
        let editableID =0;
        function editReplyDiv(tagdata , editUrl , id) {
            if(editbleFalseInput==false || editableID != id){
                if(editableID != 0 && editableID != id){
                    let prepairDiv =`<p id=${editableID}>${editcontent}</p>`;
                    $('#'+editableID).html(prepairDiv);
                }
                editcontent = $('#'+id).text();
                editbleFalseInput = true;
                editableID = id;
                let editDiv=`
                    <form class="post-comment" id="editForm">
                     @csrf
                            <div class="input-group">
                                <input type="text" class="form-control cmntradious inputformPrevent" name="commentEdit" value="${editcontent}" onkeyup="toggleButton(this, 'childreply')">
                                <div class="input-group-append">
                                 <button type="button" class="btn btn-success btn-sm cmntradious" disabled="disabled" id="childreply" onclick="editCommentData('${editUrl}', 'editForm')">Update</button>
                        </div>
                    </div>
                    </form>`
                $('#'+id).html(editDiv);
            }else{

                let prepairDiv =`<p id=${id}>${editcontent}</p>`;
                $('#'+id).html(prepairDiv);
                editableID = 0;
                editbleFalseInput = false;
            }
        }

        function editCommentData(url, formId){
            var datastring = $("#"+formId).serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: datastring,
                dataType: "json",
                success: function(data) {
                    if(data['status']==200){
                        childReplyOn = false;
                        childReplyOnID = 0 ;
                        loadAnsCom = false;
                        currentID = 0;
                        editableID = 0;
                        editbleFalseInput = false;
                        loadAnsComment(data['route'], data['ansID']);
                    }
                },
                error: function() {
                    alert('Exception occur');
                }
            });
        }

        function delete_comment(dataUrl){
            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to delete the comment!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.value) {
                    $.get(dataUrl, function(data){
                        if(data['status']==200){
                            Swal.fire({
                                title: "Deleted !",
                                text: "Comment Deleted!",
                                type: "success"
                            }).then((result) => {
                                childReplyOn = false;
                                childReplyOnID = 0 ;
                                loadAnsCom = false;
                                currentID = 0;
                                editableID = 0;
                                editbleFalseInput = false;
                                loadAnsComment(data['route'], data['ansID']);
                                let current = $('#totalCommentAns'+data['ansID']).text();
                                let increase = parseInt(current) - parseInt(data['count']);
                                $('#totalCommentAns'+data['ansID']).text( increase == 1 ? increase + ' Comment' : increase + ' Comments');

                            });
                        }
                    });

                }
            })
        }


    </script>
@endpush
