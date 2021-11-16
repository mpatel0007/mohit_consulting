$(document).ready(function () {
    $('form[id="contactForm"]').validate({
        rules: {
            name: 'required',
            email: {
                required: true,
                email: true
              },
            msg_subject: 'required',
            message: 'required',
        },
        messages: {
            name: 'Name is required',
            email: {
                required:'Email is required',
                email:'Please enter valid email address'

            },
            msg_subject: 'Subject is required',
            message: 'Message is required',

        },
        submitHandler: function (form) {
            $("#loader").addClass('emailloader');
            $.ajax({
                url: BASE_URL + '/contact/send',
                type: 'post',
                data: $('#contactForm').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    console.log(data)
                    if (data.status == 1) {
                        $("#loader").removeClass('emailloader');
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#contactForm').trigger("reset");
                        $(".print-error-msg").hide();

                    } else if (data.status == 0) {
                        $("#loader").removeClass('emailloader');
                        printErrorMsg(data.error)
                    } else {
                        $("#loader").removeClass('emailloader');
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
