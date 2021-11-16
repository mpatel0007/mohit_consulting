$(document).ready(function () {
    $('#salaryModal').on('hidden.bs.modal', function () {
        $('#salaryform')[0].reset();
        $('.print-error-msg').hide();
        $("#salaryform").removeClass("was-validated");
        $('.modal-title').html('Add Salary Level');
        $('label[class="error"]').remove();


    });
    $("#openModal").on('click', function () {
        $('#salaryModal').modal('show');
    });
    salarydata();
    $('form[id="salaryform"]').validate({
        rules: {
        salary: 'required',
        },
        messages: {
        salary: 'Salary is required.',
        },
        submitHandler: function(form){
            // $('#addsalary').attr('disabled','disabled');
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/salary/add',
                type: 'post',
                data: $('#salaryform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        // $('#addsalary').removeAttr('disabled'); 
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#salaryModal').modal('hide');
                        $('#hid').val('');
                        $('#salary').val('');
                        salarydata();
                    } else if (data.status == 0) {
                        printErrorMsg(data.error)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
            // $('#addsalary').removeAttr('disabled');
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

function salarydata() {
    $('#salary_datatable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/salary/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'salary', name: 'salary' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

function delete_salary(id) {
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
                url: BASE_URL + '/' + ADMIN + '/salary/delete',
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
                        salarydata();
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

function edit_salary(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/salary/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#salaryModal').modal('show');
            $('#addsalary').html('Update');
            $('.modal-title').html('Update Salary level');
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.salary;
                $('#hid').val(result.id);
                $('#salary').val(result.salary);
                $('#status').val(result.status);
            }
        }
    });
}


