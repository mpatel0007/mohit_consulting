

$(document).ready(function () {
    $('#jobs_search').hide();
    $("#find_jobs").click(function () {
        var home_search = $('#search_jobs').val();
        var home_country = $('#country').val();
        var url = BASE_URL +"/jobs/findjobs/view?home_country="+ home_country +"&home_search="+ home_search +""
        window.location.href = url; 
    });  

    $(".popularSearchBtn").click(function () {
        var home_search = $(this).data('title');
        var home_country = '';
        var url = BASE_URL +"/jobs/findjobs/view?home_country="+ home_country +"&home_search="+ home_search +""
        window.location.href = url; 
    });  
    
    $(document).on('click','.favourite', function () {
        var icon_status = $(this).data("status");
        var job_id = $(this).data("id");
        if(icon_status == 0){
            $.ajax({
                url: BASE_URL + '/jobs/makefavourite',
                type: 'post',
                data: {
                        'job_id': job_id,
                        "_token": $("[name='_token']").val()
                    },
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if(data.status == 1){
                        $('.make_favourite'+job_id+'').removeClass('fa fa-heart fa-2x');
                        $('.make_favourite'+job_id+'').addClass(' fa fa-heart fa-2x text-success');
                        window.location = BASE_URL + '/jobs/findjobs/view';
                    }
                }
            });
        }else{
            $.ajax({
                url: BASE_URL + '/jobs/removefavourite',
                type: 'post',
                data: {
                        'job_id': job_id,
                        "_token": $("[name='_token']").val()
                    },
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if(data.status == 1){
                        $('.make_favourite'+job_id+'').removeClass('fa fa-heart fa-2x text-success');
                        $('.make_favourite'+job_id+'').addClass(' fa fa-heart fa-2x');
                        window.location = BASE_URL + '/jobs/findjobs/view';
                    }
                }
            });
        }   
    });

});


