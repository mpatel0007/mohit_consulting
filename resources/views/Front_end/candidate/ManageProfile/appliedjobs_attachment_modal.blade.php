<div class="modal" id="appliedJobsAttachmentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Attachment</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                        @endif
                        @if (\Session::has('error'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{!! \Session::get('error') !!}</li>
                            </ul>
                        </div>
                        @endif
                        <div class="alert alert-danger print-error-msg" style="display:none;">
                            <ul></ul>
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif  
                        <form  method="post" id="attachmentForm" name="attachmentForm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <!-- <label for="description">Message:</label> -->
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="Contact Number">Contact Number :</label>
                                </div>
                                <div class="col-sm-9">
                                   <input type="text" class="form-control" autocomplete="false" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="con_number" name="con_number"  placeholder="Contact Number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="Attachment">Attachment :</label>
                                </div>
                                    <div class="col-md-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="apply_attachment" name="apply_attachment">
                                            <label class="custom-file-label" for="customFile">Attachment</label>
                                        </div>
                                    </div>                            
                            </div>
                        </form>
                    </div>
                </div>       
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="saveAttachmentBtn" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


