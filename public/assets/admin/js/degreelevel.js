$(document).ready(function () {
    $('#degreelevelModal').on('hidden.bs.modal', function () {
        $('#degreelevelform')[0].reset();
        $('.print-error-msg').hide();
        $("#degreelevelform").removeClass("was-validated");
        $('.modal-title').html('Add Degree Level');
        $('label[class="error"]').remove();


    });
    $("#openModal").on('click', function () {
        $('#degreelevelModal').modal('show');
    });
    degreeleveldata();
    $('form[id="degreelevelform"]').validate({
        rules: {
        degreelevel: 'required',
        },
        messages: {
        degreelevel: 'Degree level is required.',
        },
        submitHandler: function(form){
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/degreelevel/add',
                type: 'post',
                data: $('#degreelevelform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#degreelevelModal').modal('hide');
                        $('#hid').val('');
                        $('#degreelevel').val('');
                        // $('#status').val('');
    
                        degreeleveldata();
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

function degreeleveldata() {
    $('#degreelevel_datatable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/degreelevel/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'degreelevel', name: 'degreelevel' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

function delete_degreelevel(id) {
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
                url: BASE_URL + '/' + ADMIN + '/degreelevel/delete',
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
                        degreeleveldata();
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

function edit_degreelevel(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/degreelevel/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#degreelevelModal').modal('show');
            $('#adddegreelevel').html('Update');
            $('.modal-title').html('Update Degree level');
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.degreelevel;
                $('#hid').val(result.id);
                $('#degreelevel').val(result.degreelevel);
                $('#status').val(result.status);
            }
        }
    });
}


