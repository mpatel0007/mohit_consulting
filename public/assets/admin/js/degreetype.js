$(document).ready(function () {
    $('#degreetypeModal').on('hidden.bs.modal', function () {
        $('#adddegreetype').html('Add');
        $('#degreetypeform').trigger("reset");
        $('.print-error-msg').hide();
        $('.modal-title').html('Add Degree Type');
        $('label[class="error"]').remove();
        $("#degreetypeform").removeClass("was-validated");
        $('select').removeClass('error');


    });
    $("#openModal").on('click', function () {
        $('#degreetypeModal').modal('show');
    });
    degreetypedata();
    $('form[id="degreetypeform"]').validate({
        rules: {
          degreelevel: 'required',
          degreetype: 'required',
        },
        messages: {
          degreelevel: 'Degree level is required',
          degreetype: 'Degree type is required',

        },
        submitHandler: function(form) {
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/degreetype/add',
                type: 'post',
                data: $('#degreetypeform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#degreetypeModal').modal('hide');
                        $('#hid').val('');
                        $('#degreetype').val('');
                        // $('#status').val('');
                        degreetypedata();
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

function degreetypedata() {
    $('#degreeType_datatable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/degreetype/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'degreelevel', name: 'degreelevel.degreelevel' },
            { data: 'degreetype', name: 'degreetype.degreetype' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

function delete_degreetype(id) {
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
                url: BASE_URL + '/' + ADMIN + '/degreetype/delete',
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
                        degreetypedata();
                    } else {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'error'
                        )
                    }
                }
            });
        }
    })
}

function edit_degreetype(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/degreetype/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#degreetypeModal').modal('show');
            $('#adddegreetype').html('Update');

            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.degreetype;
                $('#hid').val(result.id);
                $('.modal-title').html('Update Degree Type');
                $('#degreelevel').val(result.degreelevel_id);
                $('#degreetype').val(result.degreetype);
                $('#status').val(result.status);
            }
        }
    });
}

