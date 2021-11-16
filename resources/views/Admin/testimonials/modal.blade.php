<div class="modal fade" id="testimonialModal" tabindex="-1" role="dialog" aria-labelledby="testimonialModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="testimonialModalLabel">Add Testimonial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger print-error-msg" style="display:none;">
      <ul></ul>
      </div>
      <form onsubmit="return false" method="post" autocomplete="off" class="needs-validation" novalidate name="Testimonialform" id="Testimonialform">
      {{csrf_field()}}
      <input type = "hidden" id="hid" name="hid">
      <div class="form-group">
    <label for="testimonial_by">Testimonial By</label>
    <input type="text" class="form-control" id="testimonial_by" name="testimonial_by" placeholder="Testimonial By"  required>
    </div>
    <div class="form-group">
    <label for="testimonial">Testimonial</label>
     <textarea class="form-control" id="testimonial" name="testimonial" rows="5" placeholder="Testimonial" required></textarea>
     </div>
     <div class="form-group">
    <label for="company_and_designation">Company and Designation</label>
    <input type="text" class="form-control" id="company_and_designation" name="company_and_designation" placeholder="Company and Designation"  required>
    </div>
    <div class="form-group">
    <label for="custom-radio">Is Default ?</label><br>
     <div class="custom-control custom-radio custom-control-inline">
     <input type="radio" id="defaultyes" name="is_default" class="custom-control-input" value ="yes">
     <label class="custom-control-label" for="defaultyes"> Yes</label>
     </div>
     <div class="custom-control custom-radio custom-control-inline">
      <input type="radio" id="defaultno" name="is_default" class="custom-control-input" value ="no" checked="true">
       <label class="custom-control-label" for="defaultno"> No</label>
      </div>
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