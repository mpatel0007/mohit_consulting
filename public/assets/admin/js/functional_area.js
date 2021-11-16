$(document).ready(function () {
    Readdata();
    $('#functional_areamodelbutton').click(function () {
        $('#functional_areaModal').modal('show');
    });
    $('#functional_areaModal').on('hidden.bs.modal', function () {
        $('#functional_areaform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('#functional_areaModalLabel').html('Add Category');
        $('.print-error-msg').hide();
        $("#functional_areaform").removeClass("was-validated");
        $('label[class="error"]').remove();

    });
    $('form[id="functional_areaform"]').validate({
        rules: {
          functional_area: 'required',
        },
        messages: {
          functional_area: 'Category is required',

        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/functional_area/add',
                data: $('#functional_areaform').serialize(),
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
                        $('#functional_area').val('');
                        $('#functional_areaModal').modal('hide');
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
    $('#functional_area-table').DataTable({

        processing: true,

        "bDestroy": true,

        serverSide: true,
        "bAutoWidth": false,


        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/functional_area/datatable',
            data: {
                "_token": $("[name='_token']").val(),

            },

        },

        columns: [

            { data: 'id', name: 'id' },

            { data: 'functional_area', name: 'Functional_area' },

            { data: 'status', name: 'status' },

            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]

    });

}

function delete_functional_area(id) {
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
                url: BASE_URL + '/' + ADMIN + '/functional_area/delete',
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
function edit_functional_area(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/functional_area/edit',
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
                console.log(result);
                $('#functional_areaModal').modal('show');
                $('#submitbtn').html('Update');
                $('#functional_areaModalLabel').html('Update Category');
                $('#hid').val(result.id);
                $('#functional_area').val(result.functional_area);
                $('select[name="status"]').val(result.status).trigger("change");
                $('select[name="category"]').val(result.industry_id).trigger("change");
            }

        }

    });

}
