$(document).ready(function () {

  companylistdata();
  $(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
  $('#country').select2();
  $('#state').select2();
  $('#city').select2();
  // $('#package').select2();
  // $('#numberofoffices').select2();
  $('#industry').select2();
  $('#subCategory').select2();

  $('form[id="addCompanyform"]').validate({

    ignore: [],
    debug: false,
    rules: {
      companyname: 'required',
      industry: 'required',
      companydetail: {
        required: function () {
          CKEDITOR.instances.companydetail.updateElement();
        },
      },
      companyemail: {
        required: true,
        email: true,
        remote:{
              url : BASE_URL + '/' + ADMIN + '/companies/emailcheck',
              type:'get',
              data:{
                hid : $('#hid').val(),
           }
        }

      },
      password: {
        required: function () {
          var hid = $('#hid').val();
          if (hid > 0) {
            //  $("#password").rules("remove", "required");
            return false;
          } else {
            return true;
          }
        },
        minlength: 6,
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

      companyemail: {
        required: 'Email is required',
        email: 'Enter a valid email',
        remote: 'That email address is already registered.'
      },
      password: {
        password: 'password is required',
        minlength: 'password must be at least 6 characters long'
      },
      country: 'country is required',
      state: 'state is required',
      city: 'city Name is required',
    },
    submitHandler: function (form) {

      // alert('h');
      for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
      };
      var formdata = new FormData($('#addCompanyform')[0]);

      $.ajax({
        url: BASE_URL + '/' + ADMIN + '/companies/add',
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
              window.location = BASE_URL + '/' + ADMIN + '/companies/list';
            });
            $('#addCompanyform').trigger("reset");
            $("#addCompanyform").removeClass("was-validated");
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
              window.location = BASE_URL + '/' + ADMIN + '/companies/list';
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

function companylistdata() {
  var table = $('#Company_list_table').DataTable({
    processing: true,
    serverSide: true,
    "bDestroy": true,
    "bAutoWidth": false,
    "ajax": {
      type: 'POST',
      url: BASE_URL + '/' + ADMIN + '/companies/datatable',
      data: {
        "_token": $("[name='_token']").val(),
      },
    },
    columns: [
      { data: 'companyname', name: 'companyname' },
      { data: 'companyemail', name: 'companyemail' },
      //    { data: 'created_at', name: 'created_at' },
      { data: 'status', name: 'status' },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
  });
}

function delete_companies(id) {
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
        url: BASE_URL + '/' + ADMIN + '/companies/delete',
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
          companylistdata();
        }
      });
    }
  })
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
    url: BASE_URL  + '/city/getstatecity',
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

$('#industry').on('change', function () {
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