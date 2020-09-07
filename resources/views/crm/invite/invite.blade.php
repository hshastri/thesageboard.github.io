<form method="post" action="{{ route('invite.store') }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">User Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-6">
                <label>First Name <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter first Name" name="first_name" required>
            </div>

            <div class="col-lg-6">
                <label>Last Name <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter Last Name" name="last_name" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Email <span style="color: red">&nbsp*</span></label>
                <input type="email" class="form-control border-teal" placeholder="Enter Email" name="email" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Invitation As <span style="color: red">&nbsp*</span></label>
                <select class="custom-select border-teal"  name="role" required>
                    <option value="General">General User</option>
                    <option value="Expertise">Expertise</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Invite User</button>
    </div>

</form>
