$(document).ready(function () {
    $('#CareerevelModal').on('hidden.bs.modal', function () {
        $('#career_levelForm')[0].reset();
        $('.print-error-msg').hide();
        $('.modal-title').html('Add Job Skill');
        $('label[class="error"]').remove();
    });
    $("#openModal").on('click', function () {
        $('#CareerevelModal').modal('show');
    });
    career_leveldata();
    $('form[id="career_levelForm"]').validate({
        rules: {
          career_level: 'required',
        },
        messages: {
          career_level: 'Career level is required',
        },
        submitHandler: function(form) {
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/careerlevel/add',
                type: 'post',
                data: $('#career_levelForm').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
    
                        })
                        $('#CareerevelModal').modal('hide');
                        $('#hid').val('');
                        $('#Jobskill').val('');
                        // $('#status').val('');
                        career_leveldata();
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

function career_leveldata() {
    $('#career_level_datatable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,

        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/careerlevel/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'careerlevel', name: 'careerlevel' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}


function delete_careerlevel(id) {
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
                url: BASE_URL + '/' + ADMIN + '/careerlevel/delete',
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
                        career_leveldata();
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

function edit_careerlevel(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/careerlevel/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#CareerevelModal').modal('show');
            $('#addcareer_level').html('Update');
            $('.modal-title').html('Update Job Skill');


            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.careerlevel;
                $('#hid').val(result.id);
                $('#career_level').val(result.careerlevel);
                $('#status').val(result.status);
            }
        }
    });
}

