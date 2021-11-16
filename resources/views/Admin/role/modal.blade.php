<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLabel">Add Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger print-error-msg" style="display:none;">
      <ul></ul>
      </div>
      <form onsubmit="return false" method="post" autocomplete="off" class="text-infom needs-validation" novalidate name="Roleform" id="Roleform">
      {{csrf_field()}}
      <input type = "hidden" id="hid" name="hid">
      <div class="form-group">
    <label for="role">Role</label>
    <input type="text" class="form-control" id="name" name="name"  required>
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