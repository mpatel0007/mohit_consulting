<div class="modal fade" id="industriesModal" tabindex="-1" faqs="dialog" aria-labelledby="industriesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="industriesModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none;">
                    <ul></ul>
                </div>
                <form onsubmit="return false" method="post" autocomplete="off" class=" needs-validation" novalidate
                    name="industriesform" id="industriesform">
                    {{ csrf_field() }}
                    <input type="hidden" id="hid" name="hid">
                    <div class="form-group">
                        <label for="industry_name">Category Name</label>
                        <input type="text" class="form-control" id="industry_name" name="industry_name"
                            placeholder="Category Name" required>
                    </div>

                    {{-- <div class="form-group">
                        <label for="category_icon_class">Category Icon Class</label>
                        <input type="text" class="form-control" id="category_icon_class" name="category_icon_class"
                            placeholder="e.g lni-heart" required>
                    </div> --}}

                    <div class="form-group">
                        <label for="custom-radio">Is Default ?</label><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="defaultyes" name="is_default" class="custom-control-input"
                                value="yes">
                            <label class="custom-control-label" for="defaultyes"> Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="defaultno" name="is_default" class="custom-control-input" value="no"
                                checked="true">
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
