<div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="packageModalLabel">Add package</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger print-error-msg" style="display:none;">
          <ul></ul>
        </div>
        <form onsubmit="return false" method="post" autocomplete="off" class="needs-validation" novalidate name="packageform" id="packageform">
          {{csrf_field()}}
          <input type = "hidden" id="hid" name="hid">
          <div class="form-group">
            <label for="package_title">Package Title</label>
            <input type="text" class="form-control" id="package_title" name="package_title" placeholder=""  required>
          </div>
          <div class="form-group">
            <label for="package_price">Package Price</label>
            <input type="text" class="form-control" id="package_price" name="package_price" placeholder=""  required>
          </div>
          <div class="form-group">
            <label for="package_num_days">Package Num days</label>
            <input type="text" class="form-control" id="package_num_days" name="package_num_days" placeholder="" value="30" readonly=""  required>
          </div>
          <div class="form-group" style="display: none;">
            <label for="package_num_listings">Package Num Listings</label>
            <input type="text" class="form-control" id="package_num_listings" name="package_num_listings" placeholder="">
          </div>

          <div class="form-group">
           <label for="package_for">Package For</label>
           <select class="form-control" id="package_for" name="package_for">
             <!-- <option selected="" disabled="">Package For</option> -->
             <option value="1">Candidate</option>
             <option value="0">Employer</option>
             <!-- <option value="2">Both</option> -->
           </select>
         </div>

         <div class="form-group">
           <label for="status">Status</label>
           <select class="form-control" id="status" name="status">
             <option value="1" >Active</option>
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