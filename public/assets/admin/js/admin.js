// const { compact } = require("lodash");

$(document).ready(function () {
    $('#AdminModal').on('hidden.bs.modal', function () {
        // $('#addadminform').trigger("reset");
        $('.print-error-msg').hide();
        $('#addadminform')[0].reset();
        // $("#addadminform").get(0).reset();
        $('.modal-title').html('Create New Admin');
        $('label[class="error"]').remove();
        // $('#hid').val('');
        $('#add').html('Add');
        $('select').removeClass('error'); 
        $("#password").rules("add", "required");
        $("#adminemail").rules("add", "required");
        // $("#adminemail").rules( "add", "remote");
        $('#adminemail').css('cursor', 'text');
        $('#adminemail').prop('readonly',false);
        // $('#adminemail').prop('required',true);
    });
    getalladminsdata();

    $("#openModal").on('click', function () {
        $('#AdminModal').modal('show');
    });

    $('form[id="addadminform"]').validate({
        rules: {
          adminname: 'required',
          is_admin: 'required',
          role: 'required',
          adminemail: {
            required: true,
            email: true,
            remote:{
                url:BASE_URL + '/' + ADMIN + '/admin/emailcheck',
                type: "get",
                data: { 
                    //hid : $('#hid').val() 
                    hid: function()
                    {
                        return $('#hid').val();
                    }
                },
              }
          },
          password: {
            required: true,
            minlength: 6,
          }
        },
        messages: {
          adminname: 'This field is required',
          is_admin: 'is Admin is required',
          role: 'This field is required',
          adminemail: {
            required:'Email is required',
              email:'Enter a valid email',
              remote: 'That email address is already registered.'
          },
          password: {
            required:'Password is required',
            minlength: 'Password must be at least 6 characters long'
          }
        },
        submitHandler: function(form) {
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/admin/add',
                type: 'post',
                data: $('#addadminform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#AdminModal').modal('hide');
                        $('#hid').val('');
                        $('#adminname').val('');
                        $('#adminemail').val('');
                        $('#password').val('');
                        // $('#status').val('');
                        $('#add').html('Add');        
                        // $('#addadminform')[0].reset();     
                        getalladminsdata();                          
                    } else if (data.status == 0) {
                        printErrorMsg(data.error)
                    }  else {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
    
                }
            });
        }
      });

});
function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}


    function getalladminsdata() {
            $('#admins_datatable').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,     
                "bAutoWidth": false,
                "ajax": {
                    type: 'POST',
                    url: BASE_URL + '/'  + ADMIN + '/admin/datatable',
                    data: {
                        "_token": $("[name='_token']").val(),
                    },
                },
                columns: [
                    {data: 'name', name: 'admin.name'},
                    {data: 'email', name: 'admin.email'},
                    {data: 'is_admin', name: 'admin.is_admin'},
                    {data: 'role_name', name: 'role.name'},
                    {data: 'status', name: 'admin.status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
    }


function delete_admin(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/admin/delete',
                type: 'POST',
                data: {
                    'id': id,
                    "_token": $("[name='_token']").val(),
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'error'
                        )
                    }
                    getalladminsdata();
                }
            });
        }
    })
}

function edit_admin(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/admin/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#add').html('Update');
            $('.modal-title').html('Update Admin');
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.admin;
                $('#password').prop('required',false);
                $('#adminemail').prop('required',false);

                $('#hid').val(result.id);
                var hid =  $('#hid').val();
                if(hid > 0){
                    $("#password").rules("remove", "required");
                    $("#adminemail").rules("remove", "required");
                    // $("#adminemail").rules("remove", "remote");
                }
                $('#adminname').val(result.name);
                $('#adminemail').val(result.email).prop('readonly',true);
                $('#adminemail').css('cursor', 'not-allowed');
                // $('#password').val(result.password);
                $('#is_admin').val(result.is_admin);
                $('#role').val(result.role_id);
                // $('#admin_status').val(result.status);
                $('select[name="status"]').val(result.status).trigger("change");
            $('#AdminModal').modal('show');
            }
        }
    });
}






