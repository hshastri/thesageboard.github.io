@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Transaction Details</span>
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
                <h5 class="card-title">Transaction Details </h5>

            </div>
            <table class="table datatable-colvis-multi" id="example">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Transaction ID</th>
                    <th>Question Title</th>
                    <th>Expert List</th>
                    <th>Total Amount</th>
                    <th>Author</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $key =>$payments)
                    <tr>
                        <td width="5%">{{ ($key+1)  }}</td>
                        <td width="15%">{{$payments->paypal_transaction_id}} </td>
                        <td width="40%">{{$payments->title($payments->payment_uid)}}</td>
                        <td width="20%">
                            @php
                            $list = $payments->expert_list($payments->payment_uid);
                            @endphp
                            @if(!empty($list))
                                <ol type="1">
                                    @foreach(json_decode($list) as $key => $value)
                                        @if($value)
                                            @php
                                                $users = App\User::where('id', $value)->first();
                                            @endphp
                                            <li>{{$users->first_name}} {{$users->last_name}}</li>
                                        @endif
                                    @endforeach
                                </ol>
                            @endif
                        </td>
                        <td width="5%">{{$payments->paypal_paid_amount}}</td>
                        <td width="10%">{{$payments->author($payments->payment_uid, "name")}}</td>
                        <td width="5%">
                            <div class="btn-group">
                                <a href="javascript:void(0)" onclick="show_transaction_modal('{{route('crm.transaction.details', base64_encode($payments->id))}}')"><i class="fas fa-eye mr-3 fa-1x"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /multi-column layout -->
    </div>

    <div id="ask_transaction_modal" class="modal fade m-5" data-keyboard="false" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg mt-5">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="text/javascript">
        function show_transaction_modal(dataUrl){
            $.get(dataUrl, function(data){
                $('#modal-content').html(data);
                $('#ask_transaction_modal').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endpush
