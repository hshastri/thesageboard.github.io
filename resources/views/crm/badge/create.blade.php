<form method="post" action="{{ route('badge.store') }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Badge Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Badge <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter badge" name="name" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Score</label>
                <input type="number" class="form-control border-teal" placeholder="Enter score" name="score" >
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Icon <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter Icon" name="icon" required>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Save badge</button>
    </div>
    </div>
</form>
