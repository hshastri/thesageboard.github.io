@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Ask Questions</span>
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
                <h5 class="card-title">User Questions </h5>

            </div>
            <table class="table datatable-colvis-multi" id="example">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Question Title</th>
                    <th>Question Description</th>
                    <th>Tags</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($questions as $key =>$questions)
                    <tr>
                        <td width="5%">{{ ($key+1)  }}</td>
                        <td width="20%"><a href="javascript:void(0)">{{$questions->question_title}} </a></td>
                        <td width="40%">{{ substr(strip_tags($questions->description),0,60)  }}...</td>
                        <td width="10%">{{$questions->tags}}</td>
                        <td width="10%">{{$questions->type}}</td>
                        <td width="10%">
                            @if(@$questions->payment[0]->payment_status=='Paid')
                                <span style="color: blue">Paid</span>
                            @else
                                <span style="color: red">Unpaid</span>
                            @endif
                        </td>
                        <td width="5%">
                            <div class="btn-group">
                                <a style="{{($questions->is_deleted=='1'?'color:red !important':'')}}" href="{{route('crm.questions.details', base64_encode($questions->id))}}"><i class="fas fa-eye mr-3 fa-1x"></i></a>
                                <a style="{{($questions->is_deleted=='1'?'color:red !important':'')}}" href="javascript:void(0)" onclick="confirm_modal('{{route('crm.softdelete',base64_encode($questions->id))}}')" > <i class="fas fa-trash mr-3 fa-1x"></i> </a>
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
