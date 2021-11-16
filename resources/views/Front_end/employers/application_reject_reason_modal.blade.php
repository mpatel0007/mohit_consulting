<div class="modal" id="applicationRejectModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Application reject reason</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none;">
             <ul></ul>
            </div>
            <div id="loader" class=""></div>
                <form onsubmit="return false" method="post" id="application_reject_form" class="needs-validation"  name="application_reject_form">
                    {{ csrf_field() }}
                    <input type="hidden" id="hid" name="hid">

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Reason Subject:</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Subject" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="description">Reason Description :</label>
                        </div>
                        <div class="col-sm-10">
                            <textarea id="description" class="form-control" required class="editor" name="description" rows="10" cols="80"></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="Add_application_reject">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>