<?php
session_start();
ob_start();
include('includes/dbconnection.php');

if (!isset($_SESSION['etmsaid']) || strlen($_SESSION['etmsaid']) == 0) {
    header('Location: logout.php');
    exit();
}

if (isset($_POST['submit'])) {
    $taskid = $_POST['taskid'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $leaderid = $_POST['leaderid'];
    $members = isset($_POST['members']) ? $_POST['members'] : [];

    $currentDate = date('Y-m-d'); // today's date in Y-m-d format

    if ($startdate <= $currentDate) {
        $_SESSION['status'] = "Start date must be a future date.";
        $_SESSION['status_code'] = "error";
        header("Location: add-team.php");
        exit();
    }
    
    if ($enddate < $startdate) {
        $_SESSION['status'] = "End date cannot be earlier than start date.";
        $_SESSION['status_code'] = "error";
        header("Location: add-team.php");
        exit();
    }

    try {
        $dbh->beginTransaction();

        // Insert team into tblteam
        $sql = "INSERT INTO tblteam (TaskId, StartDate, EndDate, LeaderId) 
                VALUES (:taskid, :startdate, :enddate, :leaderid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':taskid', $taskid, PDO::PARAM_INT);
        $query->bindParam(':startdate', $startdate, PDO::PARAM_STR);
        $query->bindParam(':enddate', $enddate, PDO::PARAM_STR);
        $query->bindParam(':leaderid', $leaderid, PDO::PARAM_INT);

        if ($query->execute()) {
            $LastInsertId = $dbh->lastInsertId();

            // Insert team members
            if (!empty($members)) {
                $sql_member = "INSERT INTO tblteammembers (TeamId, MemberId) VALUES (:teamid, :memberid)";
                $query_member = $dbh->prepare($sql_member);

                foreach ($members as $member) {
                    $query_member->bindParam(':teamid', $LastInsertId, PDO::PARAM_INT);
                    $query_member->bindParam(':memberid', $member, PDO::PARAM_INT);
                    $query_member->execute();
                }
            }

            $dbh->commit();

            $_SESSION['status'] = "Team created successfully!";
            $_SESSION['status_code'] = "success";
            $_SESSION['redirect'] = "manage-team.php";
        } else {
            throw new Exception("Failed to insert team.");
        }
    } catch (Exception $e) {
        $dbh->rollBack();
        $_SESSION['status'] = "Error: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
    }

    header("Location: add-team.php");
    exit();
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Management System || Add Department</title>

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




</head>

<body class="inner_page general_elements">
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
                                    <h2>Add Team</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row column8 graph">

                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Add Team</h2>
                                        </div>
                                    </div>
                                    <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <div class="alert alert-primary" role="alert">
                                                            <form method="post" action="">
                                                                <fieldset>

                                                                    <div class="field">
                                                                        <label class="label_field">Task Title</label>
                                                                        <select name="taskid" id="taskid" class="form-control" required>
                                                                            <option value="">Select Task</option>
                                                                            <?php
                                                                            $sql2 = "SELECT * from tbltask";
                                                                            $query2 = $dbh->prepare($sql2);
                                                                            $query2->execute();
                                                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                                            foreach ($result2 as $row2) {
                                                                                echo "<option value='" . htmlentities($row2->ID) . "'>" . htmlentities($row2->TaskTitle) . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                            <br>
                                                                    <div class="field">
                                                                        <label class="label_field">Start Date</label>
                                                                        <input type="date" name="startdate" class="form-control" required>
                                                                    </div>
<br>
                                                                    <div class="field">
                                                                        <label class="label_field">End Date</label>
                                                                        <input type="date" name="enddate" class="form-control" required>
                                                                    </div>
<br>
                                                                    <div class="field">
                                                                        <label class="label_field">Leader</label>
                                                                        <select name="leaderid" id="leaderid" class="form-control" required>
                                                                            <option value="">Select Leader</option>
                                                                            <?php
                                                                            $sql = "SELECT * FROM tblemployee";
                                                                            $query = $dbh->prepare($sql);
                                                                            $query->execute();
                                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                            foreach ($results as $row) {
                                                                                echo "<option value='" . htmlentities($row->EmpId) . "'>" . htmlentities($row->EmpName) . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
<br>
                                                                    <div class="field">
                                                                        <label class="label_field">Members</label>
                                                                        <select name="members[]" id="members" class="form-control" multiple required>
                                                                            <option value="">Select Members</option>
                                                                            <?php
                                                                            foreach ($results as $row) {
                                                                                echo "<option value='" . htmlentities($row->EmpId) . "'>" . htmlentities($row->EmpName) . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
<br>
                                                                    <div class="field margin_0">
                                                                        <button class="main_bt" type="submit" name="submit" id="submit">Add</button>
                                                                    </div>
                                                                </fieldset>
                                                            </form>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- funcation section -->

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
        <!-- custom js -->
        <script src="js/custom.js"></script>
        <!-- calendar file css -->
        <script src="js/semantic.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/jquery.min.js"></script>

        <script>
            $(document).ready(function() {
                <?php if (isset($_SESSION['status'])) { ?>
                    Swal.fire({
                        icon: "<?php echo $_SESSION['status_code']; ?>",
                        title: "<?php echo $_SESSION['status_code'] == 'success' ? 'Success!' : ($_SESSION['status_code'] == 'warning' ? 'Warning!' : 'Error!'); ?>",
                        text: "<?php echo $_SESSION['status']; ?>",
                        timer: 2000, // Auto-close after 2 seconds
                        showConfirmButton: true
                    }).then(() => {
                        window.location.href = "<?php echo isset($_SESSION['redirect']) ? $_SESSION['redirect'] : 'add-team.php'; ?>";
                    });
                <?php
                    unset($_SESSION['status']);
                    unset($_SESSION['status_code']);
                    unset($_SESSION['redirect']);
                } ?>
            });
        </script>


</body>

</html>