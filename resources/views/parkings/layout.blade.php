<!DOCTYPE html>

<html>
<head>
    <title>Parking System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    @yield('content')
</div>
</body>
<script>
    $(document).ready(function () {

        /* When click New parking button */
        $('#new-parking').click(function () {
            $('#btn-save').val("create-parking");
            $('#parking').trigger("reset");
            $('#parkingCrudModal').html("Add New parking");
            $('#crud-modal').modal('show');
        });

        /* Edit parking */
        $('body').on('click', '#edit-parking', function () {
            var parking_id = $(this).data('id');
            var now = new Date().toJSON();
            $.get('parkings/' + parking_id + '/edit', function (data) {
                $('#parkingCrudModal').html("Edit parking");
                $('#btn-update').val("Update");
                $('#btn-save').prop('disabled', false);
                $('#crud-modal').modal('show');
                $('#parking_id').val(data.id);
                $('#kode_tiket').val(data.kode_tiket);
                $('#jenis_kendaraan').val(data.jenis_kendaraan);
                $('#plat_no_1').val(data.plat_no_1);
                $('#plat_no_2').val(data.plat_no_2);
                $('#plat_no_3').val(data.plat_no_3);
                $('#created_at').val(data.created_at);
                $('#updated_at').val(now);
            })
        });

        /* Show parking */
        $('body').on('click', '#show-parking', function () {
            $('#parkingCrudModal-show').html("Parking Details");
            $('#crud-modal-show').modal('show');
        });

        /* Delete parking */
        $('body').on('click', '#delete-parking', function () {
            var parking_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "http://localhost:8000/parkings/" + parking_id,
                data: {
                    "id": parking_id,
                    "_token": token,
                },
                success: function (data) {
                    $('#msg').html('Data deleted successfully');
                    $("#parking_id_" + parking_id).remove();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

    });

</script>
</html>
