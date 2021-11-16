<div class="modal" id="popularSearchModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Popular Search </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none;">
                    <ul></ul>
                </div>
                <form onsubmit="return false" method="post" id="popularSearchForm" class="needs-validation" novalidate name="popularSearchForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="hid" name="hid">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Popular Search Name :</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="popularSearch" id="popularSearch" placeholder="Enter Popular Search Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="status">Status:</label>
                        </div>
                        <div class="col-sm-10">
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select status.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addPopularSearch">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>
