@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Refunds</span>
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
                <h5 class="card-title">Refunds</h5>
            </div>
            <table class="table datatable-colvis-multi" id="example">
                <thead>
                <tr>
                    <th width="25%">Title</th>
                    <th>User</th>
                    <th width="18%">Expert</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($refund as $refund)
                    <tr>
                        <td><a href="{{route('crm.refund-details',['qid'=>$refund->question_id,'uid'=>$refund->user_id, 'eid'=>$refund->expert_id,'rid'=>$refund->id])}}">{{ucfirst($refund->question->question_title)}}</a></td>
                        <td>Requested By <a href="">{{$refund->user->username}}</a></td>
                        <td><a href="">{{$refund->expert->username}}</a></td>
                        <td>$ {{$refund->amount}}</td>
                        <td>{{$refund->payment_id}}</td>
                        <td>
                            @if($refund->status=='Completed')
                            <span class="badge badge-success">{{$refund->status}}</span>
                            @elseif($refund->status=='Pending')
                            <span class="badge badge-info">{{$refund->status}}</span>
                            @else
                            <span class="badge badge-danger">{{$refund->status}}</span>
                            @endif
                        </td>
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
