<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('header.php'); ?>
    <div class="container dashboard-container">
        <div class="row">
            <!-- <div class="col-md-4">
                <div class="dashboard-option" onclick="window.location='manage_products'">
                    <i class="fas fa-box"></i>
                    <h5>Manage Products</h5>
                </div>
            </div> -->
            <div class="col-md-4">
                <div class="dashboard-option" onclick="window.location = ('manage_category')">
                    <i class="fas fa-box"></i>
                    <h5> Manage Collection</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option" onclick="window.location = ('manage_stock')">
                    <i class="fas fa-box-open"></i>
                    <h5>Stock Management</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-shopping-cart"></i>
                    <h5>Order Management</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option" onclick="window.location='manage_colors'">
                    <i class="fa fa-circle text-pri rounded-circle"></i>
                    <i class="fa fa-circle text-sec rounded-circle"></i>
                    <i class="fa fa-circle text-acc rounded"></i>
                    <h5>Manage Colors</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option" onclick="window.location='visitors_analysis'">
                    <i class="fa fa-bar-chart" style="font-size:70px"></i>
                    <h5>Visitor Analysis</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-chart-bar"></i>
                    <h5>Sales Overview</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-users"></i>
                    <h5>Customer Management</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-inr"></i>
                    <h5>Revenue Insights</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option" onclick="window.location=('manage_queries')">
                    <i class="fas fa-question-circle"></i>
                    <h5>Manage Queries</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-chart-pie"></i>
                    <h5>Category Analysis</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <!-- <i class="fa-solid fa-comment-question"></i> -->
                    <i class="fa fa-comments"></i>
                    <h5>Customer Queries</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-comment-alt"></i>
                    <h5>Customer Feedback</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-cogs"></i>
                    <h5>Settings</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-money-bill-alt"></i>
                    <h5>Manage Price & Offers</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option">
                    <i class="fas fa-shopping-bag"></i>
                    <h5>View Recent Orders</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option" onclick="window.location='manage_sizes'">
                    <i class="fas fa-ruler"></i>
                    <h5>Manage Sizes</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-option" onclick="window.location='download_backup'">
                    <i class="fas fa-download"></i>
                    <h5>Download Backup</h5>
                </div>
            </div>
        </div>
    </div>



<?php include('footer.php'); ?>






    <?php
} else {
    header('location: login');
}


?>