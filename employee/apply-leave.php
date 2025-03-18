<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['empid'] == 0)) {
    header('location:logout.php');
} else {
    date_default_timezone_set('Asia/Kolkata');// change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['apply'])) {
        $empid = $_SESSION['empid'];
        $leavetype = $_POST['leavetype'];
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $description = $_POST['description'];
        $status = 0;
        $isread = 0;

        $checkLeaveSql = "SELECT COUNT(*) FROM tblleaves WHERE empid = :empid AND Status = 0";
        $checkQuery = $dbh->prepare($checkLeaveSql);
        $checkQuery->bindParam(':empid', $empid, PDO::PARAM_STR);
        $checkQuery->execute();
        $pendingLeaveCount = $checkQuery->fetchColumn();
        
        if ($pendingLeaveCount > 0) {
            $_SESSION['warning'] = "You already have a pending leave request. Please wait for approval before applying again.";
        } 
        elseif ($fromdate > $todate) {
            $_SESSION['warning'] = "To Date should be greater than From Date";
        } elseif ($fromdate < date("Y-m-d")) {
            $_SESSION['warning'] = "From Date cannot be in the past";
        } elseif ($todate < date("Y-m-d")) {
            $_SESSION['warning'] = "To Date cannot be in the past";
        } elseif ($fromdate == $todate) {
            $_SESSION['warning'] = "From Date and To Date cannot be the same";
        } elseif ((strtotime($todate) - strtotime($fromdate)) > (30 * 24 * 60 * 60)) {
            $_SESSION['warning'] = "Leave duration cannot exceed 30 days";
        } else {
            $sql = "INSERT INTO tblleaves(LeaveType,ToDate,FromDate,Description,Status,IsRead,empid) 
                    VALUES(:leavetype,:todate,:fromdate,:description,:status,:isread,:empid)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
            $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
            $query->bindParam(':todate', $todate, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_INT);
            $query->bindParam(':isread', $isread, PDO::PARAM_INT);
            $query->bindParam(':empid', $empid, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $_SESSION['msg'] = "Leave applied successfully";
            } else {
                $_SESSION['error'] = "Something went wrong. Please try again";
            }
        }
        header("Location: apply-leave.php"); // Redirect to refresh the page
        exit();
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Employee Management System || Apply Leave</title>

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
    </head>

    <body class="inner_page tables_page">
    <script>
    // Display SweetAlert for success or error messages
    <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") { ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?php echo $_SESSION["msg"]; ?>',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "leavehistory.php";
            }
        });
        <?php unset($_SESSION['msg']); ?>
    <?php } ?>

    <?php if (isset($_SESSION['error']) && $_SESSION['error'] != "") { ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo $_SESSION["error"]; ?>',
        });
        <?php unset($_SESSION['error']); ?>
    <?php } ?>

    <?php if (isset($_SESSION['warning']) && $_SESSION['warning'] != "") { ?>
        Swal.fire({
            icon: 'warning',  // Changed 'error' to 'warning'
            title: 'Warning',
            text: '<?php echo $_SESSION["warning"]; ?>',
        });
        <?php unset($_SESSION['warning']); ?>
    <?php } ?>
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
                                        <h2>Apply for Leave</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <?php if ($error) { ?>
                                    <div class="errorWrap"><strong>ERROR
                                        </strong>:<?php echo htmlentities($error); ?> </div>
                                <?php } else if ($msg) { ?>
                                        <div class="succWrap">
                                            <strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?>
                                        </div><?php } ?>
                                <<div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h5>Apply for leaves</h5>
                                        </div>
                                    </div>
                                    <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <div class="alert alert-primary" role="alert">
                                                    <form method="post" name="complaint" enctype="multipart/form-data">


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Leave Type</label>
                                                            <select name="leavetype" id="leavetype" class="form-control"
                                                                onChange="getCat(this.value);" required="">
                                                                <option value="">Select leave type...</option>
                                                                <?php
                                                                $sql = "SELECT  LeaveType from tblleavetype";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                $cnt = 1;
                                                                if ($query->rowCount() > 0) {
                                                                    foreach ($results as $result) { ?>
                                                                        <option
                                                                            value="<?php echo htmlentities($result->LeaveType); ?>">
                                                                            <?php echo htmlentities($result->LeaveType); ?>
                                                                        </option>
                                                                    <?php }
                                                                } ?>
                                                            </select>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="fromdate">From Date</label>
                                                            <input type="date" name="fromdate" required="required" value=""
                                                                data-inputmask="'alias': 'date'" required
                                                                class="form-control">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="todate">To Date</label>
                                                            <input type="date" name="todate" required="required" value=""
                                                                data-inputmask="'alias': 'date'" required
                                                                class="form-control">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="birthdate">Leave Details (max 500
                                                                words)</label>
                                                            <textarea name="description" required="required" cols="10"
                                                                id="textarea1" rows="10" class="form-control"
                                                                maxlength="500"></textarea>

                                                        </div>

                                                        <button type="submit" class="btn  btn-primary"
                                                            name="apply">Submit</button>
                                                    </form>
                                                    </div> <!-- alert alert-primary -->
                                                    </div> <!-- padding_infor_info -->
                                                </div> <!-- full -->
                                            </div> <!-- col-md-12 -->
                                        </div> <!-- row -->
                                    </div> <!-- full progress_bar_inner -->
                                </div> <!-- white_shd full margin_bottom_30 -->
                            </div> <!-- col-md-12 -->
                        </div> <!-- row -->
                    </div> <!-- container-fluid -->
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