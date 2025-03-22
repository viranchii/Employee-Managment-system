<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {

    // Delete Attendance Record
    if (isset($_GET['delid'])) {
        $delid = intval($_GET['delid']);
        $sql = "DELETE FROM empattendance WHERE id=:delid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':delid', $delid, PDO::PARAM_INT);
        $query->execute();
        $_SESSION['delete_message'] = "<script>
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Attendance record deleted successfully!',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'attendance_home.php';
        });
    </script>";

    header("Location: attendance_home.php");
    exit();
    }

    // Update Attendance Record
    if (isset($_POST['update'])) {
        $id = intval($_POST['id']);
        $attendance_date = $_POST['attendance_date'];
        $check_in_time = $_POST['check_in_time'];
    
        // Logic to determine Status and Remarks based on Check-in Time
        $lateThreshold = "09:00"; // Define late threshold
        if ($check_in_time > $lateThreshold) {
            $status = "Late";
            $remarks = "Arrived late to work";
        } else {
            $status = "On Time";
            $remarks = "Punctual";
        }
    
        // Update Query
        $sql = "UPDATE empattendance SET attendance_date=:attendance_date, check_in_time=:check_in_time, status=:status, remarks=:remarks WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':attendance_date', $attendance_date, PDO::PARAM_STR);
        $query->bindParam(':check_in_time', $check_in_time, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':remarks', $remarks, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $_SESSION['update_message'] = "<script>
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: 'Attendance record updated successfully!',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'attendance_home.php';
        });
    </script>";

    header("Location: attendance_home.php");
    exit();
    }
    ?>
    
    
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Employee Attendance</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
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
        <script>
       function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'attendance_home.php?delid=' + id;
            }
        });
    }
        </script>

        
    </head>

    <body>
        <div class="full_container">
            <div class="inner_container">
                <!-- Sidebar  -->
                <?php include_once('includes/sidebar.php'); ?>
                <!-- right content -->
                <div id="content">
                    <!-- topbar -->
                    <?php include_once('includes/header.php'); ?>
                    <?php
if (isset($_SESSION['delete_message'])) {
    echo $_SESSION['delete_message'];
    unset($_SESSION['delete_message']); // Remove the message after displaying
}

if (isset($_SESSION['update_message'])) {
    echo $_SESSION['update_message'];
    unset($_SESSION['update_message']); // Remove the message after displaying
}
?>

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
                            <!-- row -->
                            <div class="row">


                                <div class="container">
                                    <h2>Attendance Records</h2>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee ID</th>
                                                <th>Date</th>
                                                <th>Check-in Time</th>
                                                <th>Check-out Time</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $dbh->prepare("SELECT * FROM empattendance ORDER BY id ");
                                            $stmt->execute();
                                            $result = $stmt->fetchAll();

                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row["id"] ?></td>
                                                    <td><?= $row["employee_id"] ?></td>
                                                    <td><?= $row["attendance_date"] ?></td>
                                                    <td><?= $row["check_in_time"] ?></td>
                                                    <td><?= $row["check_out_time"] ?></td>
                                                    <td><?= $row["status"] ?></td>
                                                    <td><?= $row["remarks"] ?></td>
                                                    <td>
                                                        <button style="border: none; background: none; cursor: pointer;"
                                                         data-toggle="modal"
                                                            data-target="#editModal<?= $row['id'] ?>"><i
                                                            class="material-icons green_color">mode_edit</i></button>
                                                        <button style="border: none; background: none; cursor: pointer;"
                                                            onclick="confirmDelete(<?= $row['id'] ?>)"><i class="material-icons red_color">delete_forever</i></button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
<div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Attendance</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

                    <div class="form-group">
                        <label>Date:</label>
                        <input type="date" name="attendance_date" value="<?= $row['attendance_date'] ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Check-in Time:</label>
                        <input type="time" id="checkInTime<?= $row['id'] ?>" name="check_in_time"
                            value="<?= $row['check_in_time'] ?>" class="form-control check-in-time" data-id="<?= $row['id'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Status:</label>
                        <input type="text" id="status<?= $row['id'] ?>" name="status" value="<?= $row['status'] ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Remarks:</label>
                        <input type="text" id="remarks<?= $row['id'] ?>" name="remarks" value="<?= $row['remarks'] ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

                                            <?php } ?>
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

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>

    </html>
<?php } ?>