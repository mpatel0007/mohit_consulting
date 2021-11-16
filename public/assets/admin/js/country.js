$(document).ready(function () {
    Readdata();
    $('#countrymodelbutton').click(function () {
        $('#countryModal').modal('show');

    });
    $('#countryModal').on('hidden.bs.modal', function () {
        $('#countryform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('.print-error-msg').hide();
        $('#countryModalLabel').html('Add Country');
        $('label[class="error"]').remove();
        $("#countryform").removeClass("was-validated");
        $('select').removeClass('error');
    });
    $('form[id="countryform"]').validate({
        rules: {
          country_name: 'required',
          sort_name: 'required',
        //   phone_code: 'required',
          currency: 'required',
        //   code: 'required',
        //   symbol: 'required',

      
        },
        messages: {
          country_name: 'Country Name is required',
          sort_name: 'Sort Name is required',
        //   phone_code: 'Phone code is required',
          currency: 'Currency is required',
        //   code: 'Code is required',
        //   symbol: 'Symbol is required',


        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/country/add',
                data: $('#countryform').serialize(),
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
                        $('#countryModal').modal('hide');
    
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
    $('#country-table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/country/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'country_name', name: 'country_name' },
            { data: 'sort_name', name: 'sort_name' },
            // { data: 'phone_code', name: 'phone_code' },
            { data: 'currency', name: 'currency' },
            // { data: 'code', name: 'code' },
            // { data: 'symbol', name: 'symbol' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}
function delete_country(id) {
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
                url: BASE_URL + '/' + ADMIN + '/country/delete',
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
function edit_country(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/country/edit',
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
                $('#countryModal').modal('show');
                $('#submitbtn').html('Update');
                $('#faqsModalLabel').html('Update Country');
                $('#hid').val(result.id);
                $('#country_name').val(result.country_name);
                $('#sort_name').val(result.sort_name);
                $('#phone_code').val(result.phone_code);
                $('#currency').val(result.currency);
                $('#code').val(result.code);
                $('#symbol').val(result.symbol);
                $('select[name="status"]').val(result.status).trigger("change");
                // alert(id);
            }
        }


    });
}