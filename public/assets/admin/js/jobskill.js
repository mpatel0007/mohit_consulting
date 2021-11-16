$(document).ready(function () {
    $('#JobskillModal').on('hidden.bs.modal', function () {
        $('#jobskillform')[0].reset();
        $('.print-error-msg').hide();
        $('.modal-title').html('Add Job Skill');
        $('label[class="error"]').remove();
        // $("#jobskillform").removeClass("was-validated");
        // $('select').removeClass('error');


    });
    $("#openModal").on('click', function () {
        $('#JobskillModal').modal('show');
    });
    jobskilldata();
    $('form[id="jobskillform"]').validate({
        rules: {
          jobskill: 'required',

        },
        messages: {
          jobskill: 'job skill is required',

        },
        submitHandler: function(form) {
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/jobskill/add',
                type: 'post',
                data: $('#jobskillform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
    
                        })
                        $('#JobskillModal').modal('hide');
                        $('#hid').val('');
                        $('#Jobskill').val('');
                        // $('#status').val('');
                        jobskilldata();
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

function jobskilldata() {
    $('#jobskill_datatable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,

        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/jobskill/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'jobskill', name: 'jobskill' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}


function delete_jobskill(id) {
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
                url: BASE_URL + '/' + ADMIN + '/jobskill/delete',
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
                        jobskilldata();
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

function edit_jobskill(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/jobskill/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#JobskillModal').modal('show');
            $('#addjobskill').html('Update');
            $('.modal-title').html('Update Job Skill');


            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.jobskill;
                $('#hid').val(result.id);
                $('#jobskill').val(result.jobskill);
                $('#status').val(result.status);
            }
        }
    });
}

