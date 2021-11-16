<div class="modal" id="Email_template_Modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Email Template</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none;">
             <ul></ul>
            </div>
            <div id="loader" class=""></div>
                <form onsubmit="return false" method="post" id="Email_template_form" class="needs-validation"  name="Email_template_form">
                    {{ csrf_field() }}
                    <input type="hidden" id="hid" name="hid">

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Template Title:</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Template Title" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Subject:</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Subject" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="description">Email Template Description :</label>
                        </div>
                        <div class="col-sm-10">
                            <textarea id="description" class="form-control" required class="editor" name="description" rows="10" cols="80"></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="Add_Email_template">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>