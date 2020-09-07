@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Questions</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <!-- Multi-column layout -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Questions</h5>
                <a href="{{route('question.create')}}" class="btn btn-outline-success">Add Question</a>
            </div>
            <table class="table datatable-colvis-multi" id="example">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Question</th>
                    <th>Multiple Option</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($question as $key =>$question)
                    <tr>
                        <td width="5%">{{ ($key+1)  }}</td>
                        <td width="5%">{{$question->category->name}}</td>
                        <td width="5%">{{$question->subcategory->name}}</td>
                        <td width="25%">{{$question->question}}</td>
                        <td width="50%">
                            @if(!empty($question->multiple_question))
                            <ol type="1">
                                @foreach(json_decode($question->multiple_question) as $key => $value)
                                    @if($value)
                                        <li>{{$value}}</li>
                                    @endif
                                @endforeach
                            </ol>
                            @endif
                        </td>
                        <td width="5%">
                            @if($question->status=='Active')
                                <span style="color: blue">{{$question->status}}</span>
                            @else
                                <span style="color: red">{{$question->status}}</span>
                            @endif
                        </td>
                        <td width="5%">
                            <div class="btn-group">
                                <a href="{{route('question.edit', base64_encode($question->id))}}"><i class="fas fa-edit mr-3 fa-1x"></i></a>
                                <a href="javascript:void(0)" onclick="confirm_modal('{{route('question.destroy',base64_encode($question->id))}}')" > <i class="fas fa-trash mr-3 fa-1x"></i> </a>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /multi-column layout -->
    </div>
@endsection

