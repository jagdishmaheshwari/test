<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('header.php');
    include('../conn.php');
    ?>


    <div class="container mt-5 overflow-scroll">
        <h2 class="mb-4">Manage Colors <button class="btn btn-success mb-3" data-bs-toggle="modal"
                data-bs-target="#addColorModal"><i class="fa fa-plus"></i> Add Color</button>
        </h2>
        <div class="col-10 col-lg-3 my-2 ">
            <form class="input-group" method="GET">
                <input type="text" class=" form-control bg-nue" placeholder="Search Category" name="search"
                    value="<?php echo @$_GET['search'] ?>">
                <?php if (isset($_GET['search']) && $_GET['search'] != null) { ?>
                    <div class="input-group-text bg-white border-start-0 position-sticky"><a
                            href="<?php echo $_SERVER['PHP_SELF'] ?>"><i class="fa fa-xmark text-dark"></i></a></div>
                <?php } ?>
                <button class="input-group-text"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <table class="table table-bordered colorTable">
            <thead>
                <tr>
                    <th>Color ID</th>
                    <th>Color Name</th>
                    <th>Color Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM color_list WHERE 1=1 ";
                $search = @$_GET['search'];
                if (isset($search)) {
                    $sql .= " AND color_name LIKE '%{$search}%' OR color_code LIKE '%{$search}%'";
                }
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['color_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['color_name'] ?>
                                <i class="fa fa-square" style="font-size:50px;color:<?php echo $row['color_code'] ?>"></i>
                            </td>
                            <td>
                                <?php echo $row['color_code'] ?>
                                <i class="fa fa-square"  style="font-size:50px;color:<?php echo $row['color_code'] ?>"></i>
                            </td>
                            <td>
                                <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editColorModal"
                                    onclick="$('#editColorForm #colorName').val('<?php echo $row['color_name'] ?>');$('#editColorForm #colorId').val('<?php echo $row['color_id'] ?>');$('#editColorForm #colorCode').val('<?php echo $row['color_code'] ?>');">
                                    <i class="fa fa-edit"></i> Edit
                                </div>
                                <div class="btn btn-danger" onclick="deleteColor('<?php echo $row['color_id'] ?>')"><i
                                        class="fa fa-trash"></i> Delete</div>
                            </td>
                        </tr>
                        <style>
                            .colorTable i.fa-square:hover {
                                scale: 10;
                                transition: 2s;
                            }
                        </style>
                        <?php
                    }
                } else {
                    echo "<tr><th colspan='4'>No Colors Available</th><tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Color Modal -->
    <div class="modal fade" id="addColorModal" tabindex="1" aria-labelledby="addColorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addColorModalLabel">Add Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Color Form -->
                    <form id="addColorForm">
                        <div class="mb-3">
                            <label for="colorName" class="form-label">Color Name:</label>
                            <input type="text" class="form-control" id="colorName" required>
                        </div>
                        <div class="mb-3">
                            <label for="colorCode" class="form-label">Color Code:</label>
                            <input type="color" class="form-control" id="colorCode" style="height:70px !important" required>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary float-end" onclick="addColor()">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Color Modal -->
    <div class="modal fade" id="editColorModal" tabindex="-1" aria-labelledby="editColorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editColorModalLabel">Edit Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Color Form -->
                    <form id="editColorForm">
                        <div class="mb-3">
                            <label for="colorName" class="form-label">Color Name:</label>
                            <input type="text" class="form-control" id="colorName" name="color_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="colorCode" class="form-label">Color Code:</label>
                            <input type="color" class="form-control" id="colorCode" name="color_code"
                                style="height:70px !important" value="" required>
                            <input type="hidden" name="colorId" id="colorId" value="">
                        </div>
                        <div>
                            <input type="button" class="btn btn-primary float-end" onclick="updateColor()"
                                value="Update This Color">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateColor() {
            // Fetch data from the form
            var colorId = $('#editColorModal #colorId').val();
            var colorName = $('#editColorModal #colorName').val();
            var colorCode = $('#editColorModal #colorCode').val();

            // Check if color name and code are not empty
            if (colorName.trim() === '' || colorCode.trim() === '' || colorId.trim() === '') {
                swal('Please enter color name and code.');
            }

            // Make AJAX request to add color
            $.ajax({
                type: 'POST',
                url: 'action_color', // Replace with your server-side script URL
                data: {
                    action: 'update_color',
                    colorId: colorId,
                    colorName: colorName,
                    colorCode: colorCode
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        swal({ title: 'Color Updated successfully!', icon: 'success' }).then(function () {
                            window.location.reload();
                        });
                    } else {
                        swal({ title: 'Failed to update color. Please try again.' }).then(function () {
                            window.location.reload();
                        });;
                    }
                },
                error: function () {
                    swal('An error occurred while Updating color. Please try again later.').then(function () {
                        window.location.reload();
                    });
                }
            });
        }
    </script>
    <!-- Bootstrap JS and Popper.js (Bootstrap 5 requires Popper.js) -->
    <script>
        function addColor() {
            // Fetch data from the form
            var colorName = $('#addColorForm #colorName').val();
            var colorCode = $('#addColorForm #colorCode').val();
            // Check if color name and code are not empty
            if (colorName.trim() === '' || colorCode.trim() === '') {
                swal('Please enter color name and code.');
                return;
            }

            // Make AJAX request to add color
            $.ajax({
                type: 'POST',
                url: 'action_color', // Replace with your server-side script URL
                data: {
                    action: 'add_color',
                    colorName: colorName,
                    colorCode: colorCode
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        swal({ title: 'Color added successfully!', icon: 'success' }).then(function () {
                            window.location.reload();
                        }); // Refresh the color list
                    } else {
                        swal('Failed to add color. Please try again.'+response).then(function () {
                            window.location.reload();
                        });;
                    }
                },
                error: function () {
                    swal('An error occurred while adding color. Please try again later.').then(function () {
                        window.location.reload();
                    });
                }
            });
        }
    </script>
    <script>
        // Function to handle color deletion
        function deleteColor(colorId) {
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
                        url: 'action_color', // Replace with your server-side script URL
                        data: { action: 'delete_color', colorId: colorId },
                        success: function (response) {
                            if (response.trim() === 'success') {
                                swal({ title: 'Color deleted successfully!', icon: 'success' }).then(function () {
                                    window.location.reload();
                                });
                            } else {
                                swal({ title: 'Something went wrong?', text: 'Failed to delete color. Please try again.', icon: 'error' });
                            }
                        },
                        error: function () {
                            swal('An error occurred while deleting color. Please try again later.');
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