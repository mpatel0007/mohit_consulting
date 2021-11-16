$(document).ready(function () {
  $(".file1").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
  $(".file2").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
  
  $('form[id="settingform"]').validate({


    rules: {
      headerlogo:  {
            required : $("#hid").val().length <= 0
      },
      footerlogo:  {
            required : $("#hid").val().length <= 0
      },
      infoaddress: 'required',
      infoemail: {
        required: true,
        email: true,
      }, 
      inquiryemail: {
        required: true,
        email: true,
      },
      infocontactnumber: 'required',
      footerdiscription: 'required',
      facebook: 'required',
      twitter: 'required',
      linkedin: 'required',
      google: 'required',
      copyright: 'required',

    },

    messages: {
      headerlogo: 'Header Logo is required',
      footerlogo: 'Footer Logo is required',
      infoaddress: 'Info Address is required',

      infoemail: {
        required: 'Info Email is required',
        email: 'Enter a valid email',
      },

      inquiryemail: {
        required: 'Inquiry Email is required',
        email: 'Enter a valid email',
      },

      infocontactnumber: 'Info Contact Number is required',
      footerdiscription: 'Footer Discription is required',
      facebook: 'Facebook Name is required',
      twitter: 'Twitter is required',
      linkedin: 'Linkedin is required',
      google: 'Google is required',
      copyright: 'Copyright Discription is required',


    },
    submitHandler: function (form) {

        // alert('h');
        var formdata = new FormData($('#settingform')[0]);

        $.ajax({
          url: BASE_URL + '/' + ADMIN + '/setting/add',
          type: 'post',
          contentType: false,
          cache: false,
          DataType:JSON,
          processData: false,
          data:formdata,
          success:function(responce) {
            console.log(responce);
            var data = JSON.parse(responce);


            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                title: data.msg,
                showConfirmButton: true,
              });
              // $('#headerlogo').val(null);
              // $('#footerlogo').val(null);
              // document.getElementById("footerlogo").value = null;
              // $('#settingform')[0].reset();


    //           $('#hid').val(data.id);
    //           // function(){
    //  var hid = $('#hid').val();
    //  if(hid>0){
    //   window.location = BASE_URL + '/' + ADMIN + '/setting/fillup/'+ hid;


    //  }

              // };
              $('label[class="error"]').remove();
              $(".print-error-msg").hide();
            } else if (data.status == 0) {
              printErrorMsg(data.error)
            } else {
              Swal.fire({
                icon: 'error',
                title: data.msg,
                showConfirmButton: true,
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