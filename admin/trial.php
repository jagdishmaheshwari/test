<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('../conn.php');
    include ('header.php');
    ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Priority</th>
            <th>Name</th>
            <th>Value</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "WITH topProduct AS (
    SELECT
        item_list.category_id,
        item_list.product_id,
        product_list.product_name,
        category_list.category_name,
        ROW_NUMBER() OVER (PARTITION BY item_list.category_id ORDER BY product_list.priority ASC) AS product_priority
    FROM 
        item_list
    LEFT JOIN 
        product_list ON product_list.product_id = item_list.product_id
    LEFT JOIN 
        category_list ON category_list.category_id = item_list.category_id
),
topItem AS (
    SELECT 
        item_list.category_id,
        item_list.product_id,
        item_list.item_id,
        product_list.product_name,
        category_list.category_name,
        ROW_NUMBER() OVER (PARTITION BY item_list.category_id, item_list.product_id ORDER BY item_list.priority ASC) AS item_priority
    FROM 
        item_list
    LEFT JOIN 
        product_list ON product_list.product_id = item_list.product_id
    LEFT JOIN 
        category_list ON category_list.category_id = item_list.category_id
)
SELECT 
    P.category_id,
    P.product_id,
    P.product_name,
    I.item_id,
    I.category_name
FROM 
    topProduct P
JOIN 
    topItem I ON P.category_id = I.category_id AND P.product_id = I.product_id
WHERE 
    P.product_priority = 1 AND I.item_priority = 1;
        ;";
        $result = $conn->query($sql);
        while (@$row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td>
                    <?php echo @$row['category_id'] ?>
                </td>
                <td>
                    <?php echo @$row['item_id'] ?>
                </td>
                <td>
                    <?php echo @$row['category_name'] ?>
                </td>
                <td>
                    <?php echo @$row['product_name'] ?>
                </td>
                <td>
                </td>
            </tr>
            <?php
        }
        ?>

    </table>

    <div class="container">
        <!-- <?php print_r(getDetails($conn)); ?> -->
        <table>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <!-- <?php foreach (getDetails($conn) as $details) {
                ?>
                <tr>
                    <td>
                        <?php echo $details['item_id'] ?>
                    </td>
                </tr>
            <?php } ?>
        </table> -->
    </div>

    <?php

    print_r(getDetails($conn));
    
    
    
    ?>

<?php
} else {
    header('location: login');
}
?>