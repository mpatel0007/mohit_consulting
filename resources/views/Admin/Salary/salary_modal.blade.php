<div class="modal" id="salaryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Salary </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none;">
                <ul></ul>
            </div>
                <form onsubmit="return false" method="post" id="salaryform" class="needs-validation" novalidate name="salaryform">
                    {{ csrf_field() }}
                    <input type="hidden" id="hid" name="hid">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Salary :</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="salary" id="salary" placeholder="e.g. 40,000 – 50,000" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="status">Status :</label>
                        </div>
                        <div class="col-sm-10">
                            <select class="form-control" id="status" name="status" >
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addsalary">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>