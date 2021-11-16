$(document).ready(function () {
  $('#copper_modal').on('hidden.bs.modal', function () {
    canvas.cropper("destroy");
  });
});
$("#copper_modal").modal("hide");
var canvas = $("#canvas"),
  context = canvas.get(0).getContext("2d"),
  $result = $('#result');

$('#file-input').on('change', function () {
  var a = (this.files[0].size);
  if (a > 2000000) {
    Swal.fire(
      'error!',
      'Image size must be less than 2 MB',
      'error'
    )
    return false;
  };
  $("#preloader").show();
  $('#copper_modal').modal("show");

  setTimeout(function () {


    if (this.files && this.files[0]) {
      if (this.files[0].type.match(/^image\//)) {
        var reader = new FileReader();
        reader.onload = function (evt) {
          var img = new Image();
          img.onload = function () {
            $("#preloader").hide();
            context.canvas.height = img.height;
            context.canvas.width = img.width;
            context.drawImage(img, 0, 0);
            var cropper = canvas.cropper({
              aspectRatio: 16 / 9
            });
            $('#btnCrop').click(function () {
              $("#preloader").show();
              // Get a string base 64 data url
              $("#copper_modal").modal("hide");
              var croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png");
              $result.append($('<img>').attr('src', croppedImageDataURL));
              if (croppedImageDataURL != '' && croppedImageDataURL != null) {
                $.ajax({
                  url: BASE_URL + '/employers/manageprofile/upload/image',
                  type: 'POST',
                  data: {
                    'croppedImageDataURL': croppedImageDataURL,
                    "_token": $("[name='_token']").val()
                  },
                  success: function (responce) {
                    $("#preloader").hide();
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                      Swal.fire(
                        'Upload!',
                        data.msg,
                        'success'
                      )
                      $('#edit_img').attr("src",croppedImageDataURL);
                      // window.location = BASE_URL + '/employers/companyprofile';
                    } else if (data.status == 0) {
                      $("#preloader").hide();
                      printErrorMsg(data.error)
                    } else {
                      $("#preloader").hide();
                      Swal.fire(
                        'Upload!',
                        data.msg,
                        'error'
                      )
                    }
                  }
                });
              }
            });
            $('#btnRestore').click(function () {
              canvas.cropper('reset');
              $result.empty();
            });
          };
          img.src = evt.target.result;
        };
        reader.readAsDataURL(this.files[0]);

      } else {
        $("#preloader").hide();
        Swal.fire(
          'error!',
          "Invalid file type! Please select an image file.",
          'error'
        )
      }
    } else {
      $("#preloader").hide();
      Swal.fire(
        'error!',
        "No file(s) selected.",
        'error'
      )
    }

  }.bind(this), 400);


});


function printErrorMsg(msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display', 'block');
  $.each(msg, function (key, value) {
    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
  });
}