<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('header.php');
    include ('../conn.php');
    ?>


    <div class="container mt-5 overflow-scroll">
        <h2 class="mb-4">Manage Categories <button class="btn btn-success mb-3" data-bs-toggle="modal"
                data-bs-target="#addCategoryModal"><i class="fa fa-plus"></i> Add Category</button>
        </h2>
        <table class="table table-bordered table-striped" id="categoryTable">
            <thead class="bg-grey">
                <tr>
                    <th style="max-width:20px">ID</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM category_list WHERE 1=1 ";
                $search = @$_GET['search'];
                if (isset ($search)) {
                    $sql .= " AND category_name LIKE '%{$search}%' OR description LIKE '%{$search}%'";
                }
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['category_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['category_name'] ?>
                            </td>
                            <td>
                                <?php echo $row['description'] ?>
                            </td>
                            <td style="width:175px !important">
                                <div class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                    onclick="$('#editCategoryForm #categoryName').val('<?php echo $row['category_name'] ?>');$('#editCategoryForm #categoryId').val('<?php echo $row['category_id'] ?>');$('#editCategoryForm #categoryCode').val('<?php echo $row['description'] ?>');">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <div class="btn btn-danger mt-1" onclick="deleteCategory('<?php echo $row['category_id'] ?>')"><i
                                        class="fa fa-trash"></i></div>
                                <div class="btn btn-success w-100 mt-1"
                                    onclick="window.location=('manage_products?categoryId=<?php echo $row['category_id'] ?>')"><i
                                        class="fa fa-stream"></i></div>
                            </td>
                        </tr>
                        <style>
                            .categoryTable i.fa-square:hover {
                                scale: 10;
                                transition: 2s;
                            }
                        </style>
                        <?php
                    }
                } else {
                    echo "<tr><th colspan='4'>No Categorys Available</th><tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Category Form -->
                    <form id="addCategoryForm">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" id="categoryName" name="category_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoryCode" class="form-label">Description:</label>
                            <input type="category" class="form-control" id="categoryCode" name="description"
                                style="height:70px !important" required>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary float-end" onclick="addCategory()">Add
                                Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Category Form -->
                    <form id="editCategoryForm">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" id="categoryName" name="category_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoryCode" class="form-label">Description:</label>
                            <input type="category" class="form-control" id="categoryCode" name="description"
                                style="height:70px !important" value="" required>
                            <input type="hidden" name="categoryId" id="categoryId" value="">
                        </div>
                        <div>
                            <input type="button" class="btn btn-primary float-end" onclick="updateCategory()"
                                value="Update This Category">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#categoryTable').DataTable();
    </script>
    <script>
        function updateCategory() {
            // Fetch data from the form
            var categoryId = $('#editCategoryModal #categoryId').val();
            var categoryName = $('#editCategoryModal #categoryName').val();
            var categoryCode = $('#editCategoryModal #categoryCode').val();

            // Check if category name and code are not empty
            if (categoryName.trim() === '' || categoryCode.trim() === '' || categoryId.trim() === '') {
                swal('Please enter category name and code.');
            }

            // Make AJAX request to add category
            $.ajax({
                type: 'POST',
                url: 'action_category', // Replace with your server-side script URL
                data: {
                    action: 'update_category',
                    categoryId: categoryId,
                    categoryName: categoryName,
                    description: categoryCode
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        swal({ title: 'Category Updated successfully!', icon: 'success' }).then(function () {
                            window.location.reload();
                        });
                    } else {
                        swal({ title: 'Failed to update category. Please try again.' }).then(function () {
                            window.location.reload();
                        });;
                    }
                },
                error: function () {
                    swal('An error occurred while Updating category. Please try again later.').then(function () {
                        window.location.reload();
                    });
                }
            });
        }
    </script>
    <script>
        function addCategory() {
            // Fetch data from the form
            var categoryName = $('#addCategoryForm #categoryName').val();
            var categoryCode = $('#addCategoryForm #categoryCode').val();

            // Check if category name and code are not empty
            if (categoryName.trim() === '' || categoryCode.trim() === '') {
                swal('Please enter category name and code.');
                return;
            }

            // Make AJAX request to add category
            $.ajax({
                type: 'POST',
                url: 'action_category', // Replace with your server-side script URL
                data: {
                    action: 'add_category',
                    categoryName: categoryName,
                    description: categoryCode
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        swal({ title: 'Category added successfully!', icon: 'success' }).then(function () {
                            window.location.reload();
                        }); // Refresh the category list
                    } else {
                        swal('Failed to add category. Please try again.').then(function () {
                            window.location.reload();
                        });;
                    }
                },
                error: function () {
                    swal('An error occurred while adding category. Please try again later.').then(function () {
                        window.location.reload();
                    });
                }
            });

        }
    </script>
    <script>
        // Function to handle category deletion
        function deleteCategory(categoryId) {
            swal({
                title: "Sure Delete Category?",
                text: "This action cannot be undone.",
                icon: "warning",
                buttons: ["Cancel", "Confirm"],
                dangerMode: true,
            }).then((isConfirmed) => {
                if (isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'action_category',
                        data: {
                            action: 'delete_category',
                            categoryId: categoryId
                        },
                        success: function (response) {
                            if (response === 'success') {
                                swal({ icon: "success", title: "Category Deleted Successfull!" }).then(function () {
                                    window.location.reload();
                                });
                            } else if (response === 'data') {
                                swal({ icon: "info", title: "There are some products associated with this category!" })
                            } else {
                                swal({ icon: "error", title: "Something went wrong please try again leterrrrr!!" })
                            }
                        },
                        error: function () {
                            swal({ icon: "error", title: "Something went wrong please try again!" })
                        }
                    });
                }
            });
        }
        
        </script>
        <?php include('footer.php'); ?>
    <?php
} else {
    header('location: login');
}

?>

<!-- 

function deleteCategory(categoryId) {
swal({
title: "Are you sure?",
text: "This action cannot be undone.",
icon: "warning",
buttons: ["Cancel", "Confirm"],
dangerMode: true,
}).then((isConfirmed) => {
$.ajax({
type: 'POST',
url: 'action_delete_category.php',
data: { category_id: categoryId },
success: function (response) {
if (response === 'success') {
swal({ icon: "success", title: "Category Deleted Successfull!" }).then(function (){
window.location.reload();
});
} else if (response === 'data') {
swal({ icon: "info", title: "There are some products associated with this category!" })
} else {
swal({ icon: "error", title: "Something went wrong please try again leterrrrr!!" })
}
},
error: function () {
swal({ icon: "error", title: "Something went wrong please try again!" })
}
});
});
} -->