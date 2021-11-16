<div class="modal" id="createtaskModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Create New Task </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none;">
                    <ul></ul>
                </div>
                <div class="" id="loader"></div>
                <form onsubmit="return false" method="post" id="createtaskForm" class="needs-validation" novalidate name="createtaskForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="task_team_id" name="task_team_id" value="">
                    <input type="hidden" id="edit_task_id" name="edit_task_id" value="">
                    <input type="hidden" id="task_id" name="task_id" value="{{isset($team_details[0]->team_id) ? $team_details[0]->team_id : ''}}">

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="Task name">Task Name :</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Enter Task Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="Description">Description :</label>
                        </div>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="taskdescription" name="taskdescription" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="description">Attachments :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="file" class="custom-file-input attachments" id="taskattachments" name="taskattachments">
							<label class="custom-file-label" for="customFile">Add Attachments</label>
                        </div>
                        <div class="attachmentsDownload" id="attachmentsDownload" name="attachmentsDownload">
                            
                        </div>
                    </div>
                    <hr>
                    <button type="submit" id="createtaskBtn" name="createtaskBtn" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>
