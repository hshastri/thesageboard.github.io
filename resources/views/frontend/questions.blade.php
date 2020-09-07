@extends('frontend.layout.app')
@section('main')
    <div class="breadcrumbs section-warp ask-me" style="padding: 0 !important;border-radius: 0 0 0 0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2" id="searchData">
                    <p style="margin: 0 !important;">
                        <input type="text" name="question_title" placeholder="Search Questions, Topics, Users" value="{{@$setquestion_title}}" class="search-sage-items" autocomplete="off">
                    </p>
                    <div class="sage-search-result-wrapper" id="searResult"></div>
                </div>
            </div>
        </div><!-- End container -->
    </div>
    <section class="fluid-container main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mobile-filter mt-2 mb-4">
                    <span class="mb-2 d-inline-block">Sort By : </span>
                    <form action="{{route('questions')}}" class="question-filter" method="GET" id="questionFrom">
                        @csrf
                        <input type="hidden" name="cat_key" value="{{$cat_key}}">
                        <input type="hidden" name="subcat_key" value="{{$subcat_key}}">
                        <input type="hidden" name="keyID" value="{{$keyID}}">
                        <div class="row">
                            <div class="col-6 col-lg-3">
                                <div class="answer_status single-filter answer-activity">
                                    <select name="activity" onchange="this.form.submit()">
                                        <option></option>
                                        <option value="0" @if($setactivity){{(0 == $setactivity)?'selected':''}}@endif>Most Recent (Default)</option>
                                        <option value="1" @if($setactivity){{(1 == $setactivity)?'selected':''}}@endif>Most Answered</option>
                                        <option value="4" @if($setactivity){{(4 == $setactivity)?'selected':''}}@endif>Unanswered</option>
                                        <option value="2" @if($setactivity){{(2 == $setactivity)?'selected':''}}@endif>Most Voted</option>
                                        <option value="3" @if($setactivity){{(3 == $setactivity)?'selected':''}}@endif>Most Viewed</option>
                                        <option value="5" @if($setactivity){{(5 == $setactivity)?'selected':''}}@endif>Recently Answered</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3">
                                <div class="time_status single-filter answer-activity">
                                    <select name="time" onchange="this.form.submit()">>
                                        <option></option>
                                        <option value="0" {{($settime==0)?'selected':''}}>Any Time (Default)</option>
                                        <option value="1" {{($settime==1)?'selected':''}}>Past hour</option>
                                        <option value="2" {{($settime==2)?'selected':''}}>Past 4 hours</option>
                                        <option value="3" {{($settime==3)?'selected':''}}>Past 24 hours</option>
                                        <option value="4" {{($settime==4)?'selected':''}}>Past 7 days </option>
                                        <option value="5" {{($settime==5)?'selected':''}}>Past 30 days</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-3 mt-md-3 mt-lg-0">
                                <div class="row">
                                    <div class="col-md-8 col-sm-6 col-lg-5">
                                       <!-- <span class="tag-filter-trigger d-block">Search By Tags</span>-->
                                        <input type="text" class="input" name="tag"  id="form-tags-4" value="{{$settag}}">
                                    </div>
                                    <div class="col-md-4 col-sm-6 pl-md-0 search-tag text-md-right text-lg-left">
                                        <a href="{{route('questions')}}"><i class="fas fa-sync"></i> Reset Filter</a>
                                        <input type="button" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8 col-lg-8">
                    <div class="row">
                        @foreach($questions_all as $question)
                            @if($question!=null)
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
                                            <p>{!! substr(strip_tags($question->description),0,300) !!}...</p>
                                            <div class="cats">
                                                <span class="cat">{{$question->tags}}</span>
                                            </div>
                                            <div class="author-box">
                                                <span class="time">asked: UTC {{date('Y-m-d h:i A ', strtotime($question->created_at))}}</span>
                                                <div class="author-details">
                                                    <img src="{{(@$question->user->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$question->user->avatar)}}" alt="image">
                                                    <span class="author">
                                                            <a href="{{route('profile', $question->user->username)}}" class="author-name">{{$question->user->username}}</a>
                                                            <span class="score"> {{App\UserDetails::where('user_id', $question->user_id)->value('general_reputation_score')+App\UserDetails::where('user_id', $question->user_id)->value('expert_reputation_score')}}</span>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="pagination">
                        {{ $questions_all->appends(request()->input())->links() }}
                    </div>
                </div>
                <aside class="col-md-4 sidebar">
                    <div class="widget widget_stats">
                        <h3 class="widget_title">Sage - Metrics</h3>
                        <div class="ul_list ul_list-icon-ok">
                            <ul>
                                <li><i class="icon-question-sign"></i>Questions ( <span>{{App\AskQuestion::count()}}</span> )</li>
                                <li><i class="icon-comment"></i>Answers ( <span>{{App\Answer::where('type',1)->count()}}</span> )</li>
                                <li><i class="icon-user"></i>Registered Users  ( <span>{{App\User::where('type','user')->count()}}</span> )</li>
                            </ul>
                        </div>
                    </div>

                    <div class="widget_tab mt-sm-3 mt-md-4">
                        <h3 class="widget_title">Trending</h3>
                        <div class="tabs-warp">
                            <ul class="tabs">
                                <li class="tab"><a href="#" class="current">Top Questions</a></li>
                                <li class="tab"><a href="#" class="">Experts</a></li>
                            </ul>
                            <div class="tab-inner-warp" style="display: none;">
                                <div class="tab-inner" id="widget_question"></div>
                            </div>
                            <div class="tab-inner-warp" style="display: none;">
                                <div class="tab-inner" id="small_expert_area"></div>
                            </div>
                        </div>
                    </div>

                </aside><!-- End sidebar -->
            </div><!-- End row -->
        </div>
    </section><!-- End container -->
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $.post('{{ route('widget_question_load') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#widget_question').html(data);
            });
            $.post('{{ route('widget_expert_load') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#small_expert_area').html(data);
            });
            $('.answer_status select').select2({
                placeholder: "Answer Status",
            })
            $('.time_status select').select2({
                placeholder: "Time",
            })
            $('#form-tags-4').tagsInput({
                limit:5,
                hide:true,
                placeholder: 'Add a tag',
                minChars: 2,
                onRemoveTag: ()=>{$('#questionFrom').submit()},
                onAddTag: ()=>{$('#questionFrom').submit()},
            });
        });
        $('#sage-tags').on('select2:select', function(e) {
            var select_val = $(e.currentTarget).val();
            $('.question-filter').submit();
        });
        $('input.search-sage-items').on('keyup', function(e) {
            var searchText = $(this).val().toLowerCase();
            if(searchText){
                $('.sage-search-result-wrapper').addClass('show');
                $.post('{{ route('keysearch') }}', {_token:'{{ csrf_token() }}', data: searchText}, function(e){
                    $('#searResult').html(e)
                });
            }else{
                $('.sage-search-result-wrapper').removeClass('show');
                $('.sage-search-result-wrapper').addClass('hide');
            }

        });
    </script>
@endpush
