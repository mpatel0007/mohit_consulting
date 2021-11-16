$(document).ready(function () {
    $('#popularSearchModal').on('hidden.bs.modal', function () {
        $('#popularSearchForm')[0].reset();
        $('.print-error-msg').hide();
        $("#popularSearchForm").removeClass("was-validated");
        $('.modal-title').html('Add Popular Search');
        $('#addPopularSearch').html('Add');
        $('label[class="error"]').remove();
    });
    $("#openModal").on('click', function () {
        $('#popularSearchModal').modal('show');
    });
    popular_search_data();
    $('form[id="popularSearchForm"]').validate({
        rules: {
        popularSearch: 'required',
        },
        messages: {
        popularSearch: 'Popular Search Name is required.',
        },
        submitHandler: function(form){
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/popular/research/add',
                type: 'post',
                data: $('#popularSearchForm').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#popularSearchModal').modal('hide');
                        $('#hid').val('');
                        $('#popularSearch').val('');
                        popular_search_data();
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
      });
 

});

function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}

function popular_search_data() {
    $('#popularSearchDatatable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/popular/research/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'popular_search', name: 'popular_search' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

function delete_popular_search(id) {
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
                url: BASE_URL + '/' + ADMIN + '/popular/research/delete',
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
                        popular_search_data();
                    } else {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'error'
                        )
                    }
                }
            });
        }
    })
}

function edit_popular_search(id) {
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/popular/research/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#popularSearchModal').modal('show');
            $('#addPopularSearch').html('Update');
            $('.modal-title').html('Update Popular Search');
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.popularSearch;
                $('#hid').val(result.id);
                $('#popularSearch').val(result.popular_search);
                $('#status').val(result.status);
            }
        }
    });
}


