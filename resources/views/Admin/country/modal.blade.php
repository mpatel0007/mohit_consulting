
<div class="modal fade" id="countryModal" tabindex="-1" faqs="dialog" aria-labelledby="countryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="countryModalLabel">Add Country</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger print-error-msg" style="display:none;">
      <ul></ul>
      </div>
      <form onsubmit="return false" method="post" autocomplete="off" class="needs-validation" novalidate name="countryform" id="countryform">
      {{csrf_field()}}
      <input type = "hidden" id="hid" name="hid">
      <div class="form-group">
    <label for="country_name">Country Name</label>
    <input type="text" class="form-control" id="country_name" name="country_name" placeholder="Country Name"  required>
    </div>
    <div class="form-group">
    <label for="sort_name">Sort Name</label>
    <input type="text" class="form-control" id="sort_name" name="sort_name" placeholder="Sort Name"  required>
    </div>

    <div class="form-group">
    <label for="phone_code">Phone Code</label>
    <input type="text" class="form-control" id="phone_code" name="phone_code" placeholder="Phone Code"  required>
    </div>
    <div class="form-group">
    <label for="currency">Currency</label>
    <input type="text" class="form-control" id="currency" name="currency" placeholder="Currency"  required>
    </div>
    <div class="form-group">
    <label for="code">Code</label>
    <input type="text" class="form-control" id="code" name="code" placeholder="Code"  required>
    </div>
    <div class="form-group">
    <label for="symbol">Symbol</label>
    <input type="text" class="form-control" id="symbol" name="symbol" placeholder="Symbol"  required>
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
