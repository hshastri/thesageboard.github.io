@extends('frontend.layout.app')
@section('main')
    <section class="container main-content topicSection">
        <div class="row">
            <div class="col-md-8 offset-md-2 mt-3">
                <div class="page-content page-shortcode">
                    <div class="box_icon">
                        <h2>Please choose a topic for your question:</h2>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            If topics are missing that you’d like included in our database, please submit them <strong><a href="https://bit.ly/2CF5xZV" target="_blank" rel="noopener noreferrer">here</a>.</strong>
                        </div>
                        <input type="text" class="topic-search" placeholder="Filter Topic List">
                        <div class="poll_2">
                            <form class="form-style form-style-3 step-one">
                                <div class="form-inputs clearfix">
                                    @foreach($category as $category)
                                        <div class="topic-item mb-4 px-2">
                                            <input id="{{$category->id}}" name="category_id" type="radio" value="{{$category->id}}" style="border-color: #18b694" required onclick="setCat(this)">
                                            <label for="{{$category->id}}">{{$category->name}}</label>
                                            <p style="margin-left: 2em; margin-top: -1em; color:black">{{$category->description}}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="gap"></div>
                                <div class="pagination-area shadow-lg">
                                    <div class="container">
                                        <a class="button medium lime-green-button float-right nextbtn" style="pointer-events: none;cursor: default;" onclick="setSub()">Next</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- End main -->
        </div>
        <!-- End row -->
    </section>
    <section class="container main-content subTopicSection mt-5" style="display: none; min-height: 450px">
        <div class="row">
            <div class="col-md-8 offset-md-2 pb-3">
                <div class="page-content page-shortcode mt-4">
                    <div class="box_icon">
                        <h2>What sub-topic does your question relate to?</h2>
                        <div class="poll_2">
                            <form class="form-style form-style-3">
                                <div class="col-md-12 mb-4 p-4">
                                    <div class="subtopic-selection">
                                        <div class="loader-sub"></div>
                                    </div>
                                    <div class="form-inputs clearfix singleSubcategory"></div>
                                </div>
                                <div>
                                    <a type="button" href="javascript:void(0)" onclick="backTopic()" class="button medium gray-button custom-button" style="float: left">Back</a>
                                    <a type="button" href="javascript:void(0)" class="button medium lime-green-button custom-button" style="float: right" onclick="goToAsk()">Next</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- End main -->
        </div>
        <!-- End row -->
    </section>
    <section class="container main-content questionSection" style="display: none">
            <div class="gap"></div>
            <div class="alert-message warning">
                <i class="fas fa-edit"></i>
                <p><span>Note:</span><br>
                Please note that both public and private questions start here. Create your question, apply formatting options to enhance readability, attach files or embed images, tag your post, and choose whether to publish to public forums or send to a Sage for 1 on 1 advice.</p>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="page-content ask-question">
                        <div class="boxedtitle page-title"><h2>Ask Question</h2></div>
                        <div class="form-style form-style-3">
                            <form action="{{route('ask-question')}}" method="POST" id="questionForm" enctype="multipart/form-data">
                                @csrf
                                <input id="qsn_category" value=""  name="set_category_id" type="hidden" required>
                                <input id="qsn_sub_category" value="" name="set_sub_category_id" type="hidden" required>
                                <div class="form-inputs clearfix">
                                    <p>
                                        <label class="required">Question Title<span>*</span></label>
                                        <input type="text" id="question-title" name="question_title"  value="{{@$ask_question->question_title}}" required>
                                        @if($errors->has('question_title'))
                                            <span class="form-text text-danger"> {{$errors->first('question_title')}}</span>
                                        @endif
                                        <span class="form-description">Please choose an appropriate title for the question to answer it even easier .</span>

                                    </p>
                                    <label>Attachment</label>
                                    <div class="fileinputs">
                                        <input type="file" class="file multi" name="file[]" multiple id="examplefile">
                                        <div class="fakefile">
                                            <button type="button" class="button small margin_0" id="selectfile">Select file</button>
                                            <span><i class="icon-arrow-up"></i>Browse</span>
                                        </div>
                                    </div>
                                    <div class="upload-preview" id="myList"></div>
                                    <div id="form-textarea">
                                        <p>
                                            <label class="required">Details<span>*</span></label>
                                        <div>
                                            <textarea id="question-details" aria-required="true" cols="58" rows="8" name="description" required>{{@$ask_question->description}}</textarea>
                                        </div>
                                            @if($errors->has('description'))
                                                <span class="form-text text-danger"> {{$errors->first('description')}}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <p>
                                        <label>Tags</label>
                                        <input type="text" class="input" name="tags[]"  id="form-tags-4">
                                        @if($errors->has('tags.0'))
                                            <span class="form-text text-danger"> {{$errors->first('tags.0')}}</span>
                                        @endif
                                        <span class="form-description">Please choose  suitable Keywords Ex : <span class="color">question , poll</span> . Maximum 5 tags allowed.</span>
                                        <ul id="tagsList" class="taglists" style="display: none"></ul>
                                    </p>
                                </div>
                                <p class="form-submit">
                                    @if(Auth::check() && Auth::user()->id)
                                    <div class="row">
                                        <div class="col-sm-6 mb-3 mb-sm-0 mb-md-0 mb-lg-0">
                                            <input type="submit" name="publish" value="Post your public question" class="submit-button tooltip-n" original-title="Free public forums for the rest of the Sage community to offer advice.">
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0 mb-md-0 mb-lg-0">
                                            <input type="submit" name="sage" original-title="Paid 1 on 1 advice from a Sage" value="Ask a Private Question" class="submit-button color small submit tooltip-n">
                                        </div>
                                    </div>
                                    @else
                                    <a href="javascript:void(0)" onclick="popupConfirm()" class="button color small submit" style="width: 100%;text-align: center">Publish Your Question</a>
                                    @endif
                                    <a type="button" href="javascript:void(0)" onclick="backSubTopic()" class="button medium gray-button custom-button" style="float: left">Back</a>
                                </p>
                            </form>
                        </div>

                    </div><!-- End page-content -->
                </div>
                <aside class="col-md-4 sidebar">
                    <div class="widget">
                        <h3 class="widget_title">Related Questions</h3>
                        <ul class="related-posts">
                            @foreach($recent as $recent)
                            <li class="related-item">
                                <h3><a href="{{route('question-details', base64_encode($recent->id))}}">{{$recent->question_title}}</a></h3>
                                <p>{{ substr(strip_tags($recent->description),0,60)}}...</p>
                                <div class="clear"></div><span>{{date('h:i A Y-m-d ', strtotime($recent->created_at))}}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
    </section><!-- End container -->
@endsection
@push("js")
    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        let category_id;
        let sub_category_id;

        tinymce.init({
            selector: '#question-details',
            placeholder: 'Type here...',
            menubar:false,
            min_height: 250,
            branding: false,
            toolbar_mode: 'sliding',
            toolbar_sticky: true,
            body_class: 'sage-asked-content',
            content_css: '{{asset("assets/front/css/asked-content.css")}}',
            plugins: 'paste image link imagetools textpattern lists preview code',
            toolbar: 'undo redo | formatselect | numlist bullist | forecolor | alignleft aligncenter alignright alignjustify | bold italic | link image | textpattern code preview',
            textpattern_patterns: [
                {start: '*', end: '*', format: 'italic'},
                {start: '**', end: '**', format: 'bold'},
                {start: '#', end: '#', format: 'h1'},
                {start: '##', format: 'h2'},
                {start: '~', end: '~', cmd: 'createLink', value: 'https://tiny.cloud'}
            ],
            images_reuse_filename: false,
            paste_as_text: true,
            block_formats: 'Heading 1=h1; Heading 2=h2; Normal=p; Code Block=pre',
            a11y_advanced_options: true,
            image_advtab: true,
            image_uploadtab: true,
            imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
            automatic_uploads: true,
            images_upload_url: "{{route('upload')}}",
            relative_urls: false,
            images_upload_handler: function (blobInfo, succesReponse, failure) {
                // if( blobInfo.blob().size >= 2000000) {
                //     failure('You are not s allowed to upload more than 2MB file size');
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
                    }
                    // else {
                    //     failure('You are not s allowed to upload more than 2MB file size');
                    //     return;
                    // }
                    succesReponse(json.location);
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
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
				    $("#" + editor.id).valid();
                });
            }
        });

        // var validator = $("#questionForm").submit(function() {
		// 	// update underlying textarea before submit validation
		// 	tinyMCE.triggerSave();
		// }).validate({
		// 	ignore: "",
		// 	rules: {
		// 		question_title: "required",
		// 		description: "required",
        //         'file[]': "required"
		// 	},
		// 	errorPlacement: function(label, element) {
		// 		// position error label after generated textarea
		// 		if (element.is("textarea")) {
		// 			label.insertAfter(element.next());
		// 		} else {
		// 			label.insertAfter(element);
		// 		}
		// 	}
		// });

        // Dismissal alet
        $('.alert').alert();

       $('#form-tags-4').tagsInput({
            limit:5,
            hide:true,
            placeholder: 'Add a tag',
            minChars: 2,
        });

        $('#examplefile').MultiFile({
            list: '#myList',
            max: 3,
            accept:'gif|jpg|png|jpeg|docx|pdf',
            error: function (s) {
                if(typeof console != 'undefined') console.log(s);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: s
                })
            }
        });
        $('#questionForm').validate({
            rules:{
                question_title:{
                    required: true
                },
                description:{
                    required: true
                },
            },
        });
        function setCat(el){
           category_id = el.value;
           $('.nextbtn').removeAttr('style');
        }
        function setSubCat(el){
            sub_category_id = el.value;
        }
        function backTopic() {
            $('.topicSection').show();
            $('.subTopicSection').hide();
        }
        function backSubTopic() {
            $('.topicSection').hide();
            $('.subTopicSection').show();
            $('.questionSection').hide();
        }
        function setSub(){
            if(category_id!= undefined){
                $('.topicSection').hide();
                $('.subtopic-selection').show();
                $('.subTopicSection').show();
                $.post('{{ route('get-single-sub') }}', {_token:'{{ csrf_token() }}', id:category_id}, function(data){
                    $('.singleSubcategory').html(data);
                    $('.subtopic-selection').hide();
                });
            }
        }
        function goToAsk() {
            $('.questionSection').show();
            $('.topicSection').hide();
            $('.subTopicSection').hide();
            $('#qsn_category').val(category_id);
            $('#qsn_sub_category').val(sub_category_id);
        }
        $('.topic-search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            $('.topic-item label').filter(function() {
                $(this).parents('.topic-item').toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
            if( $('.form-inputs').outerHeight( true ) <= 300 ) {
                $('.pagination-area').addClass('show-on-footer');
            } else {
                $('.pagination-area').removeClass('show-on-footer');
            }
        });

        $(window).scroll(function(e) {
            if(isScrolledIntoView('#footer')) {
                $('.pagination-area').addClass('show-on-footer');
            } else {
                $('.pagination-area').removeClass('show-on-footer');
            }
        });
        function isScrolledIntoView(elem){
            var docViewTop = $(window).scrollTop();
            var docViewBottom = docViewTop + $(window).height();

            var elemTop = $(elem).offset().top;
            var elemBottom = elemTop + $(elem).height();

            return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
        }
    </script>
@endpush
