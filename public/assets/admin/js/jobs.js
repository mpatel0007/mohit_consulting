$(document).ready(function () {
    jobslistdata();
    $('#country').select2();
    $('#state').select2();
    $('#city').select2();
    $('#gender').select2();
    $('#jobtype').select2();
    $('#degreelevel').select2();
    $('#subCategory').select2();

    //  jobdescription =  CKEDITOR.instances.companydetail;
    
    $('form[id="addJobsform"]').validate({
        ignore: [],
        debug: false,
        rules: {
            company: 'required',
            jobtitle: 'required',
            jobdescription: {
                required: function () {
                    CKEDITOR.instances.jobdescription.updateElement();
                },
            },
            jobskill: 'required',
            country: 'required',
            state: 'required',
            city: 'required',
            freelance: 'required',
            career: 'required',
            hidesalary: 'required',
            functional: 'required',
            jobtype: 'required',
            positions: 'required',
            gender: 'required',
            degreelevel: 'required',
            experience: 'required',

        },
        messages: {
            company: 'Company is required',
            jobtitle: 'Job Title is required',
            jobdescription: {
                required: "Job Description is required",
            },
            jobskill: 'Job Skill is required',
            country: 'Country is required',
            state: 'State is required',
            city: 'City is required',
            freelance: 'Freelance required',
            career: 'Career is required',
            hidesalary: 'Hide salary is required',
            functional: 'Category is required',
            jobtype: 'Job Type is required',
            positions: 'Positions is required',
            gender: 'Gender is required',
            degreelevel: 'Degree level is required',
            experience: 'Experience is required',


        },
        submitHandler: function (form) {
            for (var i in CKEDITOR.instances) {
                CKEDITOR.instances[i].updateElement();
            };
            var selected_company =  $('#company').val();
            $('#company_edit').val(selected_company);
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/jobs/add',
                type: 'post',
                data: $('#addJobsform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location = BASE_URL + '/' + ADMIN + '/jobs/list';
                        });
                        $('#addJobsform').trigger("reset");
                        $('label[class="error"]').remove();
                        $("#addJobsform").removeClass("was-validated");
                        $('select').removeClass('error');
                        CKEDITOR.instances.companydetail.setData('');
                        jobslistdata();
                    } else if (data.status == 0) {
                        printErrorMsg(data.error)
                    } else {
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
                var select = $('<select class="form-control mb-2" data-id ="row'+i+'" name="skill[]" id="jobskill'+i+'"></select>');
                $.each(skill , function(id, jobskill) {
                var option = $('<option></option>');
                        option.attr('value', id);
                        option.text(jobskill);
                        select.append(option);
                });
                $(add_skill).append(select);
            } 
            if (allData != '') {
                var select = $('<select class="form-control mb-2"  name="level[]" id="dlevel'+i+'"></select>');
                var fieldHTML = '<div><button class="btn"  id="trow'+i+'" onclick="remove_button('+i+')"><i class="fa fa-minus-square fa-2x mt-2" id="'+i+'"></i></button>';
                $.each(level , function(id, level) {
                var option = $('<option></option>');
                        option.attr('value', id);
                        option.text(level);
                        select.append(option);
                });
                $(add_career_level).append(select);
                add_icon.append(fieldHTML);
                // $(add_icon).append(fieldHTML);
            } 
        
            // $(add_icon).append(fieldHTML);
        }
    });
}
function remove_button(i){
    // var id = $(this).data("id");
    // alert(id
    $('#trow'+i+'').remove();
    $('#jobskill'+i+'').remove();     
    $('#dlevel'+i+'').remove();     
}

function edit_remove_button(id){
    $('#row'+id+'').remove();
    $('#skill'+id+'').remove();     
    $('#level'+id+'').remove();     
}
 //Once remove button is clicked

function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}
function jobslistdata() {
    var table = $('#jobs_list_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/jobs/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'jobtitle', name: 'jobtitle' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

function delete_jobs(id) {
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
                url: BASE_URL + '/' + ADMIN + '/jobs/delete',
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
                    jobslistdata()
                }
            });
        }
    })
}



$('#country').on('change', function () {
    var country = $(this).val();
    $.ajax({
        // url: BASE_URL + '/' + ADMIN + '/city/getcountrystate',
        url: BASE_URL + '/city/getcountrystate',
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
        }else{
            
        }
      }
    });
  });
