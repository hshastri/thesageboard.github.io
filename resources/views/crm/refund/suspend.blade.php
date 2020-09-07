
<form action="{{route('suspend-refund' , $refund->id)}}" method="post">
@csrf
    <div class="modal-header bg-danger">
        <h5 class="modal-title">You are going to suspend the refund.</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6 col-xl-12">
                <div class="card card-body p-2">
                    <div class="media">
                        <div class="media-body text-left">
                            <h4 class="font-weight-semibold mb-0">{{$refund->user->username}}</h4>
                            <span class="text-uppercase font-size-sm text-muted">Refund Asked</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-12">
                <div class="card card-body p-2">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-question4 icon-3x text-success-400"></i>
                        </div>
                        <div class="media-body text-right">
                            <h4 class="font-weight-semibold mb-0"><a href="">{{$refund->expert->username}}</a></h4>
                            <span class="text-uppercase font-size-sm text-muted">Expert</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-12">
                <div class="card card-body p-2">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-coin-dollar icon-3x text-success-400"></i>
                        </div>
                        <div class="media-body text-right">
                            <h4 class="font-weight-semibold mb-0">${{$refund->amount}}</h4>
                            <span class="text-uppercase font-size-sm text-muted">Amount</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Suspend Refund</button>
    </div>
</form>
