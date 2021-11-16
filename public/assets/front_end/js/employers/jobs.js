var step = 0;
$(document).ready(function () {
    $('#city').select2({ width: '100%' });
    $('#gender').select2({ width: '100%' });
    $('#degreelevel').select2({ width: '100%' });
    $('#jobtype').select2({ width: '100%' });
    $('#subCategory').select2({ width: '100%' });
    var edit_id = $('#hid').val();
    manageapplications();
    //  jobdescription =  CKEDITOR.instances.jobdescription;
    jobslistdata();
    if (edit_id != 0 && edit_id != null) {
        // $("#nav-profile-tab").tabs("enable", 1);
        // $("#nav-contact-tab").tabs("enable", 1);
        // $("#nav-about-tab").tabs("enable", 1);
        // $("#nav-other-tab").tabs("enable", 1);
        $('#next_1').hide();
        $('#next_2').hide();
        $('#next_4').hide();
        $('#next_3').hide();
    } else {
        $('#nav-profile-tab').not('.active').prop('disabled', true);
        $('#nav-contact-tab').not('.active').prop('disabled', true);
        $('#nav-about-tab').not('.active').prop('disabled', true);
        $('#nav-other-tab').not('.active').prop('disabled', true);
    }

    // $('#postJobs').on('click',function(){
    //     $(':required:invalid', '#postJobsform').each(function () {
    //     var id = $('.tab-pane').find(':required:invalid').closest('.tab-pane').attr('id');
    //     $('.nav a[href="#' + id + '"]').tab('show');
    //     });
    // });        



    $('#next_1').on('click', function () {
        var form = $("#postJobsform");
        form.validate({
            rules: {
                jobtitle: 'required',
                jobdescription: {
                    required: function () {
                        CKEDITOR.instances.jobdescription.updateElement();
                    },
                },
                jobskill: 'required',
            },
            messages: {
                // company: 'Company is required',
                jobtitle: 'Job Title is required',
                jobdescription: {
                    required: "Job Description is required",
                },
                jobskill: 'Job Skill is required',
            }
        });
        if (form.valid() === true) {
            step = 1;
            // $('#nav-home-tab').attr('data-toggle');
            $('#nav-profile-tab').not('.active').prop('disabled', false);
            $("#nav-profile-tab").tab('show');
        }
    });

    $('#next_2').on('click', function () {
        var form = $("#postJobsform");
        form.validate({
            rules: {
                // company: 'required',
                country: 'required',
                state: 'required',
                city: 'required',
            },
            messages: {
                country: 'Country is required',
                state: 'State is required',
                city: 'City is required',
            }
        });
        if (form.valid() === true) {
            step = 2;
            $('#nav-contact-tab').not('.active').prop('disabled', false);
            $('#nav-profile-tab').not('.active').prop('disabled', false);
            $("#nav-contact-tab").tab('show');
        }
    });

    $('#next_3').on('click', function () {
        var form = $("#postJobsform");
        form.validate({
            rules: {
                yearly_job_salary: 'required',
                hidesalary: 'required',
            },
            messages: {
                yearly_job_salary: 'yearly job salary is required',
                hidesalary: 'Hide salary is required',
            }
        });
        if (form.valid() === true) {
            $('#nav-contact-tab').not('.active').prop('disabled', false);
            $('#nav-profile-tab').not('.active').prop('disabled', false);
            $('#nav-about-tab').not('.active').prop('disabled', false);
            $("#nav-about-tab").tab('show');
        }
    });

    $('#next_4').on('click', function () {
        var form = $("#postJobsform");
        form.validate({
            rules: {
                functional: 'required',
                jobtype: 'required',
                positions: 'required',
            },
            messages: {
                functional: 'Category is required',
                jobtype: 'Job Type is required',
                positions: 'Positions is required',
            },
        });
        if (form.valid() === true) {
            step = 4;
            $('#nav-contact-tab').not('.active').prop('disabled', false);
            $('#nav-profile-tab').not('.active').prop('disabled', false);
            $('#nav-about-tab').not('.active').prop('disabled', false);
            $('#nav-other-tab').not('.active').prop('disabled', false);
            $("#nav-other-tab").tab('show');
        }
    });

});

$('.postJobs').on('click', function () {
    $(':required:invalid', '#postJobsform').each(function () {
        var fieldId = $(this).attr('id');
        $('#' + fieldId + '').css('border-color', 'red', '!important');
        // $('#' + fieldId + '').addClass('errorclass');
        var id = $('.tab-pane').find(':required:invalid').closest('.tab-pane').attr('id');
        $('.nav a[href="#' + id + '"]').tab('show');
    });

    var form = $("#postJobsform");
    form.validate({
        rules: {
            // gender: 'required',
            degreelevel: 'required',
            experience: 'required',
        },
        messages: {
            // gender: 'gender is required',
            degreelevel: 'degreelevel   is required',
            experience: 'experience  is required',
        },
    });
    if (form.valid() === true) {
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
        };
        $.ajax({
            url: BASE_URL + '/jobs/post',
            type: 'post',
            data: $('#postJobsform').serialize(),
            success: function (responce) {
                var data = JSON.parse(responce);
                console.log(data);
                if (data.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location = BASE_URL + '/manage/job';
                    })
                    $('#postJobsform').trigger("reset");
                    CKEDITOR.instances.jobdescription.setData('');
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

function add_skill_level() {
    var i = 1;
    var add_skill = $('.add_skill'); //Input field wrapper
    var add_career_level = $('.add_career_level'); //Input field wrapper
    var add_icon = $('.add_icon'); //Input field wrapper
    $.ajax({
        url: BASE_URL + '/jobs/getskill/level',
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
                var select = $('<select class="form-control mb-2" data-id ="row' + i + '" name="skill[]" id="jobskill' + i + '"></select>');
                $.each(skill, function (id, jobskill) {
                    var option = $('<option></option>');
                    option.attr('value', id);
                    option.text(jobskill);
                    select.append(option);
                });
                $(add_skill).append(select);
            }
            if (allData != '') {
                var select = $('<select class="form-control mb-2"  name="level[]" id="dlevel' + i + '"></select>');
                var fieldHTML = '<button class="btn" id="trow' + i + '" onclick="remove_button(' + i + ')"><i class="fa fa-minus-square fa-2x" id="' + i + '"></i></button>';
                $.each(level, function (id, level) {
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
function remove_button(i) {
    // var id = $(this).data("id");
    // alert(id
    $('#trow' + i + '').remove();
    $('#jobskill' + i + '').remove();
    $('#dlevel' + i + '').remove();
}

function edit_remove_button(id) {
    $('#row' + id + '').remove();
    $('#skill' + id + '').remove();
    $('#level' + id + '').remove();
}


function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}

function jobslistdata() {
    var table = $('#manage_jobs').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/manage/jobs/list',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'jobtitle', name: 'jobtitle' },
            { data: 'jobtype', name: 'jobtype' },
            // { data: 'jobshift', name: 'jobshift' },
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
                url: BASE_URL + '/jobs/delete',
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
                    jobslistdata();
                }
            });
        }
    })
}


$('#country').on('change', function () {
    var country = $(this).val();
    $.ajax({
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

function manageapplications() {
    $('#manage_applications_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'post',
            url: BASE_URL + '/manage/applications/list',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'jobtitle', name: 'jobtitle', sWidth: '210px' },
            { data: 'name', name: 'name' },
            { data: 'contact_details', name: 'contact_details' },
            { data: 'jobtype', name: 'jobtype' },
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false, sWidth: '94px' },
        ]
    });
}

function reject_candidate_application(jobid, candidate_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't to reject this candidate request!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reject it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.when(
                $.ajax({ // First Request
                    url: BASE_URL + '/get/reject/reason',
                        type: 'POST',
                        data: {
                            "_token": $("[name='_token']").val(),
                            'jobid': jobid,
                        },    
                    cache: false,
                    success: function(responce){     
                        data = JSON.parse(responce);
                        $("#applicationRejectModal").modal('show');
                        if(data.status == 1){
                            $('#description').html(data.rejectReason);
                        }
                    }           
                })
            ).then(function() {
                $(document).on("click", "#Add_application_reject", function () {
                    var subject = $("#subject").val();
                    var description = $("#description").val();
                    var error = 0;
                    if (subject == '' || subject == null) {
                        error++;
                        $('#subject').css('border-color', 'red');
                    }
                    if (description == '' || description == null) {
                        error++;
                        $('#description').css('border-color', 'red');
                    }
                    if (error == 0) {
                        $("#loader").addClass('emailloader');
                        $.ajax({
                            url: BASE_URL + '/employers/manage/applications/reject',
                            type: 'post',
                            data: {
                                "_token": $("[name='_token']").val(),
                                'jobid': jobid,
                                'candidate_id': candidate_id,
                                'description': description,
                                'subject': subject,
                            },
                            success: function (responce) {
                                var data = JSON.parse(responce);
                                if (data.status == 1) {
                                    Swal.fire(
                                        'Rejected!',
                                        data.msg,
                                        'success'
                                    )
                                    $('#applicationRejectModal').modal('hide');
                                    // $('#Email_template_Modal').modal('hide');
                                    $('#application_reject_form')[0].reset();
                                    $("#loader").removeClass('emailloader');
                                    manageapplications();
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
                    }
                })

            })
            
           
            // $.ajax({
            //     url: BASE_URL + '/employers/manage/applications/reject',
            //     type: 'POST',
            //     data: {
            //         "_token": $("[name='_token']").val(),
            //         'jobid': jobid,
            //         'candidate_id': candidate_id,
            //     },
            //     success: function (response) {
            //         var data = JSON.parse(response);
            //         if (data.status == 1) {
            //             Swal.fire(
            //                 'Rejected!',
            //                 data.msg,
            //                 'success'
            //             )
            //             manageapplications();
            //         } else {
            //             Swal.fire(
            //                 'Rejected!',
            //                 data.msg,
            //                 'error'
            //             )
            //         }
            //     }
            // });
        }
    })
}

function accept_candidate_application($jobid, $candidate_id) {
    $.ajax({
        url: BASE_URL + '/employers/manage/applications/accept',
        type: 'POST',
        data: {
            "_token": $("[name='_token']").val(),
            'jobid': $jobid,
            'candidate_id': $candidate_id,
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                Swal.fire(
                    'Accepted!',
                    data.msg,
                    'success'
                )
                manageapplications();
            } else {
                Swal.fire(
                    'Error!',
                    data.msg,
                    'error'
                )
            }
        }
    });
}


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