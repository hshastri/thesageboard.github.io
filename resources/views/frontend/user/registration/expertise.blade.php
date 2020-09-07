@extends('frontend.layout.app')
@section('main')
    <section class="py-4 registration-steps" style="background:#3e3e3e">
        <div class="custom-container mt-3">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <ul class="process-steps">
                        <li class="acttive done">
                            <div class="icon">1</div>
                            <div class="title">Basic Info</div>
                        </li>
                        <li class="acttive done">
                            <div class="icon">2</div>
                            <div class="title">Bio</div>
                        </li>
                        <li>
                            <div class="icon">3</div>
                            <div class="title">Topic</div>
                        </li>
                        <li>
                            <div class="icon">4</div>
                            <div class="title">Fees</div>
                        </li>
                        <li>
                            <div class="icon">5</div>
                            <div class="title">Success</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="registration-wrapper">
        <div class="container">
            <div class="row sage-margin-right">
                <div class="col-md-10 offset-md-1 pl-md-5 pb-md-4">
                    <div class="text-center my-5">
                        <h2 class="mb-2">Let's fill out Topic/Subtopic</h2>
                        <p>Topic/Subtopics are your expertise area</p>
                    </div>
                    <div class="row text-center d-none d-md-flex">
                        <div class="col-md-6 topic-area">
                            <h5>Add Topic(s)</h5>
                        </div>
                        <div class="col-md-6 sub-topic-area">
                            <h5>Add Sub-topic(s)</h5>
                        </div>
                    </div>
                    @php
                        $i= rand(000,999);
                    @endphp
                    <form action="{{route('add-expertise')}}" method="post">
                        @csrf
                        <div class="row expertise-item-wrapper">
                            @if(@$expertise)
                                @foreach ($expertise as $allkey=>$allvalue)

                                   {{-- @foreach ($allvalue[1] as $tagvalue)
                                       {{dd($tagvalue,1)}}
                                    @endforeach--}}

                                    @php
                                       $j= $i++;
                                    @endphp
                                    <div class="col-md-12 pb-3 pb-sm-4 expertise-item" id="expertise-item-{{$j}}">
                                        <div class="row">
                                            <div class="col-md-6 topic-area expertise-single-item">
                                                <div class="form-group">
                                                    <select id="sage-topic-{{$j}}" name="expert_category[{{$j}}]" required class="sage-add-topic select-to-select2">
                                                        <option value="-1" selected='false'>Select Topic</option>
                                                        @php
                                                        $setcat = App\Category::orderBy('name','ASC')->get();
                                                        @endphp
                                                        @foreach($setcat as $setcat)
                                                            <option value="{{$setcat->id}}" {{($allkey==$setcat->id)?'selected':''}}>{{$setcat->name}}</option>
                                                        @endforeach-
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 sub-topic-area expertise-single-item">
                                                <div class="form-group">
                                                    <select id="sage-sub-topics-{{$j}}" name="expert_subcategory[{{$j}}][]" required class="add-subtopic select-to-select2" multiple="multiple">
                                                        @php
                                                            $setSubcat = App\SubCategory::where('category_id',$allkey)->orderBy('name','ASC')->get();
                                                        @endphp

                                                        @foreach ($setSubcat as $allSubcat)
                                                                <option value="{{$allSubcat->id}}">{{$allSubcat->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <script>
                                                    var selectedValuesSubCategory{{$j}} = [];
                                                    @foreach ($allvalue[0] as $subvalue)
                                                    selectedValuesSubCategory{{$j}}.push({{$subvalue}})
                                                    @endforeach
                                                    setTimeout(function () {
                                                        $('#sage-sub-topics-{{$j}}').select2().val(selectedValuesSubCategory{{$j}}).trigger('change');
                                                    },1000)
                                                </script>

                                            </div>
                                        </div>
                                        <a href="javascript:void(0)" onclick="deleteThis({{$j}})"><span class="delete-expertise-item shadow"><i class="fas fa-trash"></i></span></a>
                                    </div>
                                @endforeach
                           @else
                            <div class="col-md-12 pb-3 pb-sm-4 expertise-item" id="expertise-item-{{$i}}">
                                <div class="row">
                                    <div class="col-md-6 topic-area specialty-tag">
                                        <div class="form-group">
                                            <select id="sage-topic-{{$i}}" name="expert_category[{{$i}}]" required class="sage-add-topic select-to-select2">
                                                <option value="-1" selected='false'>Select Topic</option>
                                                @foreach($category as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 sub-topic-area specialty-tag">
                                        <div class="form-group">
                                            <select id="sage-sub-topics-{{$i}}" name="expert_subcategory[{{$i}}][]" required class="add-subtopic select-to-select2" multiple="multiple">

                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <a href="javascript:void(0)" onclick="deleteThis({{$i}})"><span class="delete-expertise-item shadow"><i class="fas fa-trash"></i></span></a>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3 mt-sm-3 multi-add-wrapper">
                                <a class="multi-add" href="javascript:void(0)" onclick="adddiv()">+ Topic</a>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <a href="{{route('expert-bio')}}" class="submit-button text-center float-left"> Back </a>
                                <input type="submit" name="register" class="submit-button float-right" value="Next">
                            </div>
                        </div>
                    </form>
                </div><!-- End col-md-6 -->
            </div><!-- End row -->
        </div><!-- End login -->
    </section>

@endsection
@push('js')
    <script>

        $(document).ready(function() {
            /*$('select option').each(function(){
                $(this).siblings("[value="+this.value+"]").remove();
           })*/
            setSelect();

        });

        function adddiv(){
            var selectedTopic = [];
            $('.sage-add-topic').each(function(index, ele){
                selectedTopic.push($(ele).val());
            });
            $.get('{{ route('fetch-topic') }}',{ _token:'{{ @csrf_token() }}',data:JSON.stringify(selectedTopic)}, function(data){
                $('.expertise-item-wrapper').append(data);
                setSelect()
            });
        }

        function initializeSelect2(selectElementObj) {
            selectElementObj.select2({
            });

            $('.add-specialty').select2({
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route('get-tags') }}',
                    type:'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            search: params.term,
                            _token:'{{ @csrf_token() }}'
                        }
                        return query;
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        }
                    },
                    cache:false
                }
            });
        }

        function setSelect() {
            $(".select-to-select2").each(function() {
                initializeSelect2($(this));
            });
        }

        $(document).on("select2:select select2:unselect",".sage-add-topic", function(e) {
            var select_val = $(e.currentTarget).val();
            var select_topic_id = $(e.target).attr('id')
            if(select_val!=-1){
                getsubcategory(select_val,select_topic_id);
            }
        });

        function deleteThis (id){
            $('#expertise-item-'+id).remove();
        }

        function getsubcategory(select_val , topic_id){
            $('.add-subtopic').prop('disabled', true);
            $('body .select2-selection.select2-selection--multiple').addClass('subtopic-loader');
            let id=topic_id.replace('sage-topic-','');
            $.post('{{ route('get-subtopic') }}', {_token:'{{ @csrf_token() }}',data:select_val}, function(data){
                $('#sage-sub-topics-'+id).html(data);
                $('.add-subtopic').attr('disabled', false);
                $('.select2-selection.select2-selection--multiple').removeClass('subtopic-loader');
            });
        }

    </script>
@endpush
