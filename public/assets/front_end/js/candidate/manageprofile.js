$(document).ready(function () {
    appliedjobs();
    favouritejobs();
    $('#industry').select2();
    $('#subCategory').select2();

    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $("#degreelevel").select2();
    $('form[id="changeUserprofile"]').validate({
        rules: {
            fname: 'required',
            lname: 'required',
            // email: {
            //     required: true,
            //     email: true,
            //     remote: {
            //          url: BASE_URL + '/' + ADMIN + '/userprofile/emailcheck',
            //         type:'get',
            //         data:{
            //             hid : $('#hid').val(),
            //        }
            //     }
            // },
            dob: 'required',
            // gender: 'required',
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
            // email: {
            //     required: 'Email is required',
            //     email: 'Enter a valid email',
            //     remote: 'That email address is already registered.'
            // },
            dob: 'Date of birth is required',
            // gender: 'Gender is required',
            country: 'Country is required',
            state: 'State is required',
            city: 'City is required',
            experience: 'Experience is required',
            career: 'Career is required',
            industry: 'Industry is required',
            functional: 'Category is required',
        },
        submitHandler: function (form) {
            var formdata = new FormData($('#changeUserprofile')[0]);
            $.ajax({
                url: BASE_URL + '/candidate/changeprofile/proccess',
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
                            window.location = BASE_URL + '/candidate/manageprofile';
                        });
                        $('#changeUserprofile').trigger("reset");
                        $('label[class="error"]').remove();
                        $("#changeUserprofile").removeClass("was-validated");
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
                            window.location = BASE_URL + '/candidate/manageprofile';
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

function add_skill_level() {
    var i = 1;
    var add_skill = $('.add_skill'); //Input field wrapper
    var add_career_level = $('.add_career_level'); //Input field wrapper
    var add_icon = $('.add_icon'); //Input field wrapper    
    $.ajax({
        url: BASE_URL + '/candidate/getskill/level',
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
                var select = $('<select class="form-control mb-2 " name="skill[]" id="jobskill' + i + '"></select>');
                $.each(skill, function (id, jobskill) {
                    var option = $('<option></option>');
                    option.attr('value', id);
                    option.text(jobskill);
                    select.append(option);
                });
                $(add_skill).append(select);
            }
            if (allData != '') {
                var select = $('<select class="form-control mb-2 " name="level[]" id="dlevel' + i + '"></select>');
                var fieldHTML = '<div><button class="btn" id="nrow' + i + '" style="color:gray; padding: 7px 7px;" onclick="remove_button(' + i + ')"><i class="fa fa-minus-square fa-2x mt-2" id="' + i + '"></i></button>';
                $.each(level, function (id, level) {
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
function remove_button(i) {
    $('#nrow' + i + '').remove();
    $('#jobskill' + i + '').remove();
    $('#dlevel' + i + '').remove();
}

function edit_remove_button(id) {
    $('#row' + id + '').remove();
    $('#skill' + id + '').remove();
    $('#level' + id + '').remove();
}

function favouritejobs() {
    var table = $('#Favourite_Jobs').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/candidate/favouritejobs/list',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'jobtitle', name: 'jobtitle' },
            { data: 'jobtype', name: 'jobtype' },
            { data: 'ApplyNow', name: 'ApplyNow', orderable: false, searchable: false },
        ]
    });
}

function appliedjobs() {
    var table = $('#Applied_Jobs').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        // "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/candidate/appliedjobs',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'jobtitle', name: 'jobtitle' },
            // { data: 'jobtype', name: 'jobtype' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

function delete_applied_jobs(id) {
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
                url: BASE_URL + '/candidate/appliedjobs/delete',
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
                    appliedjobs();
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
$(document).ready(function () {
    $('#industry').on('select2:select', function (e) {
        var industry = $(this).val();
        if (industry > 0) {
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
        }

    });
});

function downgrade(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to downgrade package",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#preloader").show();
            $.ajax({
                url: BASE_URL + '/' + url,
                type: 'POST',
                data: {
                    "_token": $("[name='_token']").val(),
                },
                success: function (response) {
                    $("#preloader").hide();
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        /*Swal.fire(
                            'Downgraded!',
                            data.msg,
                            'success'
                            )*/
                        Swal.fire({
                            title: "Downgraded!",
                            text: data.msg,
                            type: "success"
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Downgraded!',
                            data.msg,
                            'error'
                        )
                    }
                },
                error: function (response) {
                    $("#preloader").hide();
                }
            });
        }
    })
}


function downgrade(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to downgrade package",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#preloader").show();
            $.ajax({
                url: BASE_URL + '/' + url,
                type: 'POST',
                data: {
                    "_token": $("[name='_token']").val(),
                },
                success: function (response) {
                    $("#preloader").hide();
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        /*Swal.fire(
                            'Downgraded!',
                            data.msg,
                            'success'
                            )*/
                        Swal.fire({
                            title: "Downgraded!",
                            text: data.msg,
                            type: "success"
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Downgraded!',
                            data.msg,
                            'error'
                        )
                    }
                },
                error: function (response) {
                    $("#preloader").hide();
                }
            });
        }
    })
}

function downgradePackage(route, id, usertype) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to downgrade package",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            if (usertype == '1') {
                document.location.href = BASE_URL + '/candidate/payment/' + id;
            } else {
                document.location.href = BASE_URL + '/employers/payment/' + id;
            }
        }
    });
}

function upgradePackage(route, id, usertype) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to upgrade package",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            if (usertype == '1') {
                document.location.href = BASE_URL + '/candidate/payment/' + id;
            } else {
                document.location.href = BASE_URL + '/employers/payment/' + id;
            }
        }
    });
}


// ________________________________________________________________________________ resume
$('#upload_resume').on('change', function () {
    if(this.files[0].size < 2000000){
        var ext = $('#upload_resume').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['pdf','docx','doc']) == -1) {
            Swal.fire(
                'Upload!',
                'Please upload file PDF,DOCX,DOC format!',
                'error'
            )
        }else{
                var formdata = new FormData($('#resumeForm')[0]);
                $("#loader").addClass('emailloader');
                // $("#preloader").show();
                $.ajax({
                    url: BASE_URL + '/candidate/document/upload/resume',
                    type: 'post',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formdata,
                    success: function (responce) {
                        var data = JSON.parse(responce);
                        if (data.status == 1) {
                            Swal.fire(
                                'Upload!',
                                data.msg,
                                'success'
                            )
                            $("#loader").removeClass('emailloader');
                            $("#preloader").hide();
                        } else {
                            Swal.fire(
                                'Upload!',
                                data.msg,
                                'error'
                            )
                            $("#loader").removeClass('emailloader');
                            $("#preloader").hide();
                        }
                    }
                });
            }
    }else{
        Swal.fire(
            'Upload!',
            'file size must be less than 2 MB.',
            'error'
        )
    }
   
});
// ________________________________________________________________________________ cover latter 

$('#cover_letter').on('change', function () {
    if(this.files[0].size < 2000000){
        var ext = $('#cover_letter').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['pdf','docx','doc']) == -1) {
            Swal.fire(
                'Upload!',
                'Please upload file PDF,DOCX,DOC format!',
                'error'
            )
        }else{
            var formdata = new FormData($('#coverletterForm')[0]);
            $("#loader").addClass('emailloader');
            // $("#preloader").show();
            $.ajax({
                url: BASE_URL + '/candidate/document/upload/coverletter',
                type: 'post',
                contentType: false,
                cache: false,
                processData: false,
                data: formdata,
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire(
                            'Upload!',
                            data.msg,
                            'success'
                        )
                        $("#loader").removeClass('emailloader');
                        $("#preloader").hide();
                    } else {
                        Swal.fire(
                            'Upload!',
                            data.msg,
                            'error'
                        )
                        $("#loader").removeClass('emailloader');
                        $("#preloader").hide();
                    }
                }
            });
        }
    }else{
        Swal.fire(
            'Upload!',
            'file size must be less than 2 MB.',
            'error'
        )
    }
});

// ________________________________________________________________________________ references

$('#upload_references').on('change', function () {
    if(this.files[0].size < 2000000){
        var ext = $('#upload_references').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['pdf','docx','doc']) == -1) {
            Swal.fire(
                'Upload!',
                'Please upload file PDF,DOCX,DOC format!',
                'error'
            )
        }else{
            var formdata = new FormData($('#referencesForm')[0]);
            $("#loader").addClass('emailloader');
            // $("#preloader").show();
            $.ajax({
                url: BASE_URL + '/candidate/document/upload/references',
                type: 'post',
                contentType: false,
                cache: false,
                processData: false,
                data: formdata,
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire(
                            'Upload!',
                            data.msg,
                            'success'
                        )
                        $("#loader").removeClass('emailloader');
                        $("#preloader").hide();
                    } else {
                        Swal.fire(
                            'Upload!',
                            data.msg,
                            'error'
                        )
                        $("#loader").removeClass('emailloader');
                        $("#preloader").hide();    
                    }
                }
            });
        }
    }else{
        Swal.fire(
            'Upload!',
            'file size must be less than 2 MB.',
            'error'
        )
    }
});