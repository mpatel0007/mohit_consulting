$(document).ready(function () {
    Readdata();
    $('#testimonialmodelbutton').click(function () {
        $('#testimonialModal').modal('show');

    });
    $('#testimonialModal').on('hidden.bs.modal', function () {
        $('#Testimonialform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('#testimonialModalLabel').html('Add Testimonial');
        // $("input[name=is_default]").removeAttr("checked");
        $('.print-error-msg').hide();
        $('label[class="error"]').remove();
        $("#Testimonialform").removeClass("was-validated");
        $('select').removeClass('error');


    });
    $('form[id="Testimonialform"]').validate({
        rules: {
            testimonial_by: 'required',
            testimonial: 'required',
            company_and_designation: 'required',
            is_default: 'required',

 
        },
        messages: {
            testimonial_by: 'Testimonial by is required',
            testimonial: 'Testimonial is required',
            company_and_designation: 'Company And Designation is required',
            is_default: 'is Default is required',


        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/testimonial/add',
                data: $('#Testimonialform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    console.log(data);
                    if (data.status == 1) {
                        Readdata();
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#hid').val('');
                        $('#testimonial_by').val('');
                        $('#testimonial').val('');
                        $('#company_and_designation').val('');
                        // $("input[name=is_default]").removeAttr("checked");
                        $('#testimonialModal').modal('hide');
    
    
    
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
    $('#testimonial-table').DataTable({

        processing: true,

        "bDestroy": true,

        serverSide: true,
        "bAutoWidth": false,


        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/testimonial/datatable',
            data: {
                "_token": $("[name='_token']").val(),

            },

        },

        columns: [

            { data: 'id', name: 'id' },

            { data: 'testimonial_by', name: 'testimonial_by' },

            { data: 'testimonial', name: 'testimonial' },

            { data: 'company_and_designation', name: 'company_and_designation' },

            { data: 'is_default', name: 'is_default' },

            { data: 'status', name: 'status' },

            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]

    });

}

function delete_testimonial(id) {
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
                url: BASE_URL + '/' + ADMIN + '/testimonial/delete',
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

function edit_testimonial(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/testimonial/edit',
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
                $('#testimonialModal').modal('show');
                $('#submitbtn').html('Update');
                $('#testimonialModalLabel').html('Update testimonial');
                $('#hid').val(result.id);
                $('#testimonial_by').val(result.testimonial_by);
                $('#testimonial').val(result.testimonial);
                $('#company_and_designation').val(result.company_and_designation);
                $('#default' + result.is_default)[0].checked = true;
                $('select[name="status"]').val(result.status).trigger("change");
                
            }
        }


    });
}