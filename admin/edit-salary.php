<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// NEW (if using ?id=...)
if (!isset($_GET['editid']) || empty($_GET['editid']) || !is_numeric($_GET['editid'])) {
    die("<script>alert('Error: Invalid request.'); window.location.href = 'managesalary.php';</script>");
}
$eid = intval($_GET['editid']);

$eid = intval($_GET['editid']);
$sql = "SELECT * FROM tblsalary WHERE SalaryID = :eid";
$query = $dbh->prepare($sql);
$query->bindParam(':eid', $eid, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if (!$result) {
    echo "<script>alert('Invalid Record'); window.location.href = 'manage-salary.php';</script>";
    exit();
}

// Update salary details
if (isset($_POST['update'])) {
    $BasicSalary = $_POST['BasicSalary'];
    $OvertimePay = $_POST['OvertimePay'];
    $Bonus = $_POST['Bonus'];
    $Deductions = $_POST['Deductions'];
    $NetSalary = ($BasicSalary + $OvertimePay + $Bonus) - $Deductions;
    $PaymentStatus = $_POST['PaymentStatus'];
    $PaymentDate = ($PaymentStatus == "Paid") ? date('Y-m-d') : NULL;

    $sql = "UPDATE tblsalary SET 
            BasicSalary = :BasicSalary, 
            OvertimePay = :OvertimePay, 
            Bonus = :Bonus, 
            Deductions = :Deductions, 
            NetSalary = :NetSalary, 
            PaymentStatus = :PaymentStatus, 
            PaymentDate = :PaymentDate 
            WHERE SalaryID = :eid";

    $query = $dbh->prepare($sql);
    $query->bindParam(':BasicSalary', $BasicSalary, PDO::PARAM_STR);
    $query->bindParam(':OvertimePay', $OvertimePay, PDO::PARAM_STR);
    $query->bindParam(':Bonus', $Bonus, PDO::PARAM_STR);
    $query->bindParam(':Deductions', $Deductions, PDO::PARAM_STR);
    $query->bindParam(':NetSalary', $NetSalary, PDO::PARAM_STR);
    $query->bindParam(':PaymentStatus', $PaymentStatus, PDO::PARAM_STR);
    $query->bindParam(':PaymentDate', $PaymentDate, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_INT);

    if ($query->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Salary details updated successfully!'];
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Something went wrong. Try again!'];
    }

    header("Location: edit-salary.php?editid=" . $eid);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Salary</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function calculateNetSalary() {
            let basicSalary = parseFloat(document.getElementById('BasicSalary').value) || 0;
            let overtimePay = parseFloat(document.getElementById('OvertimePay').value) || 0;
            let bonus = parseFloat(document.getElementById('Bonus').value) || 0;
            let deductions = parseFloat(document.getElementById('Deductions').value) || 0;
            let netSalary = (basicSalary + overtimePay + bonus) - deductions;
            document.getElementById('NetSalary').value = netSalary.toFixed(2);
        }
    </script>
</head>
<body class="inner_page tables_page">
<?php if (isset($_SESSION['message'])): ?>
    <script>
        Swal.fire({
            icon: "<?php echo $_SESSION['message']['type']; ?>",
            title: "<?php echo $_SESSION['message']['text']; ?>",
            showConfirmButton: true,
            timer: 2500
        }).then((result) => {
                window.location.href = 'managesalary.php';
            
        });
    </script>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
    <div class="full_container">
        <div class="inner_container">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="content">
                <?php include_once('includes/header.php'); ?>
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Edit Salary Details</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Update Salary</h2>
                                        </div>
                                    </div>
                                    
                                    <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <div class="alert alert-primary" role="alert">
                                                            <form method="post">
                                                                <fieldset>
                                            <div class="form-group">
                                                <label  class="label_field">Basic Salary</label>
                                                <input type="number" id="BasicSalary" name="BasicSalary"  class="form-control" value="<?php echo htmlentities($result->BasicSalary); ?>" class="form-control" required oninput="calculateNetSalary()">
                                            </div>
                                            <div class="form-group">
                                                <label>Overtime Pay</label>
                                                <input type="number" id="OvertimePay" name="OvertimePay" value="<?php echo htmlentities($result->OvertimePay); ?>" class="form-control" required oninput="calculateNetSalary()">
                                            </div>
                                            <div class="form-group">
                                                <label>Bonus</label>
                                                <input type="number" id="Bonus" name="Bonus" value="<?php echo htmlentities($result->Bonus); ?>" class="form-control" required oninput="calculateNetSalary()">
                                            </div>
                                            <div class="form-group">
                                                <label>Deductions</label>
                                                <input type="number" id="Deductions" name="Deductions" value="<?php echo htmlentities($result->Deductions); ?>" class="form-control" required oninput="calculateNetSalary()">
                                            </div>
                                            <div class="form-group">
                                                <label>Net Salary</label>
                                                <input type="number" id="NetSalary" name="NetSalary" value="<?php echo htmlentities($result->NetSalary); ?>" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Payment Status</label>
                                                <select name="PaymentStatus" class="form-control" required>
                                                    <option value="Pending" <?php echo ($result->PaymentStatus == "Pending") ? "selected" : ""; ?>>Pending</option>
                                                    <option value="Paid" <?php echo ($result->PaymentStatus == "Paid") ? "selected" : ""; ?>>Paid</option>
                                                </select>
                                            </div>
                                            <button type="submit" name="update" class="btn btn-success">Update Salary</button>
                                            <a href="managesalary.php" class="btn btn-secondary">Cancel</a>
                                            </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>

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
          <!--sweetalert-->
</body>
</html>
