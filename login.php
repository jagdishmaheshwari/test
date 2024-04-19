<?php
include ('session.php');
$ActivePage = "profile";
include ('header.php');
include ('validator.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['full_name'])) {
        $errors = [];
        $Password = isset($_POST['password']) ? filterInput($_POST['password']) : null;
        $Password = sha1($Password);
        $FullName = isset($_POST['full_name']) ? filterInput($_POST['full_name']) : null;
        $Gender = isset($_POST['gender']) ? filterInput($_POST['gender']) : null;
        $Mobile = isset($_POST['mobile_no']) ? filterInput($_POST['mobile_no']) : null;
        $Email = isset($_POST['email']) ? filterInput($_POST['email']) : null;

        // Validate OTP input
        $OTP = '';
        if (isset($_POST['otp_inp']) && is_array($_POST['otp_inp'])) {
            foreach ($_POST['otp_inp'] as $otp_inp) {
                $OTP .= filterInput($otp_inp);
            }
        }

        if (!$Password || !$FullName || !$Gender || !$Mobile || !$Email || !$OTP) {
            $errors[] = "All fields are required.";
        }

        if ($OTP != $_SESSION['VerificationCode']) {
            $errors[] = "Invalid OTP. Please try again.";
        }

        if (empty($errors)) {

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare SQL statement using a prepared statement
            $sql = "INSERT INTO users (password, full_name, gender, phone_number, email)
                VALUES (?, ?, ?, ?, ?)";

            // Bind parameters and execute prepared statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $Password, $FullName, $Gender, $Mobile, $Email);
            $stmt->execute();

            // Check if insertion was successful
            if ($stmt->affected_rows > 0) {
                echo "User details inserted successfully.";
            } else {
                echo "Error: Unable to insert user details.";
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
        } else {
            // Display errors if validation failed
            foreach ($errors as $error) {
                // echo $error . "<br>";

            }
        }
    } else {
        $loginIdentifier = isset($_POST['login_identifier']) ? filterInput($_POST['login_identifier']) : null;
        $password = isset($_POST['password']) ? filterInput($_POST['password']) : null;

        // Check if login identifier (email or mobile number) and password are provided
        if (!$loginIdentifier || !$password) {
            echo "Both login identifier and password are required.";
            exit;
        }

        // Database connection parameters
        $servername = "your_database_servername";
        $username = "your_database_username";
        $password_db = "your_database_password";
        $dbname = "your_database_name";

        // Create database connection
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM users WHERE email = ? OR phone_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $loginIdentifier, $loginIdentifier);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                echo "Login successful. Welcome, " . $user['full_name'];
            } else {
                echo "Incorrect password. Please try again.";
            }
        } else {
            echo "User not found. Please check your login credentials.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<style>
    .otp-input {
        display: flex;
        justify-content: space-between;
        width: 200px;
    }

    .otp-input input {
        text-align: center;
        width: 40px;
        height: 40px;
        font-size: 1.5rem;
        margin: 0 3px
    }
</style>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>Something went wrong! Please try again
</div>
<div class="d-flex justify-content-center align-items-center " style="height:85vh">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-4">
                <div class="card p-4" id="login_form-container" style="display:none">
                    <h2 class="text-center mb-4">Login</h2>
                    <form id="login_form" method="POST" action="">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <p class="text-center mt-3">Don't have an account? <a href="#" id="show-register">Register</a></p>
                </div>

                <div class="card p-4" id="register_form-container" style="display: nonse;">
                    <h2 class="text-center mb-4">Register</h2>
                    <form id="register_form" method="POST" action="">
                        <div class="mb-3">
                            <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="mobile_no" class="form-control"
                                placeholder="Mobile Number (e.g., 1234567890)" pattern="[1-9][0-9]{9}" required>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Email Address" required>
                                <div class="input-group-text text-primary c-pointer" id="verify_email_btn">Verify</div>
                            </div>
                        </div>
                        <div class="OtpContainer" style="display:none">
                            <div class="otp-input mb-2" id="OtpInputContainer"></div>
                            <i>Enter OTP we have sent you on email.</i>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Enter Password"
                                required>
                        </div>
                        <input type="submit" name="register_btn" id="register_btn" class="btn btn-secondary w-100"
                            value="Register">
                    </form>
                    <p class="text-center mt-3">Already have an account? <a href="#" id="show-login">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#show-register').click(function (e) {
                e.preventDefault();
                $('#login_form-container').slideUp(300, function () {
                    $('#register_form-container').slideDown(300);
                });
            });
            $('#show-login').click(function (e) {
                e.preventDefault();
                $('#register_form-container').slideUp(300, function () {
                    $('#login_form-container').slideDown(300);
                });
            });

            $('#login_form').submit(function (e) {
                e.preventDefault();
                alert('Perform login logic here!');
            });

            $('#register_form').submit(function (e) {
                e.preventDefault();
                // alert('Perform registration logic here!');
                this.submit();
            });
        });
    </script>
    <script>
        $('#verify_email_btn').on('click', function () {
            email = $('#email').val();
            if (email != "") {
                $(this).html('<span class="fa fa-spin fa-spinner"></span>');
                $.ajax({
                    type: 'POST',
                    url: 'mail/index',
                    data: { email: email },
                    success: function (response) {
                        if (response.trim() === 'Success') {
                            swal({ text: "Successfully sent OTP to Your !", icon: "success" });
                            showOtpInput();
                        } else {
                            swal("Failed to send Otp!");
                        };
                    }
                });
            } else {
                swal('Please Enter Email Address!');
            }
        });
    </script>
    <script>
        function showOtpInput() {
            const numDigits = 6;
            const OtpInputContainer = $('#OtpInputContainer');
            for (let i = 0; i < numDigits; i++) {
                const input = $('<input>').attr({
                    type: 'text',
                    maxlength: 1,
                    class: 'form-control',
                    name: 'otp_inp[' + i + ']'
                });
                input.on('input', function () {
                    const currentInput = $(this);
                    const currentValue = currentInput.val();
                    if (currentValue) {
                        const nextInput = currentInput.next('input');
                        if (nextInput.length > 0) {
                            nextInput.focus();
                        }
                    } else {
                        const prevInput = currentInput.prev('input');
                        if (prevInput.length > 0) {
                            prevInput.val('').focus();
                        }
                    }
                });
                OtpInputContainer.append(input);
            }
            $('.OtpContainer').css('display', 'block');
            $('#register_btn').addClass('bg-success').removeClass('bg-secondary');
            $('#verify_email_btn').css('display', 'none').removeClass('input-group-text');
            $('.input-group').removeClass('input-group');
            email = $('#email').attr('readonly', true).addClass('bg-light');
            OtpInputContainer.find('input:first').focus();
        };
    </script>
</div>