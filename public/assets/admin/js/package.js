$(document).ready(function () {
    Readdata();
    $('#packagemodelbutton').click(function () {
        $('#packageModal').modal('show');

    });
    $('#packageModal').on('hidden.bs.modal', function () {
        $('#packageform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('.print-error-msg').hide();
        $('#packageModalLabel').html('Add Package');
        $('label[class="error"]').remove();
        $("#packageform").removeClass("was-validated");
        $('select').removeClass('error');
    });
    $('form[id="packageform"]').validate({
        rules: {
            package_title: 'required',
            package_price: 'required',
            package_num_days: 'required',
            //package_num_listings: 'required',
            package_for: 'required',

        },
        messages: {
            package_title: 'Package Title is required',
            package_price: 'Package Price is required',
            package_num_days: 'Package Num Days is required',
            //package_num_listings: 'Package Num Listings is required',
            package_for: 'Package For is required',



        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/package/add',
                data: $('#packageform').serialize(),
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
                        $('#packageModal').modal('hide');
                        $('#package_title').val('');
                        $('#package_price').val('');
                        $('#package_num_days').val('');
                        $('#package_num_listings').val('');
    
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
    $('#package-table').DataTable({
        processing: true,
        "bDestroy": true,
        "bAutoWidth": false,
        serverSide: true,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/package/datatable',
            data: {
                "_token": $("[name='_token']").val(),

            },

        },

        columns: [

            { data: 'id', name: 'id' },
            { data: 'package_title', name: 'package_title' },
            { data: 'package_price', name: 'package_price' },
            { data: 'package_num_days', name: 'package_num_days' },
            //{ data: 'package_num_listings', name: 'package_num_listings' },
            { data: 'package_for', name: 'package_for' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]

    });

}

function delete_package(id) {
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
                url: BASE_URL + '/' + ADMIN + '/package/delete',
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
function edit_package(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/package/edit',
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
                $('#packageModal').modal('show');
                $('#submitbtn').html('Update');
                $('#packageModalLabel').html('Update Package');
                $('#hid').val(result.id);
                $('#package_title').val(result.package_title);
                $('#package_price').val(result.package_price);
                $('#package_num_days').val(result.package_num_days);
                $('#package_num_listings').val(result.package_num_listings);
                $('select[name="package_for"]').val(result.package_for).trigger("change");
                $('select[name="status"]').val(result.status).trigger("change");
            }

        }

    });

}
