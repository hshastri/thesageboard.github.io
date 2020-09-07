@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Withdrawals</span>
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
                <h5 class="card-title">Users</h5>
            </div>
            <table class="table datatable-colvis-multi" id="example">
                <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>User</th>
                    <th>Paypal Email</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($with as $with)
                    <tr>
                        <td>{{$with->transaction_id}}</td>
                        <td>{{$with->title}}</td>
                        <td>${{$with->amount}}</td>
                        <td>{{$with->user->username}}</td>
                        <td >{{$with->account}}</td>
                        <td><span class="badge badge-success">{{$with->status}}</span></td>
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
