$(document).ready(function () {
    Readdata();
    $('#citymodelbutton').click(function () {
        $('#cityModal').modal('show');

    });
    $('#country').on("change", function () {
        var country_id = $(this).val();
        getCountryState(country_id);
    });
    $('#cityModal').on('hidden.bs.modal', function () {
        $('#cityform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('.print-error-msg').hide();
        $('#statelist').html('<select class="form-control" name="state" id="state"><option selected="" disabled="" >select state</option>');
        $('#cityModalLabel').html('Add City');
        $('label[class="error"]').remove();
        $("#cityform").removeClass("was-validated");
        $('select').removeClass('error');

    });
    $('form[id="cityform"]').validate({
        rules: {
          country: 'required',
          state: 'required',
          city_name: 'required',
        },
        messages: {
         country: 'Country is required',
         state: 'State is required',
         city_name: 'City is required',
        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/city/add',
                data: $('#cityform').serialize(),
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
                        $('#cityModal').modal('hide');
                        $('#city_name').val('');
                        $('#cityform')[0].reset();
    
    
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
function getCountryState(country_id, state_id) {
    $.ajax({
        // url: BASE_URL + '/' + ADMIN + '/city/getcountrystate',
        url: BASE_URL +  '/city/getcountrystate',
        type: "POST",
        data: {
            "_token": $("[name='_token']").val(),
            "country": country_id,
            "state": state_id,
        },
        success: function (responce) {
            var data = JSON.parse(responce);
            $('#statelist').html('');
            if (data.status == 1) {
                var result = data.list;
                $('#statelist').html(result);
            }
        }

    });
}
function Readdata() {
    $('#city-table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/city/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'id', name: 'city.id' },
            { data: 'state_name', name: 'state.state_name' },
            { data: 'city_name', name: 'city.city_name' },
            { data: 'status', name: 'city.status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}
function delete_city(id) {
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
                url: BASE_URL + '/' + ADMIN + '/city/delete',
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
function edit_city(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/city/edit',
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
                $('#submitbtn').html('Update');
                $('#cityModalLabel').html('Update City');
                $('#hid').val(result.id);
                $('#city_name').val(result.city_name);
                $('select[name="status"]').val(result.status).trigger("change");
                $('select[name="country"]').val(result.country_id).trigger("change");
                // $('select[name="state"]').val(result.state_id).trigger("change");
                getCountryState(result.country_id, result.state_id);
                $('#cityModal').modal('show');

                // alert(id);
            }
        }


    });
}
