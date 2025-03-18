<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid'] == 0)) {
    header('location:logout.php');
} else {



    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Employee Management System || View All Leaves</title>

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
  <!--sweetalert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="css\materialPreloader.min.css" rel="stylesheet">
        <link href="css/jquery.dataTables.min.css" rel="stylesheet">

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
                                        <h2>View All Leaves</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">


                                <div class="col-md-12">
                                    <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                            <div class="heading1 margin_0">
                                                <h2>View All Leaves</h2>
                                            </div>
                                        </div>
                                        <div class="table_section padding_infor_info">
                                            <div class="table-responsive-sm">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Employe Name</th>
                                                            <th>Leave Type</th>
                                                            <th>Posting Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php

                                                        $sql = "SELECT tblleaves.*,tblemployee.EmpName from tblleaves join tblemployee on tblemployee.EmpId=tblleaves.empid order by tblleaves.id desc";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        // echo $result;
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $row) { ?>
                                                                <tr>

                                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                                    <td><?php echo htmlentities($row->EmpName); ?></td>
                                                                    <td><?php echo htmlentities($row->LeaveType); ?></td>
                                                                    <td><?php echo htmlentities($row->PostingDate); ?>

                                                                    <td><?php $stats = $row->Status;
                                                                    if ($stats == 1) {
                                                                        ?>
                                                                            <span style="color: green">Approved</span>
                                                                        <?php }
                                                                    if ($stats == 2) { ?>
                                                                            <span style="color: red">Not Approved</span>
                                                                        <?php }
                                                                    if ($stats == 0) { ?>
                                                                            <span style="color: blue">waiting for approval</span>
                                                                        <?php } ?>


                                                                    </td>
                                                                    <td><a href="leave-details.php?leaveid=<?php echo htmlentities($row->id); ?>">
                                                                    <i  class="material-icons yellow_color">visibility</i></a>
                                                                    </td>
                                                                </tr><?php $cnt = $cnt + 1;
                                                            }
                                                        } else { ?>
                                                            <tr>
                                                                <td colspan="7" style="color:red">No Task Found</td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
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