<form method="post" action="{{ route('category.store') }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Category Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Category <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter category" name="name" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Font Awesome Icon Class <small>(32x32)</small> <span style="color: red">&nbsp*</span></label>
                <input type="text" name="icon"  class="form-control border-teal" placeholder="Ex: icon-user" required>
                <a target="_blank" href="https://fontawesome.com/v3.2.1/icons/">Click To Show Icon List</a>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Description</label>
                <input type="text" class="form-control border-teal" placeholder="Enter description" name="description" >
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Status <span style="color: red">&nbsp*</span></label>
                <select class="custom-select border-teal" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Disable">Disable</option>
                </select>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Save Category</button>
    </div>
    </div>
</form>
