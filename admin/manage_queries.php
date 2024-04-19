<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('header.php');
    include('../conn.php');
    ?>


    <div class="container mt-5 overflow-scroll">
        <h2 class="mb-4">Manage Queries</h2>
        <table class="table table-bordered sizeTable">
            <thead>
                <tr>
                    <th width="50px">ID</th>
                    <th width="200px">Full Name</th>
                    <th width="130px">Contact</th>
                    <th width="200px">Subject</th>
                    <th>Description</th>
                    <th width="120px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // if statis is 0 means query is pending 1= readed 2=archived
                $sql = "SELECT * FROM contact_queries WHERE LENGTH(response) - LENGTH(REPLACE(response, ' ', '')) < 4 OR status < 1 ";
                $search = @$_GET['search'];
                if (isset($search)) {
                    $sql .= " AND full_name LIKE '%{$search}%' OR mobile_no LIKE '%{$search}%'  OR email LIKE '%{$search}%' OR subject LIKE '%{$search}%' OR query LIKE '%{$search}%'  ";
                }
                $sql .= " ORDER BY created_at ASC";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['query_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['full_name'] ?>
                            </td>
                            <td>
                                <div>
                                    <i class="btn btn-success p-3 fa fa-phone" data-bs-toggle="tooltip"
                                        title="<?php echo $row['mobile_no'] ?>"
                                        ondblclick="window.location=('tel: <?php echo $row['mobile_no'] ?>')"></i>
                                    <i class="btn btn-primary p-3 far fa-envelope" data-bs-toggle="tooltip"
                                        title="<?php echo $row['email'] ?>"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <?php echo $row['subject'] ?>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <?php echo $row['query']; ?>
                                </div>
                                <div>
                                    Response :
                                    <?php echo isset($row['response']) && !empty($row['response']) ? $row['response'] : '<i class="text-secondary">Pending</i>'; ?>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class=" btn btn-success px-3 py-2" data-bs-toggle="modal"
                                        data-bs-target="#replyQueryModal"
                                        onclick="prefillQuery('<?php echo $row['query_id'] ?>','<?php echo $row['email'] ?>','<?php echo $row['mobile_no'] ?>','<?php echo $row['subject'] ?>','<?php echo $row['query'] ?>')"><i
                                            class="fa fa-reply"></i> Reply</span>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><th colspan='4'>No Queries Available</th><tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Reply Modal -->
    <div class="modal fade" id="replyQueryModal" tabindex="1" aria-labelledby="replyQueryModalLabel" aria-hidden="true"
        stye="display:block !important;opacity:1;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addSizeModalLabel">Reply : <span id="fullName">Name Not Available</span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8">
                            <!-- Reply Message Form -->
                            <form id="replyQueryForm">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6 justify-content-between">
                                            <div><b>Mail:</b> <span id="mail">Mail not available</span> <i
                                                    class="btn btn-primary p-2 fa fa-envelope"></i></div>
                                        </div>
                                        <div class="col-6">
                                            <div><b>Mobile No. : </b> <span id="mobileNo">Not Available</span> <i
                                                    class="btn btn-success p-2 fa fa-phone"></i></div>
                                        </div>
                                    </div>
                                    <div class="mb-2"><b>Subject:</b> <span id="subject">Subject Not Available</span></div>
                                    <div><b>Description:</b> <span id="query"></span></div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <textarea id="response" style="height:200px" class="form-control"
                                            placeholder></textarea>
                                        <label for="replyMessage">Reply Message</label>
                                    </div>
                                </div>
                                <input type="hidden" id="queryId" value="">
                                <div class="mt-2 d-flex justify-content-between">
                                    <div>
                                        <div class="btn btn-success" onclick="sendWhatsAppMessage()"><i
                                                class="fab fa-whatsapp"></i> By Whatsapp</div>
                                        <div class="btn btn-primary ms-2"><i class="fa fa-envelope"></i> By Mail</div>
                                    </div>
                                    <div class="btn btn-info btn-lg" onclick="replyQuery()"><i class="fa fa-earth"></i>
                                        Onsite</div>
                                </div>
                            </form>
                        </div>
                        <div class="col-4">
                            <h2 class="text-center display-6 ">Replies</h2>
                            <div class="overflow-scroll ">
                                <div class="card">1. Thank you for reaching out! Our team is working diligently to address
                                    your
                                    inquiry regarding Kachchhi region items.</div>
                                <div class="card">2. We appreciate your patience. Our support team will get back to you
                                    shortly
                                    regarding your query about Kachchhi products.</div>
                                <div class="card">3. Apologies for any confusion. We're here to assist you with any
                                    questions
                                    about our unique Kachchhi items.</div>
                                <div class="card">4. Your inquiry is important to us! Our support team is reviewing your
                                    message
                                    about Kachchhi region products.</div>
                                <div class="card">5. We understand your concern. Our experts will provide you with detailed
                                    information on Kachchhi items soon.</div>
                                <div class="card">6. Thank you for bringing this to our attention. Our customer support will
                                    respond promptly regarding Kachchhi merchandise.</div>
                                <div class="card">7. We apologize for any inconvenience caused. Our team is actively working
                                    to
                                    resolve your query about Kachchhi products.</div>
                                <div class="card">8. Rest assured, our team is on it! We'll provide you with all the
                                    information
                                    you need about Kachchhi region items.</div>
                                <div class="card">9. Your satisfaction is our priority. Expect a detailed response to your
                                    inquiry about Kachchhi products shortly.</div>
                                <div class="card">10. We're sorry for the oversight. Our support team will ensure you
                                    receive
                                    accurate information on Kachchhi items.</div>
                                <div class="card">11. Thank you for your understanding. Our dedicated team will address your
                                    questions about Kachchhi region items.</div>
                                <div class="card">12. Our sincere apologies. We'll promptly respond to your inquiry
                                    regarding
                                    our range of Kachchhi products.</div>
                                <div class="card">13. Your feedback is valuable to us. Our team is eager to assist with any
                                    questions about Kachchhi items.</div>
                                <div class="card">14. Apologies for any delay. We're committed to providing you with
                                    information
                                    on Kachchhi region merchandise.</div>
                                <div class="card">15. Thank you for reaching out. Expect a swift response to your inquiry
                                    about
                                    our Kachchhi product selection.</div>
                                <div class="card">16. We appreciate your interest! Our support team will clarify any doubts
                                    you
                                    have about Kachchhi items.</div>
                                <div class="card">17. Your satisfaction is our top priority. We're working to address your
                                    questions about Kachchhi region products.</div>
                                <div class="card">18. Apologies for the inconvenience. Our team is actively handling your
                                    query
                                    related to Kachchhi merchandise.</div>
                                <div class="card">19. Thank you for your patience. Expect comprehensive details on our
                                    Kachchhi
                                    items shortly.</div>
                                <div class="card">20. We apologize for any inconvenience caused. Our team will ensure your
                                    questions about Kachchhi products are resolved.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>
    <script type="text/javascript">
        function sendWhatsAppMessage() {
            var mobileNo = $('#mobileNo').text().trim();
            var response = $('#response').val();
            var whatsappUrl = `whatsapp://send?phone=91${mobileNo}&text=${encodeURIComponent(response)}`;
            var whatsappWindow = window.open(whatsappUrl, 'Whatsapp Message', 'height=500,width=900');
            setTimeout(function () {
                if (whatsappWindow && !whatsappWindow.closed) {
                    whatsappWindow.close();
                }
            }, 2000);
            return false;
        }
    </script>
    <script>
        function prefillQuery(queryId, mail, mobileNo, subject, query) {
            $('#replyQueryForm #queryId').val(queryId);
            $('#replyQueryForm #mail').text(mail);
            $('#replyQueryForm #mobileNo').text(mobileNo);
            $('#replyQueryForm #subject').text(subject);
            $('#replyQueryForm #query').text(query);
        }
    </script>
    <script>
        function replyQuery() {
            var queryId = $('#replyQueryForm #queryId').val();
            var response = $('#replyQueryForm #response').val();

            $.ajax({
                type: 'POST',
                url: 'action_query',
                data: {
                    action: 'reply_query',
                    queryId: queryId,
                    response: response
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        swal({ title: 'Reply Sent!', icon: 'success' }).then(function () {
                            window.location.reload();
                        });
                    } else {
                        swal(response).then(function () {
                            // swal('Something went Wrong.').then(function () {
                            window.location.reload();
                        });;
                    }
                },
                error: function () {
                    swal('An error occurred. Please try again later.').then(function () {
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