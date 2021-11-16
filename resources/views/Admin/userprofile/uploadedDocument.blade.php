<div class="modal" id="UploadedDocument">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Document List</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none;">
                    <ul></ul>
                </div>
                <input type="hidden" id="User_id" name="User_id" value="">
                <div id="UploadedDocumentTable">
                    <a onclick="download_candidate_resume()" class="btn btn-info mt-4"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a>
                    <a onclick="download_candidate_cover_letter()" class="btn btn-info mt-4"><i class="fa fa-download" aria-hidden="true"></i> Download Cover Letter</a>
                    <a onclick="download_candidate_references()" class="btn btn-info mt-4"><i class="fa fa-download" aria-hidden="true"></i> Download References</a>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>
