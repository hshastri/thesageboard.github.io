<form method="post" action="{{ route('make-refund', ['qid'=>$qid, 'eid'=>$eid]) }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Refund Info</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Amount <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="amount" name="amount" value="{{$ramount}}" required readonly>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Transaction ID <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Transaction ID" name="transaction_id" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Get Refund</button>
    </div>
    </div>
</form>
