$(document).ready(function () {
    Readdata();
    $('#statemodelbutton').click(function () {
        $('#stateModal').modal('show');

    });
    $('#stateModal').on('hidden.bs.modal', function () {
        $('#stateform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('.print-error-msg').hide();
        $('#stateModalLabel').html('Add State');
        $('label[class="error"]').remove();
        $("#stateform").removeClass("was-validated");
        $('select').removeClass('error');
    });
    $('form[id="stateform"]').validate({
        rules: {
          country: 'required',
          state_name: 'required',

        },
        messages: {
          country: 'Country is required',
          state_name: 'State Name is required',

        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/state/add',
                data: $('#stateform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Readdata();
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#hid').val('');
                        $('#stateModal').modal('hide');
                        $('#state_name').val('');
    
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
function Readdata() {
    $('#state-table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,

        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/state/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'country_name', name: 'country.country_name' },
            { data: 'state_name', name: 'state.state_name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}
function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}
function delete_state(id) {
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
                url: BASE_URL + '/' + ADMIN + '/state/delete',
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
    })
}
function edit_state(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/state/edit',
        type: 'POST',
        data: {
            "_token": $("[name='_token']").val(),
            'id': id,
        },
        success: function (responce) {
            $('#hid').val();
            var data = JSON.parse(responce);
            if (data.status == 1) {
                var result = data.user;
                console.log(result);
                $('#stateModal').modal('show');
                $('#submitbtn').html('Update');
                $('#stateModalLabel').html('Update State');
                $('#hid').val(result.id);
                $('select[name="country"]').val(result.country_id).trigger("change");
                $('#state_name').val(result.state_name);
                $('select[name="status"]').val(result.status).trigger("change");
            }
        }


    });
}