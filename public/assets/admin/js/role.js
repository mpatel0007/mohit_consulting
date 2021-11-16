$(document).ready(function () {
    Readdata();
    $('#rolemodelbutton').click(function () {
        $('#roleModal').modal('show');

    });
    $('#roleModal').on('hidden.bs.modal', function () {
        $('#Roleform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('.print-error-msg').hide();
        $('#roleModalLabel').html('Add Role');
        $('label[class="error"]').remove();
        $("#Roleform").removeClass("was-validated");
        $('select').removeClass('error');
    });
    $('form[id="Roleform"]').validate({
        rules: {
          name: 'required',

        },
        messages: {
          name: 'Role is required',

        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/role/add',
                data: $('#Roleform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#hid').val('');
                        $('#name').val('');
                        $('#roleModal').modal('hide');
                        Readdata();
                    } else if (data.status == 0) {
                        printErrorMsg(data.error)
                    }
                    else {
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

function Readdata() {
    $('#role-table').DataTable({

        processing: true,

        "bDestroy": true,
        "bAutoWidth": false,


        serverSide: true,

        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/role/datatable',
            data: {
                "_token": $("[name='_token']").val(),

            },

        },

        columns: [

            { data: 'id', name: 'id' },

            { data: 'name', name: 'name' },

            { data: 'status', name: 'status' },

            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]

    });
    // $('#role-table').dataTable({
    //     "paging": true,
    //     "pageLength": 10,
    //     "bProcessing": true,
    //     "serverSide": true,
    //     "bDestroy": true,
    //     "ajax": {
    //         type: 'POST',
    //         url: BASE_URL + '/' + ADMIN + '/read-role',
    //         data: {
    //             "_token": $("[name='_token']").val(),

    //         },

    //     },
    //     "aoColumns": [
    //         { mData: 'id' },
    //         { mData: 'name' },
    //         { mData: 'action' },



    //     ],
    //     "order": [[0, "ASC"]],

    //     "columnDefs": [{
    //         "targets": [2],
    //         "orderable": false
    //     }]
    // });
}

function delete_role(id) {
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
                url: BASE_URL + '/' + ADMIN + '/role/delete',
                type: 'POST',
                data: {
                    'id': id,
                    "_token": $("[name='_token']").val(),
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    console.log(response);
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
                    Readdata();
                }
            });
        }
    });



}
function edit_role(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/role/edit',
        type: 'POST',
        data: {
            "_token": $("[name='_token']").val(),
            'id': id,
        },
        success: function (responce) {
            $('#hid').val();
            var data = JSON.parse(responce);
            console.log(data);
            if (data.status == 1) {
                var result = data.user;
                $('#roleModal').modal('show');
                $('#submitbtn').html('Update');
                $('#roleModalLabel').html('Update Role');
                $('#hid').val(result.id);
                $('#name').val(result.name);
                $('select[name="status"]').val(result.status).trigger("change");
            }

        }

    });

}
