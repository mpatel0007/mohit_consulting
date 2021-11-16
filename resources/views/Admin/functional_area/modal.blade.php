<div class="modal fade" id="functional_areaModal" tabindex="-1" role="dialog"
    aria-labelledby="functional_areaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="functional_areaModalLabel">Add Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none;">
                    <ul></ul>
                </div>
                <form onsubmit="return false" method="post" autocomplete="off" class="needs-validation" novalidate
                    name="functional_areaform" id="functional_areaform">
                    {{ csrf_field() }}
                    <input type="hidden" id="hid" name="hid">
                    <div class="form-group">
                          <label for="Category">Category :</label>
                          <select class="form-control" id="category" name="category" required>
                              <option value="">----Select Category----</option>
                              @foreach($Categories as $Category)
                                    <option class="custom-select" value='{{$Category['id']}}'>{{$Category['industry_name']}}</option>
                              @endforeach
                          </select>
                      </div>
                    <div class="form-group">
                        <label for="functional_area">Sub Category</label>
                        <input type="text" class="form-control" id="functional_area" name="functional_area" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submitbtn">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>
