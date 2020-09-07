
<div class="modal-header">
    <h5 class="modal-title">Transaction  Details</h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

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
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Question Title</td>
                            <td style="padding: 5px;color: #2196f3">{{$transaction->title($transaction->payment_uid)}}</td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Author Name</td>
                            <td style="padding: 5px;color: #2196f3">{{$transaction->author($transaction->payment_uid, 'name')}}</td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Author Email</td>
                            <td style="padding: 5px;color: #2196f3">{{$transaction->author($transaction->payment_uid, 'email')}}</td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Selected Expert List</td>
                            <td style="padding: 5px;color: #2196f3">
                                @php
                                    $list = $transaction->expert_list($transaction->payment_uid);
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
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="text-uppercase font-size-sm" style="font-weight: 700;color:#797979;font-size:14px;margin-bottom: 10px">Payment Details</p>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-responsive">
                        <tbody>
                        <tr>
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Satus </td>
                            <td style="padding: 5px;color: #2196f3"> {{@$transaction->payment_status}} </td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Transaction ID </td>
                            <td style="padding: 5px;color: #2196f3">{{@$transaction->paypal_transaction_id}} </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px"> User name</td>
                            <td style="padding: 5px;color: #2196f3">{{@$transaction->paypal_first_name}} {{@$transaction->paypal_last_name}}</td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Email</td>
                            <td style="padding: 5px;color: #2196f3">{{@$transaction->paypal_email }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px;font-weight:600;color: #98a6ad;padding: 2px">Time</td>
                            <td style="padding: 5px;color: #2196f3">{{@$transaction->created_at}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
</div>
</div>


