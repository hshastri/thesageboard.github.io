@extends('frontend.layout.app')
@section('main')
    <section class="container main-content">
        <div class="gap"></div>
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="breadcrumbs px-3">
                    <a href="{{route('expert-zone')}}" class="text-success">Expert Zone</a> / single question
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <article class="question single-question question-type-normal">
                    <h1>
                        <a href="">{{ucfirst(@$question_details->question_title)}}</a>
                        @if(Auth::check() && $question_details->user_id==Auth::user()->id && $question_details->isSolved=='no')
                            <a style="float: right" class="question-edit-send shadow-sm" href="{{route('question-edit', base64_encode($question_details->id))}}"><i class="fas fa-edit"></i></a>
                        @endif
                    </h1>
                    <div class="question-inner">
                        <div class="question-desc sage-asked-content">
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

                            <div class="questions-meta-items float-left">
                                <span class="meta-item question-date"><i class="fas fa-clock"></i>{{convert_time(@$question_details->created_at)}}</span>
                                <span class="meta-item question-answer"><a href="#"><i class="fas fa-book"></i> {{$question_details->totalanswer}} {{$question_details->totalanswer == 1 ? 'Answer' : 'Answers'}}</a></span>
                                <span class="meta-item question-view"><i class="far fa-eye"></i>{{$question_details->totalview}} views</span>
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

                        <p>Reputation Score: {{$get_users->general_reputation_score+$get_users->expert_reputation_score}}</p>
                    </div>
                </div><!-- End about-author -->

                @if($answer->count()>=1)
                    <div id="commentlist" class="page-content mt-5">
                        <div class="boxedtitle page-title mb-4">
                            <h2>Answers ( <span class="color">{{$question_details->totalanswer}}</span> )</h2>
                            <span class="top-separate-border mb-3">&nbsp;</span>
                        </div>
                        <ol class="commentlist clearfix">
                            @foreach($answer as $answer)
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
                                                    <div class="mt-2 sage-asked-content" id="answerDiv_{{$answer->id}}">{!! $answer->answer !!}</div>
                                                    <div class="question-meta-item mt-4">

                                                        @if(Auth::check() && $answer->accepted=="no" && $answer->user_id==Auth::user()->id)
                                                            <a class="meta-item mr-4" style="cursor:pointer" onclick="editAnswer('{{$answer->id}}', '{{route('get-answer-edit', base64_encode($answer->id))}}')"><i class="fas fa-edit"></i>edit</a>
                                                        @endif
                                                        <span class="meta-item mr-4"><i class="fas fa-clock"></i>UTC {{date('Y-m-d h:i A', strtotime($answer->created_at))}}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                <div id="respond" class="comment-respond page-content clearfix">
                    <div class="boxedtitle page-title"><h2>Type Your Response Below</h2></div>
                    <form action="{{route('private-answer', base64_encode($question_details->id))}}" method="post" class="comment-form">
                        @csrf
                        <input type="hidden" name="user_one" value="{{base64_encode($question_details->user_id)}}">
                        <input type="hidden" name="user_two" value="{{$uid}}">
                        <div id="respond-textarea">
                            <p>
                                <textarea id="comment" class="comment-area" name="answer" aria-required="true" cols="58" rows="8"></textarea>
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
                </div>
                <!-- End post-next-prev -->
            </div><!-- End main -->
            @include('frontend.partial.single_question_sidebar')
            <!-- End sidebar -->
        </div><!-- End row -->
    </section><!-- End container -->


    <div id="refund_modal" class="modal fade m-5" data-keyboard="false" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog mt-5">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>


@endsection
@push('js')
    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script type="text/javascript">

        $(function() {
            applyMice();
        })


        function applyMice() {
            tinymce.init({
                selector: '.comment-area',
                placeholder: 'Type here...',
                menubar:false,
                min_height: 250,
                branding: false,
                autosave_restore_when_empty: true,
                body_class: 'sage-asked-content',
                content_css: '{{asset("assets/front/css/asked-content.css")}}',
                toolbar: 'undo redo | formatselect | forecolor | alignleft aligncenter alignright alignjustify | bold italic | link image | textpattern code preview',
                textpattern_patterns: [
                    {start: '*', end: '*', format: 'italic'},
                    {start: '**', end: '**', format: 'bold'},
                    {start: '#', end: '#', format: 'h1'},
                    {start: '##', format: 'h2'},
                    {start: '~', end: '~', cmd: 'createLink', value: 'https://tiny.cloud'}
                ],
                block_formats: 'Heading 1=h1; Heading 2=h2; Normal=p; Code Block=pre',
                paste_as_text: true,
                block_formats: 'Heading 1=h1; Heading 2=h2; Normal=p; Code Block=pre',
                a11y_advanced_options: true,
                image_advtab: true,
                image_uploadtab: true,
                imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
                automatic_uploads: true,
                images_upload_url: "{{route('upload')}}",
                relative_urls: false,
                images_upload_handler: function (blobInfo, success, failure) {
                    // if( blobInfo.blob().size >= 2000000) {
                    //     failure('You are not allowed to upload more than 2MB file size');
                    //     return;
                    // }
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

        function voteing_question(dataUrl){
            @if(Auth::check() && Auth::user()->id)
            @if(Auth::user()->id==$question_details->user_id)
            showFrontendAlert('danger', 'Own vote Not Accepted');
            return;
            @endif

            $.get(dataUrl, function(data){
                if(data[0]==1){
                    $('.single-question-vote-result').html(data[1]);
                    if(data[1]=="+1") {
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

        function voteing_answer(dataUrl , ansid){

            @if(Auth::check() && Auth::user()->id)

            $.get(dataUrl, function(data){
                if(data[0]==1){
                    $('#answer_vote_'+ansid).html(data[1]);
                    if(data[1]=="+1"){
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



        function accept_private_answer(dataUrl){
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
                            })
                        }
                    });
                }
            })
        }

        function get_refund_modal(dataurl){
            $.get(dataurl, function(data){
                $('#modal-content').html(data);
                $('#refund_modal').modal('show', {backdrop: 'static'});
            });
        }


        function editAnswer(answerid , dataUrl) {
            let changeDiv = 'answerDiv_'+answerid;
            $.get(dataUrl, function(data){
                $('#'+changeDiv).html(data);
                applyMice();
            });
        }

    </script>
@endpush
