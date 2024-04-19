<?php
include('validator.php');
include('header.php');
?>
<div class="container">
    <div class="p-3 p-md-5">
        <!-- <form> -->
        <div class="bg-acc p-3 p-md-5  rounded-4 ">
            <h1 class="text-pri text-center ">Contact Us</h1>
            <div class="form-floating">
                <input type="text" class="form-control" id="fullName" placeholder="">
                <label for="fullName">Enter Your Full Name</label>
                <span id="nameError" class="text-danger"></span>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-6">
                    <div class="input-group">

                        <div class="input-group-text">+91</div>
                        <div class="form-floating">
                            <input type="tel" pattern="[0-9]{10}" class="form-control" id="mobileNumber" placeholder>
                            <label for="mobileNumber">Mobile Number(Optional)</label>
                        </div>
                    </div>
                    <span id="mobileError" class="text-danger"></span>
                </div>
                <div class="col-12 col-md-6 mt-3 mt-md-0">
                    <div class="form-floating">
                        <input type="mail" class="form-control" id="email" placeholder>
                        <label for="email">Email Address(Example : johndoe@example.com)</label>
                    </div>
                    <span id="emailError" class="text-danger"></span>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="subject" placeholder>
                    <label for="subject">Subject (Example : I Have Query Related to Your XYZ Product!)</label>
                    <span id="subjectError" class="text-danger"></span>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-floating">
                    <textarea name="" id="query" class="form-control" style="height:200px" placeholder></textarea>
                    <label for="">Detailed Description About you Query!</label>
                </div>
            </div>
            <input type="submit" value="Submit" onclick="submitContactQuery()"
                class="btn btn-primary bg-pri mt-2 w-100">
        </div>
        <!-- </form> -->
        <div class="mt-3">
            <div class="display-6 bg-acc rounded-top text-pri p-2">Panchmukha Hanuman Street, B/H Hotel Jantaghar, Near New Bus Stand, Bhuj City, Kachchh(Gujarat) - 370001</div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1886.6166277741097!2d69.6725124622076!3d23.24976077298039!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1708940163896!5m2!1sen!2sin"
                class="w-100" style="aspect-ratio:2/1" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<script>
    function submitContactQuery() {
        $('#nameError, #emailError, #mobileError, #subjectError').text('');

        // Get form input values
        var fullName = $('#fullName').val().trim();
        var mobileNumber = $('#mobileNumber').val().trim();
        var email = $('#email').val().trim();
        var subject = $('#subject').val().trim();
        var query = $('#query').val().trim();

        if (fullName === '') {
            $('#nameError').text('Please enter your full name.');
            return;
        }
        if (mobileNumber !== '') {
            var mobileRegex = /^[0-9]{10}$/;
            if (!mobileRegex.test(mobileNumber)) {
                $('#mobileError').text('Please enter a valid 10-digit mobile number.');
                return;
            }
        }
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') {
            $('#emailError').text('Please enter your email address.');
            return;
        } else if (!emailRegex.test(email)) {
            $('#emailError').text('Please enter a valid email address.');
            return;
        }
        if (subject === '') {
            $('#subjectError').text('Subject is mandatory.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'action_query', // Replace with your server-side script URL
            data: {
                full_name: fullName,
                mobile_no: mobileNumber,
                email: email,
                subject: subject,
                query: query
            },
            success: function (response) {
                if (response.trim() === 'success') {
                    swal({ title: 'Query submitted successfully!', icon: 'success', content: 'Thank you for contact us <i class="fa fa-eye"></i>. we will get back to you soon', button: 'Keep Shopping' }).then(function () {
                        window.location = ('index');
                    });
                } else {
                    swal('Please enter valid details!');
                }
            },
            error: function () {
                alert('An error occurred while submitting query. Please try again later.');
            }
        });
    }

</script>