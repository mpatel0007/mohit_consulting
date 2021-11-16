
<div class="modal fade" id="faqsModal" tabindex="-1" faqs="dialog" aria-labelledby="faqsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="faqsModalLabel">Add Faqs</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger print-error-msg" style="display:none;">
      <ul></ul>
      </div>
      <form onsubmit="return false" method="post" autocomplete="off" class="needs-validation"  name="faqsform" id="faqsform">
      {{csrf_field()}}
      <input type = "hidden" id="hid" name="hid">
      <div class="form-group row">
       <div class="col-sm-12">
       <label for="questioneditor">Questions</label>
        <!-- </div> -->
      <!-- <div class="col-sm-10"> -->
     <textarea id="questioneditor" class="form-control" class="editor" name="questioneditor" rows="4" cols="80"></textarea>
     </div>
     </div>
     <div class="form-group row">
       <div class="col-sm-12">
       <label for="answereditor">Answers</label>
        <!-- </div> -->
      <!-- <div class="col-sm-10"> -->
     <textarea id="answereditor" class="form-control" class="editor" name="answereditor" rows="4" cols="80"></textarea>
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
