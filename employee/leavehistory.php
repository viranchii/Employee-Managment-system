<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (!isset($_SESSION['empid']) || strlen($_SESSION['empid']) == 0) {
    header('location:logout.php');
} else {



    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Employee Management System || Leave History</title>

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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
     <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="css\materialPreloader.min.css" rel="stylesheet">
        <link href="css/jquery.dataTables.min.css" rel="stylesheet">

   
    </head>

    <body class="inner_page tables_page">
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to undo this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete-leave.php?id=" + id;
            }
        });
    }
</script>
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
                                        <h2>Leave History</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">


                                <div class="col-md-12">
                                    <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                            <div class="heading1 margin_0">
                                                <h2>Leave History</h2>
                                            </div>
                                        </div>
                                        <div class="table_section padding_infor_info">
                                            <div class="table-responsive-sm">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Leave Type</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Posting Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $empid = $_SESSION['empid'];
                                                        $sql = "SELECT tblleaves.id as lid ,LeaveType,ToDate,FromDate,Description,PostingDate,AdminRemarkDate,AdminRemark,Status from tblleaves where empid=:eid";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':eid', $empid, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <tr>
                                                                    <td> <?php echo htmlentities($cnt); ?></td>
                                                                    <td><?php echo htmlentities($result->LeaveType); ?></td>
                                                                    <td><?php echo htmlentities($result->FromDate); ?></td>
                                                                    <td><?php echo htmlentities($result->ToDate); ?></td>
                                                                    <td><?php echo htmlentities($result->PostingDate); ?></td>


                                                                    <td><?php $stats = $result->Status;
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

                                                                    <td> 
                                                                    <a href="edit-leave.php?id=<?php echo $result->lid; ?>" ><i  class="material-icons green_color">mode_edit</i></a>
                                                                    <a href="javascript:void(0);"  onclick="confirmDelete(<?php echo $result->lid; ?>)"><i  class="material-icons red_color">delete_forever</i></a>

                                                                    <a href="leave-details.php?leaveid=<?php echo htmlentities($result->lid); ?>"
                                                                    > <i  class="material-icons yellow_color">visibility</i></a>
                                                                    </td>


                                                                </tr>
                                                                <?php $cnt = $cnt + 1;
                                                            }
                                                        } else { ?>

                                                            <tr>
                                                                <th colspan="8" style="color:red">No Record found</th>
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