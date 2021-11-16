
$(document).ready(function () {
    $('#jobs_search').hide();
    $('#find_jobs_candidate').on('click', function () {
        $.ajax({
            url: BASE_URL + '/jobs/findjobs',
            type: 'post',
            data: $('#find_jobs_form').serialize(),
            success: function (responce) {
                $('#jobs_search_data').html(responce);
                jobFulldetails()
                var numberOfRecord = $('#numberOfRecord').val();
                var scroll = Math.round(numberOfRecord / 4);
                $('#scroll').val(scroll);
                var scrollHdnnumber = $('#scroll').val();
                var scrollablePage = $('#scrollablePage').val();
                $(".scrollable").scroll(function () {

                    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {

                        if (scrollHdnnumber > 0 || scroll > scrollHdnnumber) {
                            var countOfScroll = ++scrollablePage;
                            fetch_data_load(countOfScroll);
                            scrollHdnnumber = scroll - 1;
                            scrollablePage + 1

                            // alert('end reached');
                            // $.ajax({
                            //     url: BASE_URL + '/jobs/findjobs/load',
                            //     type: 'post',
                            //     data: $('#find_jobs_form').serialize(),
                            //     success: function (responce) {
                            //         var data = JSON.parse(responce);
                            //         $('.scrollable').append(data);
                            //         $('#scrollablePage').val(countOfScroll);
                            //     }
                            // });
                        }

                    }
                });
            }
        });
    });
    jobFulldetails()

    $(document).on('click', '.favourite', function () {
        var icon_status = $(this).data("status");
        var job_id = $(this).data("id");
        if (icon_status == 0) {
            // alert("add")
            $.ajax({
                url: BASE_URL + '/jobs/makefavourite',
                type: 'post',
                data: {
                    'job_id': job_id,
                    "_token": $("[name='_token']").val()
                },
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        $('.make_favourite' + job_id + '').removeClass('fa fa-heart fa-2x');
                        $('.make_favourite' + job_id + '').addClass(' fa fa-heart fa-2x text-success');
                        window.location = BASE_URL + '/jobs/findjobs/view';
                    }
                }
            });
        } else {
            $.ajax({
                url: BASE_URL + '/jobs/removefavourite',
                type: 'post',
                data: {
                    'job_id': job_id,
                    "_token": $("[name='_token']").val()
                },
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        $('.make_favourite' + job_id + '').removeClass('fa fa-heart fa-2x text-success');
                        $('.make_favourite' + job_id + '').addClass(' fa fa-heart fa-2x');
                        window.location = BASE_URL + '/jobs/findjobs/view';
                    }
                }
            });
        }
    });

    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page) {
        $.ajax({
            url: "/jobs/findjobs?page=" + page,
            type: 'post',
            data: $('#find_jobs_form').serialize(),
            success: function (data) {
                $('#jobs_search_data').html(data);
            }
        });
    }

    function fetch_data_load(page) {
        $.ajax({
            url: "/jobs/findjobs/load?page=" + page,
            type: 'post',
            data: $('#find_jobs_form').serialize(),
            success: function (responce) {
                var data = JSON.parse(responce);
                $('.scrollable').append(data);
            }
        });
    }

    $('body').on('click', '#apply_job', function () {
        $('#appliedJobsAttachmentModal').modal('show');
        var jobid = $(this).data("id");
        $('body').on('click','#saveAttachmentBtn', function () {
            var con_number = $('#con_number').val();
            
            var count = 0;
            if(con_number == ''){
                count++;
                $('#con_number').css({"border-color": "red"});
            }
            // return false;
            if(count == 0){
                var file = $('#apply_attachment')[0].files[0];

                if(file != '' && file != null && file != undefined){
                    if(file.size < 2000000){
                        var ext = file.name.split('.').pop().toLowerCase();
                        if($.inArray(ext, ['pdf','docx','doc']) == -1) {
                            Swal.fire(
                                'Upload!',
                                'Please upload file PDF,DOCX,DOC format!',
                                'error'
                            )
                        }else{
                            var formdata = new FormData($('#attachmentForm')[0]);
                                formdata.append("job_id", jobid);
                            $.ajax({
                                url: BASE_URL + '/jobs/applied',
                                type: 'post',
                                processData: false,
                                contentType: false,
                                data: formdata,
                                success: function (responce) {
                                    var data = JSON.parse(responce);
                                    if (data.status == 1) {
                                            $('#appliedJobsAttachmentModal').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: data.msg,
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(function () {
                                            window.location = BASE_URL + '/jobs/findjobs/view';
                                        });
                                        $('#apply_job').data('apply','1');
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
                    }
                }else{
                    var formdata = new FormData($('#attachmentForm')[0]);
                    formdata.append("job_id", jobid);
                        $.ajax({
                            url: BASE_URL + '/jobs/applied',
                            type: 'post',
                            processData: false,
                            contentType: false,
                            data: formdata,
                            success: function (responce) {
                                var data = JSON.parse(responce);
                                if (data.status == 1) {
                                        $('#appliedJobsAttachmentModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: data.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function () {
                                        window.location = BASE_URL + '/jobs/findjobs/view';
                                    });
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
            }
        }) 
    });
    
    $('body').on('click', '.single_job_list', function () {
        var jobid = $(this).data("id");
        jobFulldetails(jobid)
    })
    var numberOfRecord = $('#numberOfRecord').val();
    var scroll = Math.round(numberOfRecord / 4);
    $('#scroll').val(scroll);
    var scrollHdnnumber = $('#scroll').val();
    var scrollablePage = $('#scrollablePage').val();
    $(".scrollable").scroll(function () {

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {

            if (scrollHdnnumber > 0 || scroll > scrollHdnnumber) {
                var countOfScroll = ++scrollablePage;
                fetch_data_load(countOfScroll);
                scrollHdnnumber = scroll - 1;
                scrollablePage + 1
                // alert('end reached');
                // $.ajax({
                //     url: BASE_URL + '/jobs/findjobs/load',
                //     type: 'post',
                //     data: $('#find_jobs_form').serialize(),
                //     success: function (responce) {
                //         var data = JSON.parse(responce);
                //         $('.scrollable').append(data);
                //         $('#scrollablePage').val(countOfScroll);
                //     }
                // });
            }

        }
    });
    function jobFulldetails(jobid) {
        var defaultid = jobid ? jobid : firstid
        $.ajax({
            url: BASE_URL + '/jobdetails',
            type: 'post',
            data: {
                'job_id': defaultid,
                "_token": $("[name='_token']").val(),
            },
            success: function (responce) {
                var data = JSON.parse(responce);
                $('.jobData').html(data)

                var child = document.querySelector(".single_job_list").firstElementChild.className;
               
                $(".single_job_list").each(function () {
                    if ($(this).data("id") == defaultid) {
                        $(this).children('div').removeClass("bg-light");
                    }else{
                        $(this).children('div').addClass("bg-light");
                    }
                });


            }
        })
    }
});

// function ListAllJobjs(){
//     $.ajax({
//         url: BASE_URL + '/jobs/findjobs',
//         type: 'post',
//         data: $('#find_jobs_form').serialize(),     
//         success: function (responce) {
//             $('#jobs_search_data').html(responce);
//         }
//     });
// }