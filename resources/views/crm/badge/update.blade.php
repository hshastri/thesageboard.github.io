<form method="post" action="{{ route('badge.update', base64_encode($badge->id)) }}">
    <input name="_method" type="hidden" value="PATCH">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Update Badge Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Badge <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter badge" name="name" required value="{{$badge->name}}">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Score</label>
                <input type="number" class="form-control border-teal" placeholder="Enter score" name="score" value="{{$badge->score}}">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Icon <span style="color: red">&nbsp*</span></label>
                <input type="text" class="form-control border-teal" placeholder="Enter Icon" name="icon" required value="{{$badge->icon}}">
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn bg-primary">Update badge</button>
    </div>
    </div>
</form>
