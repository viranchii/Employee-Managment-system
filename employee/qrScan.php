<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['empid'] == 0)) {
    header('location:logout.php');
} else {



    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Employee Management System|| Attendance </title>

        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <!-- site css -->
        <link rel="stylesheet" href="style.css" />
        <!-- responsive css -->
        <link rel="stylesheet" href="css/responsive.css" />
        <!-- color css -->
        <link rel="stylesheet" href="css/colors.css" />
        <!-- select bootstrap -->
        <link rel="stylesheet" href="css/bootstrap-select.css" />
        <!-- scrollbar css -->
        <link rel="stylesheet" href="css/perfect-scrollbar.css" />
        <!-- custom css -->
        <link rel="stylesheet" href="css/custom.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body class="dashboard dashboard_1">
        <div class="full_container">
            <div class="inner_container">
                <!-- Sidebar  -->
                <?php include_once('includes/sidebar.php'); ?>
                <!-- end sidebar -->
                <!-- right content -->
                <div id="content">
                    <!-- topbar -->
                    <?php include_once('includes/header.php'); ?>
                    <!-- end topbar -->
                    <!-- dashboard inner -->
                    <div class="midde_cont">
                        <div class="container-fluid">
                            <div class="row column_title">
                                <div class="col-md-12">
                                    <div class="page_title">
                                        <h2>Attendance</h2>
                                    </div>
                                </div>
                            </div>
                             <!-- SweetAlert Message -->
                        <?php if(isset($_SESSION['msg'])) { ?>
                            <script>
                                Swal.fire({
                                    icon: '<?php echo $_SESSION["type"]; ?>',
                                    title: '<?php echo $_SESSION["msg"]; ?>',
                                    showConfirmButton: true,
                                    timer: 2000
                                });
                            </script>
                            <?php unset($_SESSION['msg']); unset($_SESSION['type']); ?>
                        <?php } ?>

                            <div class="row column1">
                                <div class="qr-container col-4">

                                    <div class="scanner-con">
                                        <h5 class="text-center">Scan you QR Code here for your attedance</h5>
                            <!--display cammera video-->
                                        <video id="interactive" class="viewport" width="100%">
                                    </div>
                                    <div class="qr-detected-container" style="display: none;">
                                        <form action="add-attendance.php" method="POST">
                                            <h4 class="text-center">Employee QR Detected!</h4>
                                            <input type="hidden" id="detected-qr-code" name="qr_code">
                                            <button type="submit" class="btn btn-dark form-control">Submit
                                                Attendance</button>
                                        </form>
                                    </div>

                                </div>

                                <div class="attendance-list col-8">
                                    <h4 class="text-center">Attendance List</h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attendance-list">
                                            <?php
                                            $empid = $_SESSION['empid'];
                                            $sql = "SELECT * FROM empattendance WHERE employee_id='$empid'";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            foreach ($results as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $row->attendance_date; ?></td>
                                                    <td><?php echo $row->check_in_time; ?></td>
                                                </tr>
                                                <?php $cnt = $cnt + 1;
                                            } ?>
                                        </tbody>
                                    </table>

                                </div>

                            </div>

                        </div>
                        <!-- footer -->
                        <?php include_once('includes/footer.php'); ?>
                    </div>
                    <!-- end dashboard inner -->
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- wow animation -->
        <script src="js/animate.js"></script>
        <!-- select country -->
        <script src="js/bootstrap-select.js"></script>
        <!-- owl carousel -->
        <script src="js/owl.carousel.js"></script>
        <!-- chart js -->
        <script src="js/Chart.min.js"></script>
        <script src="js/Chart.bundle.min.js"></script>
        <script src="js/utils.js"></script>
        <script src="js/analyser.js"></script>
        <!-- nice scrollbar -->
        <script src="js/perfect-scrollbar.min.js"></script>
        <script>
            var ps = new PerfectScrollbar('#sidebar');
        </script>
        <!-- custom js -->
        <script src="js/custom.js"></script>
        <script src="js/chart_custom_style1.js"></script>

        <!-- instascan Js -->
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

        <script>


            let scanner;

            function startScanner() {
                scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

                //  This function triggers when a QR code is scanned
    scanner.addListener('scan', function (content) {
        $("#detected-qr-code").val(content); //  Puts the scanned content in the input box
        console.log(content); //  Shows the scanned value in the browser console
        scanner.stop(); // Stops the camera after scanning

        // 👇 Shows the container that was previously hidden
        document.querySelector(".qr-detected-container").style.display = '';
        document.querySelector(".scanner-con").style.display = 'none';
    });

     //  Access the user's camera
                Instascan.Camera.getCameras()
                    .then(function (cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            console.error('No cameras found.');
                            alert('No cameras found.');
                        }
                    })
                    .catch(function (err) {
                        console.error('Camera access error:', err);
                        alert('Camera access error: ' + err);
                    });
            }

            document.addEventListener('DOMContentLoaded', startScanner);

            // function deleteAttendance(id) {
            //     if (confirm("Do you want to remove this attendance?")) {
            //         window.location = "./endpoint/delete-attendance.php?attendance=" + id;
            //     }
            // }
        </script>
    </body>

    </html><?php } ?>