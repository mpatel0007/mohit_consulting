$(document).ready(function () {
    //alert($('#Campaignform').serialize());
    $('#CampaignModal').on('hidden.bs.modal', function () {
        $('#Campaignform')[0].reset();
        $('.print-error-msg').hide();
        $('label[class="error"]').remove();
        CKEDITOR.instances.description.setData('');
    });
    $("#openModal").on('click', function () {
        $('#CampaignModal').modal('show');
    });
    Campaign_datatable();
    $('form[id="Campaignform"]').validate({
        rules: {
          name: 'required',
          cmfor : 'required'
        },
        messages: {
          name: 'Campaign Name is required',
          cmfor: 'Campaign for is required'
        }, 
        submitHandler: function(form) {
            $("#loader").addClass('loader');
            CKEDITOR.instances.description.updateElement();
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/CampaignManagement/add',
                type: 'post',
                data: $('#Campaignform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) { 
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#CampaignModal').modal('hide');
                        $('#hid').val('');
                        $('#Campaignform')[0].reset();
                        CKEDITOR.instances.description.setData('');
                        $("#loader").removeClass('loader');
                        Campaign_datatable();
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
            // $("#loader").removeClass('loader');
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
function Campaign_datatable() {
    $('#Campaign_Management_datatable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/CampaignManagement/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'subject', name: 'subject' },
            { data: 'campaign_for', name: 'campaign_for' },
        ]
    });
}
