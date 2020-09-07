@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Feedback</span>
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

            <table class="table datatable-colvis-multi" id="example">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Given Score</th>
                    <th>Comment</th>
                </tr>
                </thead>
                <tbody>
                @foreach($feedback as $key =>$feedback)
                    <tr>
                        <td width="10%">{{ ($key+1)  }}</td>
                        <td width="20%">{{$feedback->user->first_name}} {{$feedback->user->last_name}}</td>
                        <td width="20%">{{$feedback->user->email}}</td>
                        <td width="10%">{{$feedback->score}}</td>
                        <td width="40%">{{$feedback->comment}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /multi-column layout -->
    </div>

@endsection
@push('js')

@endpush
