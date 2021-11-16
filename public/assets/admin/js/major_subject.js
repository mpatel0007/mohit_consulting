$(document).ready(function () {
    Readdata();
    $('#majorsubjectmodelbutton').click(function () {
        $('#major_subjectModal').modal('show');

    });
    $('#major_subjectModal').on('hidden.bs.modal', function () {
        $('#major_subjectform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('.print-error-msg').hide();
        $('#major_subjectModalLabel').html('Add Major subject');
        $('label[class="error"]').remove();
        $("#major_subjectform").removeClass("was-validated");
        $('select').removeClass('error');
    });
    $('form[id="major_subjectform"]').validate({
        rules: {
          major_subject: 'required',
        },
        messages: {
          major_subject: 'Major Subject is required',
        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/major_subject/add',
                data: $('#major_subjectform').serialize(),
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
                        $('#major_subject').val('');
                        $('#major_subjectModal').modal('hide');
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
    $('#major_subject-table').DataTable({

        processing: true,

        "bDestroy": true,
        "bAutoWidth": false,


        serverSide: true,

        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/major_subject/datatable',
            data: {
                "_token": $("[name='_token']").val(),

            },

        },

        columns: [

            { data: 'id', name: 'id' },

            { data: 'major_subject', name: 'major_subject' },

            { data: 'status', name: 'status' },

            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]

    });

}

function delete_major_subject(id) {
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
                url: BASE_URL + '/' + ADMIN + '/major_subject/delete',
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
function edit_major_subject(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/major_subject/edit',
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
                $('#major_subjectModal').modal('show');
                $('#submitbtn').html('Update');
                $('#major_subjectModalLabel').html('Update Major subject');
                $('#hid').val(result.id);
                $('#major_subject').val(result.major_subject);
                $('select[name="status"]').val(result.status).trigger("change");
            }

        }

    });

}
