@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Question Information</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->

    <div class="offset-md-2 content col-8 ">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Update Question Inforamtion</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('question.update',base64_encode($question->id)) }}">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label >Category <span style="color: red">&nbsp*</span></label>
                            <select class="custom-select border-teal" required name="category_id" id="category_id">
                                @foreach($category as $category)
                                    <option value="{{$category->id}}" {{($question->category_id==$category->id)?'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Sub Category <span style="color: red">&nbsp*</span></label>
                            <select class="custom-select border-teal" required name="subcategory_id" id="subcategory_id">

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Question <span style="color: red">&nbsp*</span></label>
                            <input type="text" class="form-control  border-teal" name="question" placeholder="Enter Question" value="{{$question->question}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Multiple Question Type : <span style="color: red">&nbsp*</span></label>

                            <div class="form-check form-check-inline" style="top: .5em; left: .5em">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input-styled" name="type" value="1" onclick="enable_multiple_field(this.value)" {{($question->type==1)?'checked':''}} data-fouc>
                                    Radio
                                </label>
                            </div>

                            <div class="form-check form-check-inline" style="top: .5em; left: .5em">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input-styled" name="type" value="2" onclick="enable_multiple_field(this.value)" {{($question->type==2)?'checked':''}} data-fouc>
                                    Select Option
                                </label>
                            </div>

                            <div class="form-check form-check-inline" style="top: .5em; left: .5em">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input-styled" name="type" value="3" onclick="enable_multiple_field(this.value)" {{($question->type==3)?'checked':''}} data-fouc >
                                    Input Field
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group" id="multiple_question_div" >
                        <div id="multiple_question">
                            <label>Multiple Question <span style="color: red">&nbsp*</span></label>
                            @if(!empty($question->multiple_question))
                                @foreach(json_decode($question->multiple_question) as $key => $value)
                                    @if($value)
                                        <div class="row mt-2">
                                            <div class="col-2">
                                                <button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" class="form-control  border-teal" name="multiple_question[]" placeholder="Multiple Question" value="{{$value}}" id="hidden_multiple_value" required>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <input type="text" class="form-control  border-teal" name="multiple_question[]" placeholder="Enter Multiple Question" id="hidden_multiple_value" required>
                            @endif
                        </div>
                        <div class="text-right mt-2">
                            <button type="button" class="btn btn-info mb-3" onclick="add_more_question()">Add More</button>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Status <span style="color: red">&nbsp*</span></label>
                            <select class="custom-select border-teal"  name="status" required>
                                <option value="Active" {{($question->status=='Active')?'selected':''}}>Active</option>
                                <option value="Disable" {{($question->status=='Disable')?'selected':''}}>Disable</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn bg-primary" style="text-transform:unset !important">Update Question</button>
                </form>
            </div>
        </div>
    </div>

    <!-- /content area -->
@endsection

@push('js')
    <script>
        $( document ).ready(function() {
            get_subcategories_by_category();
            enable_multiple_field({{$question->type}})
        });

        function get_subcategories_by_category(){
            var category_id = $('#category_id').val();
            $.post('{{ route('get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
                $('#subcategory_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#subcategory_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));

                }

                $("#subcategory_id > option").each(function() {
                    if(this.value == '{{$question->subcategory_id}}'){
                        $("#subcategory_id").val(this.value).change();
                    }
                });

            });
        }

        $('#category_id').on('change', function() {
            get_subcategories_by_category();
        });

        function add_more_question(){
            var multipleQuestion =  `<div class="row mt-2">
                <div class="col-2">
                <button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash"></i></button>
            </div>
            <div class="col-10">
                <input type="text" class="form-control  border-teal" name="multiple_question[]" placeholder="Multiple Question" required>
            </div>
            </div>`;
            $('#multiple_question').append(multipleQuestion);
        }

        function delete_this_row(em){
            $(em).closest('.row').remove();
        }

        function enable_multiple_field(eleval){
            if(eleval==3){
                $("#multiple_question_div").css('display','none');
                $("#hidden_multiple_value").removeAttr('required');
            }else{
                $("#multiple_question_div").css('display','block');
                $("#hidden_multiple_value").prop('required',true);
            }
        }

    </script>
@endpush
