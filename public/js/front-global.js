/**
 * E.Shala FrontEnd JS
 */

$('#new-search').click(function(){
    $('#number_search').trigger("reset");
});

//Search function Ajax
$("#number_search").submit(function (event) {
    event.preventDefault();
    $("div.search-loader").removeClass('d-none');
    var search_data = $('form#number_search input#number').val();
    console.log(search_data);

    // Swal.fire(
    //     'Please wait...',
    //     'Searching...',
    //     'warning'
    // );
    // Swal.showLoading();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: '/search-number',
        data: {
            number: search_data,
        },
        success: function (response) {
            if (response.success) {
                $("div.new-search").removeClass('d-none');
                console.log(response.phone_data);
                if (response.logged_in) {
                    if (response.has_subscription) {

                        if (response.phone_data.current_addresses.length > 0) {
                            var address = ((response.phone_data.current_addresses[0].street_line_1 !== null) ? response.phone_data.current_addresses[0].street_line_1 + ", " : "" ) + ((response.phone_data.current_addresses[0].street_line_2 !== null) ? response.phone_data.current_addresses[0].street_line_2 + ", " : "" ) + ((response.phone_data.current_addresses[0].city !== null) ? response.phone_data.current_addresses[0].city + ", " : "" ) + ((response.phone_data.current_addresses[0].postal_code !== null) ? response.phone_data.current_addresses[0].postal_code + ", " : "" ) + ((response.phone_data.current_addresses[0].state_code !== null) ? response.phone_data.current_addresses[0].state_code : "" ) ;
                        } else {
                            var address = "N/A";
                        }

                        if (response.phone_data.associated_people.length > 0) {
                            var i;
                            var assoc_people = '';
                            for (i = 0; i < response.phone_data.associated_people.length; i++) {
                                assoc_people += response.phone_data.associated_people[i].name + ((response.phone_data.associated_people[i].relation !== null) ?  " - " + response.phone_data.associated_people[i].relation : " - N/A") + "<br>" ;
                            }
                        } else {
                            var assoc_people = 'N/A';
                        }

                        if (response.phone_data.is_commercial == false) {
                            var is_commercial = "NO"
                        } else if (response.phone_data.is_commercial == null) {
                            var is_commercial = "N/A";
                        } else {
                            var is_commercial = "YES";
                        }

                        if (response.phone_data.is_valid == false) {
                            var is_valid = "NO"
                        } else if (response.phone_data.is_valid == null) {
                            var is_valid = "N/A";
                        } else {
                            var is_valid = "YES";
                        }

                        if (response.phone_data.is_prepaid == false) {
                            var is_prepaid = "NO"
                        } else if (response.phone_data.is_prepaid == null) {
                            var is_prepaid = "N/A";
                        } else {
                            var is_prepaid = "YES";
                        }

                        if (response.phone_data.alternate_phones.length > 0) {
                            var alternate_number = response.phone_data.alternate_phones[0]
                        } else {
                            var alternate_number = "N/A";
                        }

                        $("div.search-result").html("<div class='col col-lg-6'>" +
                        "<p>Owner's Name: <span>" + ((response.phone_data.belongs_to.length > 0) ? response.phone_data.belongs_to[0].name : "N\A") + "</span></p>" +
                        "<p>Owner's Address: <span class='address'>" + address + "</span></p>" +
                        "<p>Owner's Age: <span class='address'>" + ((response.phone_data.belongs_to.length > 0) ? response.phone_data.belongs_to[0].age_range : "N\A") + "</span></p>" +
                        "<p>Associated People: <br><span class='assoc-people'>" + assoc_people + "</span></p>" +
                            "</div>" +
                        "<div class='col col-lg-6'>" +
                        "<p>Carrier: <span>" + response.phone_data.carrier + "</span></p>" +
                        "<p>Line Type: <span>" +response.phone_data.line_type + "</span></p>" +
                        "<p>Alternate Number: <span>" + alternate_number + "</span></p>" +
                        "<p>Is commercial: <span>" + is_commercial + "</span></p>" +
                        "<p>Is valid: <span>" + is_valid + "</span></p>" +
                        "<p>Is prepaid: <span>" + is_prepaid + "</span></p>" +
                            "</div>");

                    } else {
                        $("div.search-result").html("<div class='col col-lg-6'>" +
                            "<p><i class='fas fa-lock'></i> Owner's Name: <span class='add-blur'>Lorem Ipsum</span></p>" +
                            "<p><i class='fas fa-lock'></i> Owner's Address: <span class='address add-blur'>Lorem Ipsum, 20435, AB</span></p>" +
                            "<p><i class='fas fa-lock'></i> Owner's Age: <span class='address add-blur'>45-48</span></p>" +
                            "<p><i class='fas fa-lock'></i> Associated People: <br><span class='assoc-people add-blur'>Lorem Ipsum - Dolor</span></p>" +
                            "</div>" +
                            "<div class='col col-lg-6'>" +
                            "<p><i class='fas fa-lock'></i> Carrier: <span class='add-blur'>Janosni</span></p>" +
                            "<p><i class='fas fa-lock'></i> Line Type: <span class='add-blur'>Sit Dolor</span></p>" +
                            "<p><i class='fas fa-lock'></i> Alternate Number: <span class='add-blur'>34068453968</span></p>" +
                            "<p><i class='fas fa-lock'></i> Is commercial: <span class='add-blur'>NO</span></p>" +
                            "<p><i class='fas fa-lock'></i> Is valid: <span class='add-blur'>YES</span></p>" +
                            "<p><i class='fas fa-lock'></i> Is prepaid: <span class='add-blur'>N/A</span></p>" +
                            "</div>"+
                            "<div class='col-12'><div class='unlock-div text-center'><a href='/dashboard' class='text-center justify-content-center unlock-button btn btn-info btn-lg mb-1'><i class='fas fa-unlock'></i> Unlock for $1</a></div></div>");
                    }

                } else {
                    $("div.search-result").html("<div class='col col-lg-6'>" +
                        "<p><i class='fas fa-lock'></i> Owner's Name: <span class='add-blur'>Lorem Ipsum</span></p>" +
                        "<p><i class='fas fa-lock'></i> Owner's Address: <span class='address add-blur'>Lorem Ipsum, 20435, AB</span></p>" +
                        "<p><i class='fas fa-lock'></i> Associated People: <br><span class='assoc-people add-blur'>Lorem Ipsum - Dolor</span></p>" +
                        "</div>" +
                        "<div class='col col-lg-6'>" +
                        "<p><i class='fas fa-lock'></i> Carrier: <span class='add-blur'>Janosni</span></p>" +
                        "<p><i class='fas fa-lock'></i> Line Type: <span class='add-blur'>Sit Dolor</span></p>" +
                        "<p><i class='fas fa-lock'></i> Alternate Number: <span class='add-blur'>34068453968</span></p>" +
                        "<p><i class='fas fa-lock'></i> Is commercial: <span class='add-blur'>NO</span></p>" +
                        "<p><i class='fas fa-lock'></i> Is valid: <span class='add-blur'>YES</span></p>" +
                        "<p><i class='fas fa-lock'></i> Is prepaid: <span class='add-blur'>N/A</span></p>" +
                        "</div>" +
                        "<div class='col-12'><div class='unlock-div text-center'><a href='/create-account?nr_search=" + response.phone_data + "' class='text-center justify-content-center unlock-button btn btn-info btn-lg mb-1'><i class='fas fa-unlock'></i> Unlock for $1</a></div></div>");
                }
                $("div.search-loader").addClass('d-none');
            } else {
                Swal.fire({
                    title: 'Not found',
                    text: 'Try with another number',
                    type: 'info'
                }).then(function () {
                        location.reload();
                    }
                );
            }
        }
    });
});

// Request Cancel Function
$('#request-cancel').on('click', function (e) {
    e.preventDefault();
    var user_id = $(this).data('user-id');
    var agreement_id = $(this).data('agreement-id');

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want request cancel your subscription?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '/request-cancel',
                data: {
                    user_id: user_id,
                    agreement_id: agreement_id,
                },
                success: function (response) {
                    if (response.success) {
                        console.log('success');

                        Swal.fire({
                            title: 'Success',
                            text: 'Your request was registered.\nOur agents will review it.',
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

// Registered User Buy Subscription
$('#subscription-cancel').on('click', function (e) {
    e.preventDefault();
    var user_id = $(this).data('user-id');
    var agreement_id = $(this).data('agreement-id');

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to cancel your subscription?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.value) {

            Swal.fire(
                'Please wait...',
                'Contacting Paypal...',
                'warning'
            );
            Swal.showLoading();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '/subscription-cancel',
                data: {
                    user_id: user_id,
                    agreement_id: agreement_id,
                },
                success: function (response) {
                    if (response.success) {
                        console.log('success');

                        Swal.fire({
                            title: 'Success',
                            text: 'Your subscription was cancelled.',
                            type: 'success'
                        }).then(function () {
                                location.reload();
                            }
                        );
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Please try again!',
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

// User Cancel Subscription
$('.subscribe-now').on('click', function (e) {
    e.preventDefault();
    var user_id = $(this).data('user-id');
    var plan_id = $(this).data('plan-id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You will be redirected to paypal",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, subscribe!'
    }).then((result) => {
        if (result.value) {

            Swal.fire(
                'Please wait...',
                'Connecting with Paypal...',
                'warning'
            );
            Swal.showLoading();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '/subscribe-now',
                data: {
                    user_id: user_id,
                    plan_id: plan_id,
                },
                success: function (response) {
                    if (response.success) {
                        console.log('success');
                        window.location.href = response.approvalUrl;
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Please try again!',
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



