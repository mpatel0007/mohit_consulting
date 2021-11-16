
<div class="modal fade" id="stateModal" tabindex="-1" faqs="dialog" aria-labelledby="stateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="stateModalLabel">Add State</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger print-error-msg" style="display:none;">
      <ul></ul>
      </div>
      <form onsubmit="return false" method="post" autocomplete="off" class="needs-validation" novalidate name="stateform" id="stateform">
      {{csrf_field()}}
      <input type = "hidden" id="hid" name="hid">

      <div class="form-group"> 
 <label for="country">country</label>
    <select class="form-control" name="country" id="country">
    <option selected="" disabled="">select country</option>
    @foreach($country as $country)
    <option value='{{$country->id}}'>{{$country->country_name}}</option>
    @endforeach
    </select>
  </div>


      <div class="form-group">
    <label for="state_name">State Name</label>
    <input type="text" class="form-control" id="state_name" name="state_name" placeholder="state Name"  required>
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
