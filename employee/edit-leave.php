<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (!isset($_SESSION['empid'])) {
    header('location:logout.php');
    exit;
}

//$msg = "";
$error = "";

$leaveId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing leave details
$sql = "SELECT * FROM tblleaves WHERE id = :leaveId";
$query = $dbh->prepare($sql);
$query->bindParam(':leaveId', $leaveId, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if (!$result) {
    echo "<script>alert('Invalid Leave ID!');</script>";
    header("Location: leavehistory.php");
    exit;
}

if (isset($_POST['update'])) {
    $leavetype = $_POST['leavetype'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $description = $_POST['description'];

    if ($fromdate > $todate) {
        $error = "To Date should be greater than From Date";
    } else {
        $sql = "UPDATE tblleaves SET LeaveType = :leavetype, FromDate = :fromdate, ToDate = :todate, Description = :description WHERE id = :leaveId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':leaveId', $leaveId, PDO::PARAM_INT);

        if ($query->execute()) {
            $_SESSION['updateSuccess'] = "Leave updated successfully!";
            header("Location: edit-leave.php?id=$leaveId"); // Redirect to avoid form resubmission
            exit;
        } else {
            $error = "Something went wrong! Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Management System || Edit Leave</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="js/semantic.min.css" />
    <link rel="stylesheet" href="css/jquery.fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
   

</head>

<body class="inner_page tables_page">
<?php
// Show success message only if an update was performed
if (isset($_SESSION['updateSuccess'])) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '" . $_SESSION['updateSuccess'] . "',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'leavehistory.php';
            }
        });
    </script>";
    unset($_SESSION['updateSuccess']); // Remove session message after displaying
}
?>


    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar -->
            <?php include_once('includes/sidebar.php'); ?>

            <!-- Right Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once('includes/header.php'); ?>

                <!-- Dashboard Inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Edit Leave Details</h2>
                                </div>
                            </div>
                        </div>

                        <!-- Display Error or Success Message -->
                        <div class="row">
                            <div class="col-sm-12">
                            <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger"><?php echo htmlentities($error); ?></div>
                    <?php } ?>
                            </div>
                        </div>

                        <!-- Leave Form -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h5>Update Leave-Details</h5>
                                        </div>
                                    </div>
                                    <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <div class="alert alert-primary" role="alert">
                                                   
                                        <form method="post">
                                            <div class="form-group">
                                                <label for="leavetype">Leave Type</label>
                                                <select name="leavetype" id="leavetype" class="form-control" required>
    <option value="">Select leave type...</option>
    <?php
    $sql = "SELECT  LeaveType FROM tblleavetype"; // Fetch both id and LeaveType
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $row) {
            $selected = ($row->LeaveType == $result->LeaveType) ? "selected" : "";
                                                        echo '<option value="' . htmlentities($row->LeaveType) . '" ' . $selected . '>' . htmlentities($row->LeaveType) . '</option>';
                                                     }
    }
    ?>
</select>

                                            </div>

                                            <div class="form-group">
                                                <label for="fromdate">From Date</label>
                                                <input type="date" name="fromdate" value="<?php echo htmlentities($result->FromDate); ?>" required class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="todate">To Date</label>
                                                <input type="date" name="todate" value="<?php echo htmlentities($result->ToDate); ?>" required class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Leave Details (max 500 words)</label>
                                                <textarea name="description" required class="form-control" maxlength="500"><?php echo htmlentities($result->Description); ?></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary" name="update">Update</button>
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
                        <!-- footer -->
                        <!-- footer -->
                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>

    <script>
document.querySelector("form").addEventListener("submit", function(event) {
    let fromDate = document.querySelector("[name='fromdate']").value;
    let toDate = document.querySelector("[name='todate']").value;
    if (new Date(fromDate) > new Date(toDate)) {
        Swal.fire({
            icon: "error",
            title: "Invalid Dates",
            text: "To Date should be greater than From Date.",
            confirmButtonText: "OK"
        });
        event.preventDefault();
    }
});
</script>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/semantic.min.js"></script>
</body>

</html>
