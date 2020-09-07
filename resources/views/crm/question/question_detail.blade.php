@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">User Question Information</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content col-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Questions Inforamtion</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <p class="text-uppercase font-size-sm" style="font-weight: 700;color:#797979;font-size:14px;margin-bottom: 10px">Question Information</p>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-responsive">
                                    <tbody>
                                    <tr>
                                        <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Category</td>
                                        <td style="padding: 5px;color: #2196f3">{{@$askquestion->category->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Subcategory</td>
                                        <td style="padding: 5px;color: #2196f3">{{@$askquestion->subcategory->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Tags</td>
                                        <td style="padding: 5px;color: #2196f3">{{@$askquestion->tags}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Type</td>
                                        <td style="padding: 5px;color: #2196f3">{{@$askquestion->type}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px"> Label</td>
                                        <td style="padding: 5px;color: #2196f3">{{@$askquestion->question_label}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Selected Expert List</td>
                                        <td style="padding: 5px;color: #2196f3">
                                            @if(!empty($askquestion->experties_ids))
                                                <ol type="1">
                                                    @foreach(json_decode($askquestion->experties_ids) as $key => $value)
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
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <p class="text-uppercase font-size-sm" style="font-weight: 700;color:#797979;font-size:14px;margin-bottom: 10px">Question Details Information</p>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-responsive">
                                    <tbody>
                                    <tr>
                                        <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Total Answer</td>
                                        <td style="padding: 5px;color: #2196f3">{{@$askquestion->answer->count()}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Total Vote</td>
                                        <td style="padding: 5px;color: #2196f3">{{@$askquestion->total_vote($askquestion->id)}}</td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p class="text-uppercase font-size-sm" style="font-weight: 700;color:#797979;font-size:14px;margin-bottom: 10px">Question Description</p>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-responsive">
                                    <tbody>
                                    <tr>
                                        <td style="padding: 5px;color: #2196f3"> {!! $askquestion->description !!}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if($askquestion->payment->count()>0)
                        <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p class="text-uppercase font-size-sm" style="font-weight: 700;color:#797979;font-size:14px;margin-bottom: 10px">Payment Details</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <table class="table table-borderless table-responsive">
                                            <tbody>
                                            <tr>
                                                <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Total Amount </td>
                                                <td style="padding: 5px;color: #2196f3"> {{@$askquestion->amount}}</td>
                                            </tr>

                                            <tr>
                                                <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Satus </td>
                                                <td style="padding: 5px;color: #2196f3"> {{@$askquestion->payment[0]->payment_status}} </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Transaction ID </td>
                                                <td style="padding: 5px;color: #2196f3">{{@$askquestion->payment[0]->paypal_transaction_id}} </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-6">
                                        <table class="table table-borderless table-responsive">
                                            <tbody>

                                            <tr>
                                                <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px"> User name</td>
                                                <td style="padding: 5px;color: #2196f3">{{@$askquestion->payment[0]->paypal_first_name}} {{@$askquestion->payment[0]->paypal_last_name}}</td>
                                            </tr>

                                            <tr>
                                                <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Email</td>
                                                <td style="padding: 5px;color: #2196f3">{{@$askquestion->payment[0]->paypal_email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Time</td>
                                                <td style="padding: 5px;color: #2196f3">{{@$askquestion->created_at}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     @endif
                </div>
            </div>
        </div>
    </div>
<!-- /content area -->
@endsection

@push('js')
@endpush
