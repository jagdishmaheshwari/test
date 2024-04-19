<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('header.php');
    include('../conn.php');
    ?>


    <div class="container mt-5">
        <h2 class="mb-4">Manage Sizes <button class="btn btn-success mb-3" data-bs-toggle="modal"
                data-bs-target="#addSizeModal"><i class="fa fa-plus"></i> Add Size</button>
        </h2>
        <table class="table table-bordered sizeTable">
            <thead>
                <tr>
                    <th>Size ID</th>
                    <th>Size Name</th>
                    <th>Size Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM size_list WHERE 1=1 ";
                $search = @$_GET['search'];
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['size_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['size_name'] ?>
                            </td>
                            <td>
                                <?php echo $row['size_code'] ?>
                            </td>
                            <td>
                                <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSizeModal"
                                    onclick="$('#editSizeForm #sizeName').val('<?php echo $row['size_name'] ?>');$('#editSizeForm #sizeId').val('<?php echo $row['size_id'] ?>');$('#editSizeForm #sizeCode').val('<?php echo $row['size_code'] ?>');">
                                    <i class="fa fa-edit"></i> Edit
                                </div>
                                <div class="btn btn-danger" onclick="deleteSize('<?php echo $row['size_id'] ?>')"><i
                                        class="fa fa-trash"></i> Delete</div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><th colspan='4'>No Sizes Available</th><tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Size Modal -->
    <div class="modal fade" id="addSizeModal" tabindex="1" aria-labelledby="addSizeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSizeModalLabel">Add Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Size Form -->
                    <form id="addSizeForm">
                        <div class="mb-3">
                            <label for="sizeName" class="form-label">Size Description:</label>
                            <input type="text" class="form-control" id="sizeName" name="size_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="sizeCode" class="form-label">Size Code:</label>
                            <input type="text" class="form-control" id="sizeCode" name="size_code" required>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary float-end" onclick="addSize()">Add Size</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit size Modal -->
    <div class="modal fade" id="editSizeModal" tabindex="-1" aria-labelledby="editSizeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSizeModalLabel">Edit Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit size Form -->
                    <form id="editSizeForm">
                        <div class="mb-3">
                            <label for="sizeName" class="form-label">Size Name:</label>
                            <input type="text" class="form-control" id="sizeName" name="size_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="sizeCode" class="form-label">Size Code:</label>
                            <input type="text" class="form-control" id="sizeCode" name="size_code" required>
                            <input type="hidden" name="sizeId" id="sizeId" value="">
                        </div>
                        <div>
                            <input type="button" class="btn btn-primary float-end" onclick="updateSize()"
                                value="Update This Size">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateSize() {
            // Fetch data from the form
            var sizeId = $('#editSizeModal #sizeId').val();
            var sizeName = $('#editSizeModal #sizeName').val();
            var sizeCode = $('#editSizeModal #sizeCode').val();

            // Check if size name and code are not empty
            if (sizeName.trim() === '' || sizeCode.trim() === '' || sizeId.trim() === '') {
                swal('Please enter size name and code.');
            }

            // Make AJAX request to add size
            $.ajax({
                type: 'POST',
                url: 'action_sizes', // Replace with your server-side script URL
                data: {
                    action: 'update_size',
                    size_id: sizeId,
                    size_name: sizeName,
                    size_code: sizeCode
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        swal({ title: 'Size Updated successfully!', icon: 'success' }).then(function () {
                            window.location.reload();
                        });
                    } else {
                        swal({ title: 'Failed to update size. Please try again.' }).then(function () {
                            window.location.reload();
                        });;
                    }
                },
                error: function () {
                    swal('An error occurred while Updating size. Please try again later.').then(function () {
                        window.location.reload();
                    });
                }
            });
        }
    </script>
    <!-- Bootstrap JS and Popper.js (Bootstrap 5 requires Popper.js) -->
    <script>
        function addSize() {
            // Fetch data from the form
            var sizeName = $('#addSizeForm #sizeName').val();
            var sizeCode = $('#addSizeForm #sizeCode').val();

            // Check if size name and code are not empty
            if (sizeName.trim() === '' || sizeCode.trim() === '') {
                swal('Please enter size name and code.');
                return;
            }

            // Make AJAX request to add size
            $.ajax({
                type: 'POST',
                url: 'action_sizes',
                data: {
                    action: 'add_size',
                    size_name: sizeName,
                    size_code: sizeCode
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        swal({ title: 'Size added successfully!', icon: 'success' }).then(function () {
                            window.location.reload();
                        }); // Refresh the size list
                    } else {
                        swal('Failed to add size. Please try again.').then(function () {
                            window.location.reload();
                        });;
                    }
                },
                error: function () {
                    swal('An error occurred while adding size. Please try again later.').then(function () {
                        window.location.reload();
                    });
                }
            });
        }
    </script>
    <script>
        // Function to handle size deletion
        function deleteSize(sizeId) {
            swal({
                title: "Are you sure?",
                text: "This action cannot be undone.",
                icon: "warning",
                buttons: ["Cancel", "Confirm"],
                dangerMode: true,
            }).then((isConfirmed) => {
                if (isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'action_sizes', // Replace with your server-side script URL
                        data: { action: 'delete_size', size_id: sizeId },
                        success: function (response) {
                            if (response.trim() === 'success') {
                                swal({ title: 'Size deleted successfully!', icon: 'success' }).then(function () {
                                    window.location.reload();
                                });
                            } else {
                                swal({ title: 'Something went wrong?', text: 'Failed to delete size. Please try again.', icon: 'error' });
                            }
                        },
                        error: function () {
                            swal('An error occurred while deleting size. Please try again later.');
                        }
                    });
                }
            });
        }

    </script>
<?php include ('footer.php'); ?>
    <?php
} else {
    header('location: login');
}


?>