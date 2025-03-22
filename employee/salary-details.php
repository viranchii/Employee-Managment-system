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

        <title>Employee Management System || Salary Details</title>

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
        <!-- calendar file css -->
        <link rel="stylesheet" href="js/semantic.min.css" />
        <!-- fancy box js -->
        <link rel="stylesheet" href="css/jquery.fancybox.css" />

        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>

    </head>

    <body class="inner_page tables_page">
        <div class="full_container">
            <div class="inner_container">
                <!-- Sidebar  -->
                <?php include_once('includes/sidebar.php'); ?>
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
                                        <h2>Salary Details</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">


                                <div class="col-md-12">
                                    <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                            <div class="heading1 margin_0">
                                                <h2>Salary Details</h2>
                                            </div>
                                        </div>
                                        <div class="table_section padding_infor_info">
                                            <div class="table-responsive-sm">
                                                <?php

                                                $lid = $_SESSION['empid'];

                                                $sql = "SELECT tblsalary.*, tblemployee.EmpName 
                                               FROM tblsalary  
                                               INNER JOIN tblemployee ON tblsalary.EmpID = tblemployee.EmpId
                                               WHERE tblsalary.EmpID = :lid ";

                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':lid', $lid, PDO::PARAM_INT);
                                                if (!$query->execute()) {
                                                    print_r($query->errorInfo());
                                                    exit;
                                                }

                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() == 0) {
                                                    echo "No salaryid request found with this ID.";
                                                } else {
                                                    foreach ($results as $result) {
                                                ?>
                                                        <table class="table table-bordered" style="color:#000">
                                                            <tr>
                                                                <th colspan="6"
                                                                    style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">
                                                                    Salary Details
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Employee Name</th>
                                                                <td colspan="2"><?php echo htmlentities($result->EmpName); ?></td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="col">Salary</th>
                                                                <td><?php echo htmlentities($result->BasicSalary); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">overtime Pay</th>
                                                                <td colspan="2"><?php echo htmlentities($result->OvertimePay); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Bonus</th>
                                                                <td><?php echo htmlentities($result->Bonus); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Deductions</th>
                                                                <td colspan="2"><?php echo htmlentities($result->Deductions); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Payment Status</th>
                                                                <td colspan="2"><?php echo htmlentities($result->PaymentStatus); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Payment Date</th>
                                                                <td colspan="2"><?php echo htmlentities($result->created_at); ?>
                                                                </td>
                                                            </tr>



                                                        </table>
                                                <?php $cnt = $cnt + 1;
                                                    }
                                                } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer -->
                    <?php include_once('includes/footer.php'); ?>
                </div>
                <!-- end dashboard inner -->
            </div>
        </div>
        <!-- model popup -->

        </div>
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>
        <!-- <script src="js/vendor-all.min.js"></script> -->
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
        <!-- fancy box js -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/jquery.fancybox.min.js"></script>
        <!-- custom js -->
        <script src="js/custom.js"></script>
        <!-- calendar file css -->
        <script src="js/semantic.min.js"></script>
    </body>

    </html><?php } ?>