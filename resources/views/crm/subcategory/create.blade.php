<form method="post" action="{{ route('subcategory.store') }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Subcategory Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Category <span style="color: red">&nbsp*</span></label>
                <select class="custom-select border-teal" required name="category_id">
                    @foreach($category as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Subcategory <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter subcategory" name="name" required>
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
        <button type="submit" class="btn bg-primary">Save Subcategory</button>
    </div>

</form>
