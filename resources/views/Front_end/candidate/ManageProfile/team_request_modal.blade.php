
<div class="modal" id="descriptionAboutTeamRequestModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Send Message</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none;">
                    <ul></ul>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <form  method="post" id="descriptionForm" name="descriptionForm">
                            <!-- <label for="description">Message:</label> -->
                            <textarea id="descriptionTeamReq" class="form-control" required class="editor" name="descriptionTeamReq" rows="10" cols="80"></textarea>
                        </form>
                    </div>
                </div>       
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="saveDescription" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

{{-- <script> CKEDITOR.replace('description');</script> --}}


