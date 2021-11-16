
<div class="modal fade" id="cityModal" tabindex="-1" faqs="dialog" aria-labelledby="cityModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cityModalLabel">Add City</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger print-error-msg" style="display:none;">
      <ul></ul>
      </div>
      <form onsubmit="return false" method="post" autocomplete="off" class="needs-validation" novalidate name="cityform" id="cityform">
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



  <div class="form-group" id="123">
 <label for="state">State</label>
    <div id="statelist">
 <select class="form-control" name="state" id="state">
 <option selected="" disabled="" >select state</option>
 <option value=''></option>
 </select>
</div>
</div>







      <div class="form-group">
    <label for="city_name">City Name</label>
    <input type="text" class="form-control" id="city_name" name="city_name" placeholder="City Name"  required>
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
