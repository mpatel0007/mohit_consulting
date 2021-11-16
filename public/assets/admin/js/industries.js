$(document).ready(function () {
    Readdata();
    $('#industriesmodelbutton').click(function () {
        $('#industriesModal').modal('show');

    });
    $('#industriesModal').on('hidden.bs.modal', function () {
        $('#industriesform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('#industriesModalLabel').html('Add Industry');
        // $("input[name=is_default]").removeAttr("checked");
        $('.print-error-msg').hide();
        $('label[class="error"]').remove();
        $("#industriesform").removeClass("was-validated");
        $('select').removeClass('error');

    });
    $('form[id="industriesform"]').validate({
        rules: {
          industry_name: 'required',
        //   is_default: 'required',

        },
        messages: {
          industry_name: 'Industry Nameis required',
        //   is_default: 'Is Default is required',

        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/industries/add',
                data: $('#industriesform').serialize(),
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
                        $('#industry_name').val('');
                        $('#industriesModal').modal('hide');
                        // $("input[name=is_default]").removeAttr("checked");
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
    $('#industries-table').DataTable({

        processing: true,
        "bAutoWidth": false,

        "bDestroy": true,

        serverSide: true,

        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/industries/datatable',
            data: {
                "_token": $("[name='_token']").val(),

            },

        },

        columns: [

            { data: 'id', name: 'id' },

            { data: 'industry_name', name: 'industry_name' },

            { data: 'is_default', name: 'is_default' },

            { data: 'status', name: 'status' },

            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]

    });
}
function delete_industries(id) {
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
                url: BASE_URL + '/' + ADMIN + '/industries/delete',
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
function edit_industries(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/industries/edit',
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
                $('#industriesModal').modal('show');
                $('#submitbtn').html('Update');
                $('#industriesModalLabel').html('Update Industry');
                $('#hid').val(result.id);
                $('#industry_name').val(result.industry_name);
                // alert(result.is_default);
                // $('#default' + result.is_default).attr('checked', true);
                $('#default' + result.is_default)[0].checked = true;

                $('select[name="status"]').val(result.status).trigger("change");
            }

        }

    });

}