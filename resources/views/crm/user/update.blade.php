<form method="post" action="{{ route('users.update',base64_encode($users->id)) }}">
    <input name="_method" type="hidden" value="PATCH">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">User Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-6">
                <label>First Name <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter first Name" name="first_name" value="{{$users->first_name}}" required>
            </div>

            <div class="col-lg-6">
                <label>Last Name <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter Last Name" name="last_name"  value="{{$users->last_name}}" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Email <span style="color: red">&nbsp*</span></label>
                <input type="email" class="form-control border-teal" placeholder="Enter Email" name="email" value="{{$users->email}}" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Role As <span style="color: red">&nbsp*</span></label>
                <select class="custom-select border-teal"  name="role" required>
                    <option value="General" {{($users->role=='General')?'selected':''}}>General User</option>
                    <option value="Expertise" {{($users->role=='Expertise')?'selected':''}}>Expertise</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Status <span style="color: red">&nbsp*</span></label>
                <select class="custom-select border-teal"  name="status" required>
                    <option value="Active" {{($users->status=='Active')?'selected':''}}>Active</option>
                    <option value="Disable" {{($users->status=='Pending')?'selected':''}}>Pending</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Update User Information</button>
    </div>
</form>
