<form method="post" action="{{ route('category.update', base64_encode($category->id)) }}">
    <input name="_method" type="hidden" value="PATCH">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Update Category Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Category <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter category" name="name" required value="{{$category->name}}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Font Awesome Icon Class <small>(32x32)</small> <span style="color: red">&nbsp*</span></label>
                <input type="text"  name="icon"  class="form-control border-teal" required value="{{$category->icon}}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Description</label>
                <input type="text" class="form-control border-teal" placeholder="Enter description" name="description" value="{{$category->description}}" >
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Status <span style="color: red">&nbsp*</span></label>
                <select class="custom-select border-teal" name="status" required>
                    <option value="Active" {{($category->status=='Active')?'selected':''}}>Active</option>
                    <option value="Disable" {{($category->status=='Disable')?'selected':''}}>Disable</option>
                </select>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Update Category</button>
    </div>
    </div>
</form>
