$(document).ready(function () {
    $("#city").select2();
    $("#industry").select2();
    $('#subCategory').select2();

    //  $("#degreelevel").select2(); 

    $('form[id="CompanyProfile"]').validate({
        ignore: [],
        debug: false,
        rules: {
            companyname: 'required',
            industry: 'required',
            subCategory: 'required',
            companydetail: {
                required: function () {
                    CKEDITOR.instances.companydetail.updateElement();
                },
            },
            country: 'required',
            state: 'required',
            city: 'required',
        },
        messages: {
            companyname: 'Company Name is required',
            industry: 'Industry is required',
            companydetail: {
                required: "Company Details is required",
            },
            // companyemail: {
            //     required: 'Email is required',
            //     email: 'Enter a valid email',
            //     remote: 'That email address is already registered.'
            // },
            // password: {
            //     password: 'password is required',
            //     minlength: 'password must be at least 6 characters long'
            // },
            country: 'country is required',
            state: 'state is required',
            city: 'city Name is required',
            subCategory: 'sub Category is required',
        },
        submitHandler: function (form) {
            for (var i in CKEDITOR.instances) {
                CKEDITOR.instances[i].updateElement();
            };
            var formdata = new FormData($('#CompanyProfile')[0]);
            $.ajax({
                url: BASE_URL + '/employers/companyprofile/proccess',
                type: 'post',
                contentType: false,
                cache: false,
                processData: false,
                data: formdata,
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: true,
                        }).then(function () {
                            window.location = BASE_URL + '/manage/job';
                        });
                        $('#CompanyProfile').trigger("reset");
                        $("#CompanyProfile").removeClass("was-validated");
                        $('label[class="error"]').remove();
                        $('select').removeClass('error');
                        CKEDITOR.instances.companydetail.setData('');
                        companylistdata();
                    } else if (data.status == 0) {
                        printErrorMsg(data.error)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            showConfirmButton: true,
                            timer: 1500
                        }).then(function () {
                            window.location = BASE_URL + '/manage/job';
                        });
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

$('#country').on('change', function () {
    var country = $(this).val();
    $.ajax({
        url: BASE_URL + '/city/getcountrystate',
        // url: BASE_URL + '/' + ADMIN + '/city/getcountrystate',
        type: 'post',
        data: {
            country: country,
            "_token": $("[name='_token']").val(),
        },

        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                $('#state').html('');
                var result = data.list;
                $('#state').html(result);
            }
        }
    });
});

$('#state').on('change', function () {
    var state = $(this).val();
    $.ajax({
        url: BASE_URL + '/city/getstatecity',
        // url: BASE_URL + '/' + ADMIN + '/city/getstatecity',
        type: 'post',
        data: {
            state: state,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                $('#city').html('');
                var result = data.list;
                $('#city').html(result);
            }
        }
    });
});

$(document).ready(function(){
    $('#industry').on('select2:select', function (e) {
    var industry = $(this).val();  
    $.ajax({
      url: BASE_URL + '/categories/subcategories',
      type: 'post',
      data: {
        industry: industry,
        "_token": $("[name='_token']").val(),
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          $('#subCategory').html('');
          var result = data.list;
          $('#subCategory').html(result);
        }
      }
    });
  });
});  