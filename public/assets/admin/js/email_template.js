$(document).ready(function () {
    $('#Email_template_Modal').on('hidden.bs.modal', function () {
        $('#Email_template_form')[0].reset();
        $('.print-error-msg').hide();
        $('label[class="error"]').remove();
        CKEDITOR.instances.description.setData('');
    });
    $("#openModal").on('click', function () {
        $('#Email_template_Modal').modal('show');
    });
    Template_datatable();
    $('form[id="Email_template_form"]').validate({
        rules: {
          title: 'required',
          subject : 'required',
          description : {                         
            required: true,
           }
        },
        messages: {
          title: 'Template title is required',
          subject: 'Template subject is required',
          description : 'Template description is required'
        }, 
        submitHandler: function(form) {
            $("#loader").addClass('loader');
            CKEDITOR.instances.description.updateElement();
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/emailtemplate/add',
                type: 'post',
                data: $('#Email_template_form').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) { 
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#Email_template_Modal').modal('hide');
                        $('#hid').val('');
                        $('#Email_template_form')[0].reset();
                        CKEDITOR.instances.description.setData('');
                        $("#loader").removeClass('loader');
                        Template_datatable();
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
            // $("#loader").removeClass('loader');
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
function Template_datatable() {
    $('#email_template_datatable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type : 'POST',
            url  : BASE_URL + '/' + ADMIN + '/emailtemplate/datatable',
            data : {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'title', name: 'title' },
            { data: 'subject', name: 'subject' },
            // { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

function edit_emailtemplate(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/emailtemplate/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#Email_template_Modal').modal('show');
            $('.modal-title').html('Update Email Template');
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.emailtemplate;
                $('#hid').val(result.id);
                $('#title').val(result.title);
                $('#subject').val(result.subject);
                CKEDITOR.instances.description.setData(result.description);
            }
        }
    });
}