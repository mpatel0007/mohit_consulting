
$(document).ready(function () {
  
$.validator.addMethod('filesize', function(value, element, param) {
  return this.optional(element) || (element.files[0].size <= param)
});
  
  bloglistdata();
  $(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

  $('form[id="addBlogform"]').validate({

    ignore: [],
    debug: false,
    rules: {
      title: 'required',
      description: {
        required: function () {
          CKEDITOR.instances.description.updateElement();
        },
      },
        bloglog: {
          required: true,
            extension: "jpg,jpeg,png",
            filesize: 2242880 // <- 5 MB
        },
      
    },

    messages: {
      title: 'Title is required',
      description: {
        required: "Description is required",
      },
      bloglog : {
        required :"blog image is required", 
        extension: "Please upload file jpg,jpeg,png format.",
        filesize: "file size must be less than 2 MB. "
      }

    },
    submitHandler: function (form) {
      for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
      };
      var formdata = new FormData($('#addBlogform')[0]);

      $.ajax({
        url: BASE_URL + '/' + ADMIN + '/blogs/add',
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
              window.location = BASE_URL + '/' + ADMIN + '/blogs/list';
            });
            $('#addBlogform').trigger("reset");
            $("#addBlogform").removeClass("was-validated");
            $('label[class="error"]').remove();
            CKEDITOR.instances.description.setData('');
            bloglistdata();
          } else if (data.status == 0) {
            printErrorMsg(data.error)
          } else {
            Swal.fire({
              icon: 'error',  
              title: data.msg,
              showConfirmButton: true,
              timer: 1500
            }).then(function () {
              window.location = BASE_URL + '/' + ADMIN + '/blogs/list';
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

function bloglistdata() {
  var table = $('#Blog_list_table').DataTable({
    processing: true,    
    serverSide: true,
    "bDestroy": true,
    "bAutoWidth": false,
    "ajax": {
      type: 'POST',
      url: BASE_URL + '/' + ADMIN + '/blogs/datatable',
      data: {
        "_token": $("[name='_token']").val(),
      },
    },
    columns: [
      { data: 'title', name: 'title' },
      { data: 'status', name: 'status' },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
  });
}

function delete_blogs(id) {
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
        url: BASE_URL + '/' + ADMIN + '/blogs/delete',
        type: 'POST',
        data: {
          'id': id,
          "_token": $("[name='_token']").val(),
        },
        success: function (response) {
          var data = JSON.parse(response);
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
          bloglistdata();
        }
      });
    }
  })
}