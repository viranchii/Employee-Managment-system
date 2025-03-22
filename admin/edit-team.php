<?php
session_start();
include('includes/dbconnection.php');

if (isset($_GET['editid'])) {
    $teamId = intval($_GET['editid']);

    // Fetch team details
    $sql = "SELECT * FROM tblteam WHERE TeamId = :teamId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':teamId', $teamId, PDO::PARAM_INT);
    $query->execute();
    $team = $query->fetch(PDO::FETCH_OBJ);

    // Fetch current members of the team
    $sqlMembers = "SELECT MemberId FROM tblteammembers WHERE TeamId = :teamId";
    $queryMembers = $dbh->prepare($sqlMembers);
    $queryMembers->bindParam(':teamId', $teamId, PDO::PARAM_INT);
    $queryMembers->execute();
    $existingMembers = $queryMembers->fetchAll(PDO::FETCH_COLUMN);
}

// Handle form submission
if (isset($_POST['update'])) {
    $taskId = $_POST['taskid'];
    $leaderId = $_POST['leaderid'];
    $startDate = $_POST['startdate'];
    $endDate = $_POST['enddate'];
    $members = isset($_POST['members']) ? $_POST['members'] : [];

    // Update team details
    $sql = "UPDATE tblteam SET TaskId=:taskId, LeaderId=:leaderId, StartDate=:startDate, EndDate=:endDate WHERE TeamId=:teamId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':taskId', $taskId, PDO::PARAM_INT);
    $query->bindParam(':leaderId', $leaderId, PDO::PARAM_INT);
    $query->bindParam(':startDate', $startDate, PDO::PARAM_STR);
    $query->bindParam(':endDate', $endDate, PDO::PARAM_STR);
    $query->bindParam(':teamId', $teamId, PDO::PARAM_INT);
    $query->execute();

    // Check if members have changed
    if ($members !== $existingMembers) {
        // Remove members that are not in the new selection
        $sqlDeleteMembers = "DELETE FROM tblteammembers WHERE TeamId=:teamId AND MemberId NOT IN (" . implode(',', array_map('intval', $members)) . ")";
        $queryDelete = $dbh->prepare($sqlDeleteMembers);
        $queryDelete->bindParam(':teamId', $teamId, PDO::PARAM_INT);
        $queryDelete->execute();

        // Add new members
        $sqlInsert = "INSERT INTO tblteammembers (TeamId, MemberId) VALUES (:teamId, :memberId)";
        $queryInsert = $dbh->prepare($sqlInsert);
        
        foreach ($members as $member) {
            if (!in_array($member, $existingMembers)) { // Only insert new members
                $queryInsert->bindParam(':teamId', $teamId, PDO::PARAM_INT);
                $queryInsert->bindParam(':memberId', $member, PDO::PARAM_INT);
                $queryInsert->execute();
            }
        }
    }

    $_SESSION['success_msg'] = "Team updated successfully!";
    header("Location: edit-team.php");
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


    <script>
document.addEventListener("DOMContentLoaded", function () {
    <?php if (isset($_SESSION['success_msg'])) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "<?php echo $_SESSION['success_msg']; ?>",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'manage-team.php';
            }
        });
        <?php unset($_SESSION['success_msg']); // Clear the session after displaying ?>
    <?php } ?>
});

</script>

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
                                    <h2>Add Project</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row column8 graph">

                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Add Project</h2>
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

                                                                <div class="form-group">
                <label>Task Title</label>
                <select name="taskid" class="form-control" required>
                    <option value="">Select Task</option>
                    <?php
                    $sql2 = "SELECT * FROM tbltask";
                    $query2 = $dbh->prepare($sql2);
                    $query2->execute();
                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                    foreach ($result2 as $row2) {
                        $selected = ($row2->ID == $team->TaskId) ? "selected" : "";
                        echo "<option value='" . htmlentities($row2->ID) . "' $selected>" . htmlentities($row2->TaskTitle) . "</option>";
                    }
                    ?>
                </select>
            </div>
                                                                            <br>
                                                                            <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="startdate" class="form-control" value="<?php echo htmlentities($team->StartDate); ?>" required>
            </div>

            <div class="form-group">
                <label>End Date</label>
                <input type="date" name="enddate" class="form-control" value="<?php echo htmlentities($team->EndDate); ?>" required>
            </div>

            <div class="form-group">
                <label>Leader</label>
                <select name="leaderid" class="form-control" required>
                    <option value="">Select Leader</option>
                    <?php
                    $sql = "SELECT * FROM tblemployee";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    foreach ($results as $row) {
                        $selected = ($row->EmpId == $team->LeaderId) ? "selected" : "";
                        echo "<option value='" . htmlentities($row->EmpId) . "' $selected>" . htmlentities($row->EmpName) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Members</label>
                <select name="members[]" class="form-control" multiple required>
                    <option value="">Select Members</option>
                    <?php
                    foreach ($results as $row) {
                        $selected = (in_array($row->EmpId, $existingMembers)) ? "selected" : "";
                        echo "<option value='" . htmlentities($row->EmpId) . "' $selected>" . htmlentities($row->EmpName) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
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