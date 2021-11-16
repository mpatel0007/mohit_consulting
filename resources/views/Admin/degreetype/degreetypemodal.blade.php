<div class="modal" id="degreetypeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Degree Type </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none;">
            <ul></ul>
            </div>
                <form onsubmit="return false" method="post" id="degreetypeform" class="needs-validation" novalidate name="degreetypeform">
                    {{ csrf_field() }}
                    <input type="hidden" id="hid" name="hid">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="degreelevel">Degree Level :</label>
                        </div>
                        <div class="col-sm-10">
                            <select class="form-control" id="degreelevel" name="degreelevel" required>
                                <option value="">----Select Degree Level----</option>
                                @foreach($degreelevel as $degreelevel)
                                <option class="custom-select" value='{{$degreelevel->id}}'>{{$degreelevel->degreelevel}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Degree Type :</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="degreetype" id="degreetype" placeholder="Enter Degree Type" required>

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
                        <button type="submit" class="btn btn-primary" id="adddegreetype">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>