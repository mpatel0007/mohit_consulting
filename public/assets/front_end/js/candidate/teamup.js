$(document).ready(function () {
    $('#showHiddenDescription').click(function() {
        $('#descriptionDiv').slideToggle("slow");
      });
    $('#descriptionAboutTeamRequestModal').on('hidden.bs.modal', function () {
        CKEDITOR.instances.description.setData('');
    });

    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $("[data-toggle=tooltip").tooltip();
    Team_list();
    Team_member_list();
    Team_request_list();
    Team_joined_list();
    team_task_list();
    // $("#ConnectNow").html("Connect Now");
    var edit_team_type = $("#edit_team_type").val();
    $('#createteamModal').on('hidden.bs.modal', function () {
        $('#createteamForm')[0].reset();
        $("#attachmentsDownload").empty();
        $('.modal-title').html('Create New Team');
        $('#createteamBtn').html('Create');
        $("#edit_team_id").val('');
        $("#teamid").val('');   
    });
    $('#createtaskModal').on('hidden.bs.modal', function () {
        $('#createtaskForm')[0].reset();
        $("#attachmentsDownload").empty();
        $('.modal-title').html('Create New Task');
        $('#createtaskBtn').html('Create');
        $("#edit_task_id").val('');  
        $("#teamid").val('');   
    });
    $('#createNewteam').on('click', function () {
        $('.modal-title').html('Create New Team');
        $("#createteamModal").modal('show');
    });

    $('#createteamBtn').on('click', function () {
        var form = jQuery("#createteamForm");
        form.validate({
            rules: {
                team_name: 'required',
                description: 'required',
                // attachments:  'required',
                
            },
            messages: {
                team_name: 'Team name is required',
                description: "Team description is required",
                // attachments: 'Attachments is required',
            }
        });
        if (form.valid() === true) {
            var formdata = new FormData($('#createteamForm')[0]);
            $("#loader").addClass('emailloader');
            $.ajax({
                url: BASE_URL + '/candidate/teamname/add',
                type: 'post',
                contentType: false,
                cache: false,
                processData: false,
                data: formdata,
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        $('#teamid').val(data.teamid);
                        $("#loader").removeClass('emailloader');
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                            )
                        Team_list();
                        $("#createteamModal").modal('hide');
                    } else if (data.status == 0) {
                        printErrorMsg(data.error);
                        $("#loader").removeClass('emailloader');
                    } else {
                        // $('#CandidateList').hide();
                        $('#searchDiv').hide();
                        $("#loader").removeClass('emailloader');
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'success'
                            )
                    }
                }
            });
        }
    });

    $('#attachments').on('change', function () {
        var ext = $("#attachments").val().split('.').pop();
        if (this.files[0].size < 2000000) {
            if($.inArray(ext, ['pdf','docx','doc']) == -1) {
                Swal.fire(
                    'Upload!',
                    'Please upload file PDF,DOCX,DOC format!',
                    'error'
                    )
            }else{
                return true;
            }
        } else {
            Swal.fire(
                'Upload!',
                'file size must be less than 2 MB.',
                'error'
                )
        }
    });


    $('#taskattachments').on('change', function () {
        var ext = $("#taskattachments").val().split('.').pop();
        if (this.files[0].size < 2000000) {
            if($.inArray(ext, ['pdf','docx','doc']) == -1) {
                Swal.fire(
                    'Upload!',
                    'Please upload file PDF,DOCX,DOC format!',
                    'error'
                    )
            }else{
                return true;
            }
        } else {
            Swal.fire(
                'Upload!',
                'file size must be less than 2 MB.',
                'error'
                )
        }
    });
});

function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
    setTimeout(function() {
        $('.print-error-msg').fadeOut('fast');
    }, 5000);
}

function Team_list() {
    var table = $('#teamup_list').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/candidate/team/list',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
        { data: 'team_name', name: 'team_name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
        { data: 'task', name: 'task', orderable: false, searchable: false },
        ]
    });
}

function delete_team(team_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + '/candidate/team/delete',
                type: 'POST',
                data: {
                    'team_id': team_id,
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
                    Team_list();
                }
            });
        }
    })
}

function edit_team(team_id){
    $.ajax({
        url: BASE_URL + '/candidate/team/edit',
        type: 'POST',
        data: {
            'team_id': team_id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#createteamBtn').html('Update');
            $('.modal-title').html('Update Team Data');
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.admin;
                $('#edit_team_id').val(result.id);
                $('#team_name').val(result.team_name);
                $('#description').val(result.description);
                if(result.attachments != '' && result.attachments != null){
                    var attachments_url = BASE_URL + '/assets/front_end/Upload/team_attachments/'+result.attachments;
                    $('#attachmentsDownload').append('<button class="resume" id="team_attachments" data-toggle="tooltip" title="Download Attachments" data-id="'+ attachments_url +'"><i style="color:#21254C; margin-top:2px;" class="fas fa-download fa-2x" aria-hidden="true"></i></button>');
                }
                $('#createteamModal').modal('show');
            }
        }
    });
}

$(document).on('click','#team_attachments',function(){
    var attachments_url = $(this).data("id");
    window.open(
        attachments_url,
        '_blank'
        );
});

function Team_member_list() {
    var team_id = $('#team_id').val();
    var table = $('#Team_member_list').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/candidate/team/members/list',
            data: {
                'team_id': team_id,
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
        { data: 'team_name', name: 'team_name' },
        { data: 'candidate_name', name: 'candidate_name' },
        { data: 'status', name: 'status' },
        { data: 'remove_candidate', name: 'remove_candidate', orderable: false, searchable: false },
        { data: 'gave_task', name: 'gave_task', orderable: false, searchable: false },
        ]
    });
}

$(document).on('click', '.pagination a', function (event) {
    var teamid = $('#teamid').val();    
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data(page,teamid);
});

function fetch_data(page,teamid) {
    $.ajax({
        url: BASE_URL + '/candidate/teamup/searchcandidate?page=' + page +'&teamid='+ teamid,
        success: function (data) {
            $("#CandidateList").html(data);
        }
    });
}

function Team_request_list() {
    var table = $('#Team_request_list').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/candidate/team/request/list',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
        { data: 'team_name', name: 'team_name' },
        { data: 'team_creator_name', name: 'team_creator_name'},
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
        { data: 'message', name: 'message', orderable: false, searchable: false },
        ]
    });
}
$('#searchCandidate').on('keyup', function () {
    var searchCandidate = $("#searchCandidate").val();
    var teamid = $('#teamid').val();
    $.ajax({
        url: BASE_URL + '/candidate/teamup/searchcandidate/' + searchCandidate,
        type: 'get',
        data: {
            'teamid':teamid,
            'searchCandidate': $("#searchCandidate").val(),
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $("#CandidateList").html(response);
        }
    });
});

$(document).on('change','#searchBySkill' ,function () {
    var searchBySkill = $(this).find(':selected').data("id");
    var teamid = $('#teamid').val();
    $.ajax({
        url: BASE_URL + '/candidate/teamup/searchcandidate/' + searchBySkill,
        type: 'get',
        data: {
            'teamid':teamid,
            'searchBySkill': $("#searchBySkill").val(),
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $("#CandidateList").html(response);
        }
    });
});

$('#searchByCategory').on('change', function () {
    var searchByCategory = $("#searchByCategory").val();
    var teamid = $('#teamid').val();
    $.ajax({
        url: BASE_URL + '/candidate/teamup/searchcandidate/' + searchByCategory,
        type: 'get',
        data: {
            'teamid':teamid,
            'searchByCategory': searchByCategory,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $("#CandidateList").html(response);
        }
    });
});


function team_request_message(team_id){
    $.ajax({
        url: BASE_URL + '/team/up/message/candidate',
        type: 'POST',
        data: {
            'team_id': team_id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.message;
                $('#messageModal').modal('show');
                $('#messageData').html('');
                $('#messageData').html(result);
            }
        }
    });    
}

function Team_joined_list() {
    var table = $('#Team_joined_list').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/candidate/team/joined/list',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
        { data: 'team_name', name: 'team_name' },
        { data: 'team_creator_name', name: 'team_creator_name' },
        { data: 'teamMembers', name: 'teamMembers' },
        { data: 'updated_at', name: 'updated_at' },
        { data: 'leaveTeam', name: 'leaveTeam', orderable: false, searchable: false },
        { data: 'viewtask', name: 'viewtask', orderable: false, searchable: false },
        ]
    });
}

function Remove_members(candidate_id, team_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't to Remove this member from team !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + '/candidate/team/members/remove',
                type: 'POST',
                data: {
                    'candidate_id': candidate_id,
                    'team_id': team_id,
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
                    Team_member_list();
                }
            });
        }
    })
}

function reject_team_request(candidate_id, team_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't to Reject this team request !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Reject it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + '/candidate/team/request/deny',
                type: 'POST',
                data: {
                    'candidate_id': candidate_id,
                    'team_id': team_id,
                    "_token": $("[name='_token']").val(),
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        Swal.fire(
                            'Rejected!',
                            data.msg,
                            'success'
                            )
                        Team_request_list();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'error'
                            )
                    }
                    Team_request_list();
                    Team_joined_list();
                }
            });
        }
    })
}

function accept_team_request(candidate_id, team_id) {
    $.ajax({
        url: BASE_URL + '/candidate/team/request/accept',
        type: 'POST',
        data: {
            'candidate_id': candidate_id,
            'team_id': team_id,
            "_token": $("[name='_token']").val(),
        },
        success: function (responce) {
            var data = JSON.parse(responce);
            if (data.status == 1) {
                Swal.fire(
                    'Accepted!',
                    data.msg,
                    'success'
                    )
                Team_request_list();
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

$(document).on('click', '.ConnectNow', function () {
    $('#descriptionAboutTeamRequestModal').modal('show');
    var Candidate_id = $(this).data("id");
    var teamid1 = $('#teamid').val();
    var teamid2 = $(this).data("teamid");
    if(teamid1 != "undefined" && teamid1 != " " && teamid1 != null ){
        var Teamid = teamid1;
    }else{
        var Teamid = teamid2;
    }
    var edit_team_id = $('#edit_team_id').val();    
    $(document).on('click','#saveDescription',function(){
        var descriptionData = CKEDITOR.instances['descriptionTeamReq'].getData()    
        var error = 0;
        if (descriptionData == '' || descriptionData == null) {
            error++;
            $('#descriptionTeamReq').css('border-color', 'red');
        }
        if(error == 0){
            $("#loader").addClass('emailloader');
            $.ajax({
                url: BASE_URL + '/candidate/team/addmember',
                type: 'post',
                data: {
                    'Candidate_id': Candidate_id,
                    'Teamid': Teamid,
                    'edit_team_id': edit_team_id,
                    'descriptionData':descriptionData,
                    "_token": $("[name='_token']").val(),
                },
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        $("#loader").removeClass('emailloader');
                        $("[data-id=" + Candidate_id + "]").html("Requested");
                        $("[data-id=" + Candidate_id + "]").addClass('btn-warning');
                        $("[data-id=" + Candidate_id + "]").prop('disabled', true);
                    }
                    $("#loader").removeClass('emailloader');
                }
            });
        }
    });
    //  return false;
    // $("#loader").addClass('emailloader');
    // $.ajax({
    //     url: BASE_URL + '/candidate/team/addmember',
    //     type: 'post',
    //     data: {
    //         'Candidate_id': Candidate_id,
    //         'Teamid': Teamid,
    //         'edit_team_id': edit_team_id,
    //         "_token": $("[name='_token']").val(),
    //     },
    //     success: function (responce) {
    //         var data = JSON.parse(responce);
    //         if (data.status == 1) {
    //             $("#loader").removeClass('emailloader');
    //             $("[data-id=" + Candidate_id + "]").html("Requested");
    //             $("[data-id=" + Candidate_id + "]").addClass('btn-warning');
    //             $("[data-id=" + Candidate_id + "]").prop('disabled', true);
    //         }
    //         $("#loader").removeClass('emailloader');
    //     }
    // });
});

function add_task(team_id){  
    $('.modal-title').html('Create New Task');
    $("#createtaskModal").modal('show');
    $('#task_team_id').val(team_id);
}

$('#createtaskBtn').on('click', function () {
    var form = jQuery("#createtaskForm");
    form.validate({
        rules: {
            task_name: 'required',
            taskdescription: 'required',
            // attachments:  'required',
        },
        messages: {
            task_name: 'Task name is required',
            taskdescription: "Task description is required",
            // attachments: 'Attachments is required',
        }
    });
    if (form.valid() === true) {
        var formdata = new FormData($('#createtaskForm')[0]);
        $("#loader").addClass('emailloader');
        $.ajax({
            url: BASE_URL + '/candidate/task/add',
            type: 'post',
            contentType: false,
            cache: false,
            processData: false,
            data: formdata,
            success: function (responce) {
                var data = JSON.parse(responce);
                if (data.status == 1) {
                    $("#loader").removeClass('emailloader');
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                        )
                    $("#createtaskModal").modal('hide');
                    team_task_list();
                } else if (data.status == 0) {
                    printErrorMsg(data.error);
                    $("#loader").removeClass('emailloader');
                } else {
                    $('#searchDiv').hide();
                    $("#loader").removeClass('emailloader');
                    Swal.fire(
                        'Error!',
                        data.msg,
                        'success'
                        )
                }
            }
        });
    }
});

function team_task_list() {
    var team_id = $('#team_id').val();
    var attachments_url = BASE_URL + '/assets/front_end/Upload/team_task_attachments/';
    var table = $('#Team_task_list').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/candidate/team/task/list',
            data: {
                "team_id" : team_id,
                "attachments_url" : attachments_url,
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
        { data: 'team_name', name: 'team_name' },
        { data: 'team_creator_name', name: 'team_creator_name' },
        { data: 'task_name', name: 'task_name' },
            // { data: 'description', name: 'description' },
            { data: 'download', name: 'download', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
}

function task_delete(task_id,team_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + '/candidate/team/task/delete',
                type: 'POST',
                data: {
                    'team_id': team_id,
                    'task_id': task_id,
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
                    team_task_list();
                }
            });
        }
    })
}


function task_edit(task_id,team_id){
    $.ajax({
        url: BASE_URL + '/candidate/team/task/edit',
        type: 'POST',
        data: {
            'task_id' : task_id,
            'team_id': team_id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#createtaskBtn').html('Update');
            $('.modal-title').html('Update Task Data');
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.sqlData;
                $('#edit_task_id').val(result.id);
                $('#task_name').val(result.task_name);
                $('#taskdescription').val(result.description);
                if(result.attachments != '' && result.attachments != null){
                    var attachments_url = BASE_URL + '/assets/front_end/Upload/team_task_attachments/'+result.attachments;
                    $('#attachmentsDownload').append('<button class="resume" data-toggle="tooltip" title="Download Attachments" id="team_task_attachments" data-id="'+ attachments_url +'"><i style="color:#21254C; margin-top:2px;" class="fas fa-download fa-2x" aria-hidden="true"></i></button>');
                }
                $('#createtaskModal').modal('show');
            }
        }
    });
}

$(document).on('click','#team_task_attachments',function(){
    var attachments_url = $(this).data("id");
    window.open(
        attachments_url,
        '_blank'
        );
});

function gave_member_task(candidate_id,team_id) {
    $('#gavetaskModal').modal('show');
    $('#candidate_id').val(candidate_id);
    $.ajax({
        url: BASE_URL + '/candidate/gave/task',
        type: 'POST',
        data: {
            'candidate_id' : candidate_id,
            'team_id': team_id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.table;
                $("#taskList").html(result);
            }
        }
    });
}

function add_task_member(candidate_id,task_id,team_id) {
    $.ajax({
        url: BASE_URL + '/candidate/task',
        type: 'POST',
        data: {
            'candidate_id': candidate_id,
            'team_id':team_id,
            'task_id': task_id,
            "_token": $("[name='_token']").val(),
        },
        success: function (responce) {
            var data = JSON.parse(responce);
            if (data.status == 1) {
                Swal.fire(
                    'Success!',
                    data.msg,
                    'success'
                    )
                $("#assignTask_"+task_id).parent('td').hide();    
                $("#alreadyAssignTask_"+task_id).parent('td').show();
                //$('#gavetaskModal').modal('hide');
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

function remove_task_member(candidate_id,task_id,team_id){
    $.ajax({
        url: BASE_URL + '/candidate/task/remove',
        type: 'POST',
        data: {
            'candidate_id': candidate_id,
            'team_id':team_id,
            'task_id': task_id,
            "_token": $("[name='_token']").val(),
        },
        success: function (responce) {
            var data = JSON.parse(responce);
            if (data.status == 1) {
                Swal.fire(
                    'Success!',
                    data.msg,
                    'success'
                    )
                //$('#gavetaskModal').modal('hide');
                $("#assignTask_"+task_id).parent('td').show();    
                $("#alreadyAssignTask_"+task_id).parent('td').hide();
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

function view_my_task(candidate_id,team_id) {
    $('#mytaskModal').modal('show');
    var attachments_url = BASE_URL + '/assets/front_end/Upload/team_task_attachments/';
    $.ajax({
        url: BASE_URL + '/candidate/my/task',
        type: 'POST',
        data: {
            'candidate_id' : candidate_id,
            'team_id': team_id,
            'attachments_url':attachments_url,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.table;
                $("#mytaskList").html(result);
            }
        }
    });
}

function my_teammates_list(team_id) {
    $('#myteammatesModal').modal('show');
    $.ajax({
        url: BASE_URL + '/candidate/teammates/list',
        type: 'POST',
        data: {
            'team_id': team_id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.table;
                $("#myteammatesList").html(result);
            }
        }
    });
    
}