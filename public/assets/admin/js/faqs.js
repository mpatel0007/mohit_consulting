$(document).ready(function () {
    Readdata();
   
    $('#faqsmodelbutton').click(function () {
        $('#faqsModal').modal('show');

    });
    $('#faqsModal').on('hidden.bs.modal', function () {
        $('#faqsform')[0].reset();
        $('#submitbtn').html('Add');
        $('#hid').val('');
        $('#faqsModalLabel').html('Add Faqs');
        // CKEDITOR.instances.questioneditor.setData(null);
        // CKEDITOR.instances.answereditor.setData(null);
        $('.print-error-msg').hide();
        $('label[class="error"]').remove();
        $("#faqsform").removeClass("was-validated");
        $('select').removeClass('error');



    });
    $('form[id="faqsform"]').validate({
        rules: {
          questioneditor: 'required',
          answereditor: 'required',

        },
        messages: {
          questioneditor: 'Questions is required',
          answereditor: 'Answers is required',

        },
        invalidHandler: function(form, validator) {
            
            $("#faqsform").removeClass("was-validated");
        },
        submitHandler: function(form) {
            
          

      
        
                    // for (var i in CKEDITOR.instances) {
        //     CKEDITOR.instances[i].updateElement();
        // };
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/' + ADMIN + '/faqs/add',
                data: $('#faqsform').serialize(),
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
                        $('#questioneditor').val('');
                        $('#answereditor').val('');
                        // CKEDITOR.instances.questioneditor.setData(null);
                        // CKEDITOR.instances.answereditor.setData(null);
                        $('#faqsModal').modal('hide');
                        
    
                    } else if (data.status == 0) {
                        printErrorMsg(data.error)
    
    
                    } else {
                        Swal.fire({
                            icon: 'success',
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
    // CKEDITOR.config.autoParagraph = false;
    $('#faqs-table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/faqs/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'questioneditor', name: 'questioneditor' },
            { data: 'answereditor', name: 'answereditor' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}
function delete_faqs(id) {
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
                url: BASE_URL + '/' + ADMIN + '/faqs/delete',
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
function edit_faqs(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/faqs/edit',
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
                $('#faqsModal').modal('show');
                $('#submitbtn').html('Update');
                $('#faqsModalLabel').html('Update Faqs');
                $('#hid').val(result.id);
                // CKEDITOR.instances.questioneditor.setData(result.questioneditor);
                // CKEDITOR.instances.answereditor.setData(result.answereditor);
                $('#questioneditor').val(result.questioneditor);
                $('#answereditor').val(result.answereditor);
                $('select[name="status"]').val(result.status).trigger("change");
                // alert(id);
            }
        }


    });
}