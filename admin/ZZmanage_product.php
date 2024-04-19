<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('header.php');
    include ('../conn.php');
    include ('../validator.php');
    ?>
    <div class="container-fluid mt-5">
        <?php
        if (isset ($_GET['productId']) & $_GET['productId'] != null) {
            $productId = $_GET['productId'];
            $row = getDetails($conn)[0];
            if ($row) {
                ?>
                <div class="px-5">
                    <div class="text-center h2" style="font-family:math">
                        <?php echo $row['category_name'] . " > " . $row['product_name'] ?>
                    </div>
                    <div class="h5">
                        <b>Description : </b>
                        <?php echo $row['p_description'] ?>
                    </div>
                    <div class="h5">
                        <b>Keywords : </b>
                        <?php echo $row['keywords'] ?>
                        <div class="btn btn-success"
                            onclick="window.location=('manage_items?productId=<?php echo $row['product_id'] ?>&categoryId=<?php echo $row['category_id'] ?>')">
                            <i class="fa fa-bars"></i> Manage Item
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <form id="addSpecificationForm" class="col-12 col-md-5">
                            <h4 class="text-center">Add Specifications</h4>
                            <div class="form-floating">
                                <input type="text"
                                    oninput="$('#priority').val($('#n_list option[value=' + this.value + ']').text().trim())"
                                    list="n_list" id="name" autocomplete="off" placeholder="Select option" class="form-control"
                                    required>
                                <label for="">Specification Name (Ex. Made In)</label>
                            </div>
                            <div class="form-floating mt-2">
                                <input type="text" list="v_list" autocomplete="off" id="value" placeholder class="form-control"
                                    required>
                                <label for="">Specification Value (Ex. India)</label>
                            </div>
                            <input type="hidden" id="productId" value="<?php echo $row['product_id'] ?>">
                            <input type="number" min="0" class="d-none" id="priority">
                            <input type="submit" class="btn w-100 btn-primary mt-3" value="Add Specification">
                        </form>
                        <datalist id="n_list">
                            <?php
                            $nSql = "SELECT priority, name FROM product_specifications GROUP BY name";
                            // SELECT DISTINCT priority, name FROM product_specifications GROUP BY name
                            $nResult = $conn->query($nSql);
                            while ($nRow = $nResult->fetch_assoc()) { ?>
                                <option value="<?php echo $nRow['name'] ?>">
                                    <?php echo trim($nRow['priority']); ?>
                                </option>
                                <?php
                            }
                            ?>
                        </datalist>
                        <datalist id="v_list">
                            <?php
                            $vSql = "SELECT DISTINCT value FROM product_specifications";
                            $vResult = $conn->query($vSql);
                            while ($vRow = $vResult->fetch_assoc()) { ?>
                                <option value="<?php echo $vRow['value'] ?>">
                                    <?php
                            }
                            ?>
                        </datalist>
                        <div class="col-12 col-md-6">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Priority</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $productId = $_GET['productId'];
                                $specificationRow = getProductSpecification($conn, $productId);
                                foreach ($specificationRow as $specificationRow) {
                                    ?>
                                    <tr>
                                        <td style="min-width:165px">
                                            <div class="btn text-danger fa fa-caret-down"
                                                onclick="editPriority('product_specifications','specification_id','<?php echo $specificationRow['specification_id'] ?>','plus')">
                                            </div>
                                            <div class="btn">
                                                <?php echo $specificationRow['priority'] ?>
                                            </div>
                                            <div class="btn text-success fa fa-caret-up"
                                                onclick="editPriority('product_specifications','specification_id','<?php echo $specificationRow['specification_id'] ?>','minus')">
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $specificationRow['name'] ?>
                                        </td>
                                        <td>
                                            <?php echo $specificationRow['value'] ?>
                                        </td>
                                        <td>
                                            <div class="btn btn-danger"
                                                onclick="deleteSpecification(<?php echo $specificationRow['specification_id'] ?>)">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <script>
                    $('#addSpecificationForm').on('submit', function () {
                        event.preventDefault();
                        var productId = $('#addSpecificationForm #productId').val();
                        var name = $('#addSpecificationForm #name').val();
                        var value = $('#addSpecificationForm #value').val();
                        var priority = $('#addSpecificationForm #priority').val();
                        if (productId.trim() === '' || name.trim() === '' || value.trim() === '') {
                            swal('Please fill required details!');
                            return;
                        }
                        $.ajax({
                            type: 'POST',
                            url: 'action_specification',
                            data: {
                                action: 'add_specification',
                                priority: priority,
                                productId: productId,
                                name: name,
                                value: value
                            },
                            success: function (response) {
                                if (response.trim() === 'success') {
                                    swal({ title: "Specification added successfully!", icon: "success" }).then(function () {
                                        window.location.reload();
                                    });
                                } else {
                                    swal("Failed to add Specification. Please try again." + response);
                                };
                            },
                            error: function () {
                                swal("An error occurred while adding product. Please try again later.").then(function () {
                                    window.location.reload();
                                });
                            }
                        });
                    });
                </script>
                <script>
                    function deleteSpecification(specificationId) {
                        var productId = <?php echo $_GET['productId'] ?>;
                        if (specificationId === '' || productId === '') {
                            swal('Please fill required details!');
                            return;
                        }
                        $.ajax({
                            type: 'POST',
                            url: 'action_specification',
                            data: {
                                action: 'delete_specification',
                                productId: productId,
                                specificationId: specificationId,
                            },
                            success: function (response) {
                                if (response.trim() === 'success') {
                                    swal({ title: "Specification Deleted successfully!", icon: "success" }).then(function () {
                                        window.location.reload();
                                    });
                                } else {
                                    swal("Failed to add Specification. Please try again." + response);
                                };
                            }
                        });
                    };
                </script>
                <?php
            } else {
                echo "<script>swal('Something went Wrong').then(function (){window.history.go(-1)});</script>";
            }
        } else {
            echo "<script>swal('Something went Wrong').then(function (){window.history.go(-1)});</script>";
        }
        ?>
    </div>
<?php include ('footer.php'); ?>
    <?php
} else {
    header('location: login');
}

?>