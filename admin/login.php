<?php
include('admin_session.php');
if (!isset($_SESSION['AdminID'])) {
    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kachchh Kala | Admin</title>
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
        <script src="../src/js/jquery.js"></script>
    </head>

    <body style="height:100vh;width:100vw;display:flex;" class="">
        <div class=" m-auto">
            <div class="card p-3 " style="width:500px">
                <form action="login" method="POST">
                    <h1 class="text-center">Admin Login</h1>
                    <hr>
                    <div>
                        <label class="h5" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                            required>
                    </div>
                    <div class="mt-2">
                        <label class="h5" for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter Password" name="password"
                            class="form-control" required>
                    </div>
                    <input type="submit" class="btn btn-primary w-100 mt-4">
                </form>
            </div>
        </div>
    </body>

    </html>

    <?php
}else{
    header('location: dashboard');
}
if (isset($_POST['username']) && isset($_POST['password'])) {
    include('admin_session.php');
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin') {
        $_SESSION['AdminID'] = "1";
        header('location: dashboard');
    }
}
?>