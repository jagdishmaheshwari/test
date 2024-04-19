<?php
$ActivePage = "collection";
include ('header.php');
$itemDetails = getDetails($conn,  "1=1 ORDER BY category_id DESC");
// $itemDetails = getDetails($conn, "1=1 ORDER BY category_id DESC", productsCondition: " 1=1 GROUP BY product_list.category_id ORDER BY product_list.priority", itemCondition: "item_list.visible = 1 ORDER BY item_list.priority LIMIT 1");
?>
<div>
    <div class="row row-cols-lg-3 row-cols-sm-2 collection">
        <?php
        foreach ($itemDetails as $itemDetails) {
            if ($itemDetails['item_images'] != null) {
                ?>
                <div class="card mb-1 position-relative">
                    <div class="image-container rounded-1 overflow-hidden position-absolutes">
                        <div class="loading-animation"></div>
                        <img User loading="lazy" src="assets/item_images/<?php echo $itemDetails['item_images'][0]; ?>"
                            onerror="$(this).hide();$('.image<?php echo ''; ?>').show()" class="">
                    </div>
                    <div class="description">
                        <?php echo $itemDetails['c_description'] ?>
                    </div>
                </div>
            <?php }
        }
        ?>
    </div>
</div>
<?php
include ('footer.php'); ?>