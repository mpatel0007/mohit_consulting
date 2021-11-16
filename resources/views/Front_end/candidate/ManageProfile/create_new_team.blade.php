<div class="modal" id="createteamModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Create New Team </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none;">
                    <ul></ul>
                </div>
                <div class="" id="loader"></div>
                <form onsubmit="return false" method="post" id="createteamForm" class="needs-validation" novalidate name="createteamForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="teamid" name="teamid">
                    <input type="hidden" id="edit_team_type" name="edit_team_type" value="{{isset($team_details[0]->team_id) ? 'old' : 'new'}}">
                    <input type="hidden" id="edit_team_id" name="edit_team_id" value="{{isset($team_details[0]->team_id) ? $team_details[0]->team_id : ''}}">

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="Team name">Team Name :</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="team_name" name="team_name" placeholder="Enter Team Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="description">Description :</label>
                        </div>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="description">Attachments :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="file" class="custom-file-input attachments" id="attachments" name="attachments">
							<label class="custom-file-label" for="customFile">Add Attachments</label>
                        </div>
                        <div class="col-sm-2">
                            <div class="attachmentsDownload" id="attachmentsDownload" name="attachmentsDownload">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" id="createteamBtn" name="createteamBtn" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>
