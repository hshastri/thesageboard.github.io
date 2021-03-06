<form method="post" action="{{ route('tags.store') }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Tag Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Tag <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter Tag" name="tag" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Status <span style="color: red">&nbsp*</span></label>
                <select class="custom-select border-teal"  name="status" required>
                    <option value="Active">Active</option>
                    <option value="Disable">Disable</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Save Tag</button>
    </div>
   
</form>
