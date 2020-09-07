@extends('crm.layout.app')
@section('content')
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Payments Settings</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="offset-3 col-md-6">
            <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Paypal Settings</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('crm.payment_settings')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Paypal Client ID</label>
                        <input type="text" class="form-control" placeholder="Paypal Client Id" name="item[paypal_client_id]" value="{{@$result['paypal_client_id']}}" required>
                    </div>

                    <div class="form-group">
                        <label>Paypal Secrect Key</label>
                        <input type="text" class="form-control" placeholder="Paypal Secrect Key" name="item[paypal_secrect]" value="{{@$result['paypal_secrect']}}" required>
                    </div>

                    <div class="form-group">
                        <label>Payment Mode</label>
                        <select name="item[paypal_mode]" class="form-control">
                            <option value="sandbox" {{(@$result['paypal_mode']=='sandbox')?'selected':''}}>Sandbox</option>
                            <option value="live" {{(@$result['paypal_mode']=='live')?'selected':''}}}>Live</option>
                        </select>
                    </div>


                    <div class="d-flex justify-content-between pull-right" style="float: right">
                        <button type="submit" class="btn bg-blue">Submit <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
         </div>
    </div>
@endsection
