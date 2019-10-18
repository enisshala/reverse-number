/**
 * Shala Backend JS
 */

//Approve request
$('#approve-request').on('click', function (e) {
    e.preventDefault();
    var request_id = $(this).data('request-id');

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to approve this ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
    }).then((result) => {
        if (result.value) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '/admin/approve-request',
                data: {
                    request_id: request_id,
                },
                success: function (response) {
                    if (response.success) {
                        console.log('success');

                        Swal.fire({
                            title: 'Success',
                            text: 'Approved!',
                            type: 'success'
                        }).then(function () {
                                location.reload();
                            }
                        );
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Try again!',
                            type: 'error'
                        }).then(function () {
                                location.reload();
                            }
                        );
                    }
                }
            });
        }
    });
});
