
$(document).ready(function () {
    userprofilelistdata();
    UserSubscriptions();
    $('#ChargeList').on('hidden.bs.modal', function () {
        $("#ChargeListTable").empty();
    });
    // var fieldHTML = '<a href="javascript:void(0);" class="remove_button"><i class="fas fa-minus"></i></a>';

    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $('#country').select2();
    $('#state').select2();
    $('#city').select2();
    $('#package').select2();
    $('#functional').select2();
    $('#industry').select2();
    $('#degreelevel').select2();
    $('#subCategory').select2();
    
    $('form[id="addUserprofileform"]').validate({
        rules: {
            fname: 'required',
            lname: 'required',
            email: {
                required: true,
                email: true,
                remote: {
                     url: BASE_URL + '/' + ADMIN + '/userprofile/emailcheck',
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
            dob: 'required',
            gender: 'required',
            country: 'required',
            state: 'required',
            city: 'required',
            experience: 'required',
            career: 'required',
            industry: 'required',
            functional: 'required',
        },
        messages: {
            fname: 'First Name is required',
            lname: 'Last Name is required',
            email: {
                required: 'Email is required',
                email: 'Enter a valid email',
                remote: 'That email address is already registered.'
            },
            password: {
                password: 'password is required',
                minlength: 'Password must be at least 6 characters long'
            },
            dob: 'Date of birth is required',
            gender: 'Gender is required',
            country: 'Country is required',
            state: 'State is required',
            city: 'City is required',
            experience: 'Experience is required',
            career: 'Career is required',
            industry: 'Industry is required',
            functional: 'Category is required',
        },
        submitHandler: function (form) {
            var formdata = new FormData($('#addUserprofileform')[0]);
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/userprofile/add',
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
                            window.location = BASE_URL + '/' + ADMIN + '/userprofile/list';
                        });
                        $('#addUserprofileform').trigger("reset");
                        $('label[class="error"]').remove();
                        $("#addUserprofileform").removeClass("was-validated");
                        $('select').removeClass('error');
                        userprofilelistdata();
                    } else if (data.status == 0) {
                        printErrorMsg(data.error)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            showConfirmButton: true,
                            timer: 1500
                        }).then(function () {
                            window.location = BASE_URL + '/' + ADMIN + '/userprofile/list';
                        });
                    }
                }
            });
        }
    });
});

    function add_skill_level(){
        var i = 1;
        var add_skill = $('.add_skill'); //Input field wrapper
        var add_career_level = $('.add_career_level'); //Input field wrapper
        var add_icon = $('.add_icon'); //Input field wrapper    
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/jobs/getskill/level',
        type: 'POST',
        data: {
            // 'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            var allData = JSON.parse(response);
            var skill = allData.skills;                 	
            var level = allData.career; 
            i++;
            if (allData != '') {
                var select = $('<select class="form-control mb-2 " name="skill[]" id="jobskill'+i+'"></select>');
                $.each(skill , function(id, jobskill) {
                var option = $('<option></option>');
                        option.attr('value', id);
                        option.text(jobskill);
                        select.append(option);
                });
                $(add_skill).append(select);
            } 
            if (allData != '') {
                var select = $('<select class="form-control mb-2 " name="level[]" id="dlevel'+i+'"></select>');
                var fieldHTML = '<div><button class="btn" id="trow'+i+'" onclick="remove_button('+i+')"><i class="fa fa-minus-square fa-2x mt-2" id="'+i+'"></i></button>';
                $.each(level , function(id, level) {
                var option = $('<option></option>');
                        option.attr('value', id);
                        option.text(level);
                        select.append(option);
                });
                $(add_career_level).append(select);
                add_icon.append(fieldHTML);
            } 
        }
    });
}
function remove_button(i){
        
    $('#trow'+i+'').remove();     
    $('#jobskill'+i+'').remove();     
    $('#dlevel'+i+'').remove();     
}

function edit_remove_button(id){
    $('#row'+id+'').remove();
    $('#skill'+id+'').remove();     
    $('#level'+id+'').remove();     
}

function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}

function userprofilelistdata() {
    var table = $('#Userprofile_list_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,

        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/userprofile/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            //    { data: 'created_at', name: 'created_at' },
            { data: 'userstatus', name: 'userstatus' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}


function delete_userprofile(id) {
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
                url: BASE_URL + '/' + ADMIN + '/userprofile/delete',
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
                    userprofilelistdata();
                }
            });
        }
    })
}


function UserSubscriptions() {
    var userId = $('#userId').val();
    userId
    var table = $('#User_Subscriptions_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/userprofile/subscriptions/list',
            data: {
                'userId' : userId,
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'package_name', name: 'package.package_title' },
            { data: 'stripe_id', name: 'stripe_id' },
            { data: 'package_price', name: 'package.package_price' },
            { data: 'start_at', name: 'start_at' },
            { data: 'ends_at', name: 'ends_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

$(document).on('click','.viewCharge',function(){
    var stripe_id = $(this).data("id");
    $.ajax({
           url: BASE_URL + '/' + ADMIN + '/userprofile/subscriptions/charge/list',
           type: 'POST',
           data:{
                    'stripe_id' : stripe_id,
                     "_token": $("[name='_token']").val(),
                },
           success: function (responce){
                var data = JSON.parse(responce);
                if (data.status == 1) {
                    var result = data.table;
                $("#ChargeListTable").html(result);
                }
           }
    });
    $("#ChargeList").modal("show");
});

$(document).on('click','.UploadedDocument',function(){
    var user_id = $(this).data("id");    
    $('#User_id').val(user_id);
    $("#UploadedDocument").modal("show");
});


function download_candidate_resume(){
    var user_id  = $('#User_id').val();
    $.ajax({
           url: BASE_URL + '/' + ADMIN + '/userprofile/candidate/resume/download',
           type: 'POST',
           data: {
            'user_id' : user_id,
            "_token": $("[name='_token']").val(),
           },
           success: function (response){
            var data = JSON.parse(response);
            var filename = data.filename;
                if (data.status == 1) {
                    // window.location.href = BASE_URL + '/assets/front_end/Upload/User_Resume/'+filename;
                    window.open(
                        BASE_URL + '/assets/front_end/Upload/User_Resume/'+filename,
                        '_blank'
                      );
                    Swal.fire(
                        'Download!',
                        data.msg,
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Download!',
                        data.msg,
                        'error'
                    )
                }
           }
    });
}

function download_candidate_cover_letter(){
    var user_id  = $('#User_id').val();
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/userprofile/candidate/coverletter/download',
        type: 'POST',
        data: {
         'user_id' : user_id,
         "_token": $("[name='_token']").val(),
        },
        success: function (response){
         var data = JSON.parse(response);
         var filename = data.filename;
             if (data.status == 1) {
                window.open(
                    BASE_URL + '/assets/front_end/Upload/User_Cover_Letter/'+filename,
                    '_blank'
                  );
                 Swal.fire(
                     'Download!',
                     data.msg,
                     'success'
                 )
             } else {
                 Swal.fire(
                     'Download!',
                     data.msg,
                     'error'
                 )
             }
        }
 });
}

function download_candidate_references(){
    var user_id  = $('#User_id').val();
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/userprofile/candidate/references/download',
        type: 'POST',
        data: {
         'user_id' : user_id,
         "_token": $("[name='_token']").val(),
        },
        success: function (response){
         var data = JSON.parse(response);
         var filename = data.filename;
             if (data.status == 1) {
                window.open(
                    BASE_URL + BASE_URL + '/assets/front_end/Upload/User_References/'+filename,
                    '_blank' 
                  );
                 Swal.fire(
                     'Download!',
                     data.msg,
                     'success'
                 )
             } else {
                 Swal.fire(
                     'Download!',
                     data.msg,
                     'error'
                 )
             }
        }
 });
}

$('#country').on('change', function () {
    var country = $(this).val();
    $.ajax({
        url: BASE_URL +  '/city/getcountrystate',
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

