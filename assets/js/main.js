$(document).ready(function () {

    // 🔥 Initialize Raty (on page load)
    $('.rating').each(function () {
        $(this).raty({
            readOnly: true,
            score: $(this).attr('data-score'),
            half: true,
            path: 'assets/plugins/raty/images'
        });
    });


    // 🔥 ADD BUSINESS
    $('#addBusinessForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'ajax/add_business.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {

                let data = JSON.parse(response);

                if (data.status == 'success') {

                    $('#addModal').modal('hide');
                    $('#addBusinessForm')[0].reset();

                    $('#businessTable').append(data.row_html);

                    // Re-init raty for new row
                    $('#businessTable tr:last .rating').raty({
                        readOnly: true,
                        half: true,
                        path: 'assets/plugins/raty/images'
                    });

                } else {
                    alert(data.message);
                }
            }
        });
    });

});


// 🔥 EDIT BUTTON CLICK (outside ready for dynamic elements)
$(document).on('click', '.editBtn', function () {

    let row = $(this).closest('tr');

    let id = $(this).data('id');
    let name = row.find('td:eq(1)').text();
    let address = row.find('td:eq(2)').text();
    let phone = row.find('td:eq(3)').text();
    let email = row.find('td:eq(4)').text();

    $('#edit_id').val(id);
    $('#edit_name').val(name);
    $('#edit_address').val(address);
    $('#edit_phone').val(phone);
    $('#edit_email').val(email);

    $('#editModal').modal('show');
});


// 🔥 UPDATE BUSINESS
$('#editBusinessForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        url: 'ajax/update_business.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {

            let data = JSON.parse(response);

            if (data.status == 'success') {

                let row = $('#row_' + data.id);

                row.find('td:eq(1)').text(data.name);
                row.find('td:eq(2)').text(data.address);
                row.find('td:eq(3)').text(data.phone);
                row.find('td:eq(4)').text(data.email);

                $('#editModal').modal('hide');

            } else {
                alert(data.message);
            }
        }
    });
});

$(document).on('click', '.deleteBtn', function () {

    let id = $(this).data('id');

    if (confirm('Are you sure you want to delete this business?')) {

        $.ajax({
            url: 'ajax/delete_business.php',
            type: 'POST',
            data: { id: id },
            success: function (response) {

                let data = JSON.parse(response);

                if (data.status == 'success') {
                    $('#row_' + id).remove();
                } else {
                    alert(data.message);
                }
            }
        });

    }
});

// 🔥 RATE BUTTON CLICK
$(document).on('click', '.rateBtn', function () {

    let id = $(this).data('id');

    $('#rating_business_id').val(id);
    $('#ratingModal').modal('show');

    $('#ratingStar').raty({
        half: true,
        path: 'assets/plugins/raty/images',
        click: function (score) {
            $('#rating_value').val(score);
        }
    });
});


// 🔥 RATING FORM SUBMIT (OUTSIDE)
$('#ratingForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        url: 'ajax/add_rating.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {

            let data = JSON.parse(response);

            if (data.status == 'success') {

                $('#ratingModal').modal('hide');
                $('#ratingForm')[0].reset();

                let ratingDiv = $('#row_' + data.business_id + ' .rating');

                ratingDiv.raty('destroy');

                ratingDiv.attr('data-score', data.avg_rating);

                ratingDiv.raty({
                    readOnly: true,
                    score: data.avg_rating,
                    half: true,
                    path: 'assets/plugins/raty/images'
                });

            } else {
                alert(data.message);
            }
        }
    });
});