
             <!-- The Modal -->
             <div class="modal" id="AdminModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Create New Admin</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="alert alert-danger print-error-msg" style="display:none;">
                                <ul></ul>
                            </div>
                            <form onsubmit="return false" method="post" id="addadminform" class="needs-validation" novalidate name="addadminform">
                                {{ csrf_field() }}
                                <input type ="hidden" id="hid" name="hid">
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label>Name :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="adminname" id="adminname" placeholder="Enter Full Name" required>
                                     
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label>Email :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="adminemail" id="adminemail" placeholder="Enter Email" required>
                                   
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label>Password :</label>
                                    </div>
                                    <div class="col-sm-10 password">
                                            <input type="password" class="form-control " name="password" id="password" placeholder="Enter password" required />
                                     
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="is_admin">Is Admin :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="is_admin" name="is_admin" required>
                                            <option value=" " selected="" disabled="">----Select Is Admin----</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="role">Role :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="role" name="role" required>
                                            <option value=""selected="" >----Select Role----</option>
                                            @foreach($role as $role)
                                            <option class="custom-select" value='{{$role->id}}'>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                      
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="status">Status :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="status" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                     
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="add">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal footer -->
                </div>
            </div>