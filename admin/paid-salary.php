<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Code for deletion
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblsalary WHERE ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Salary record deleted');</script>";
        echo "<script>window.location.href = 'manage-salary.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Management System || Manage Salary</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="css\materialPreloader.min.css" rel="stylesheet">
        <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
</head>
<body class="inner_page tables_page">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar -->
            <?php include_once('includes/sidebar.php'); ?>
            <!-- Right Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once('includes/header.php'); ?>
                <!-- End Topbar -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Manage Salary</h2>
                                </div>
                            </div>
                        </div>
                        <!-- Salary Table -->
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
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Employee Name</th>
                                                        <th>Basic Salary</th>
                                                        <th>Overtime Pay</th>
                                                        <th>Bonus</th>
                                                        <th>Deductions</th>
                                                        <th>Net Salary</th>
                                                        <th>Payment Status</th>
                                                        <th>Payment Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT tblemployee.EmpName, tblsalary.* 
                                                            FROM tblsalary 
                                                            INNER JOIN tblemployee ON tblsalary.EmpID = tblemployee.EmpId
                                                            WHERE tblsalary.PaymentStatus='paid'";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $row) { ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt); ?></td>
                                                                <td><?php echo htmlentities($row->EmpName); ?></td>
                                                                <td><?php echo htmlentities($row->BasicSalary); ?></td>
                                                                <td><?php echo htmlentities($row->OvertimePay); ?></td>
                                                                <td><?php echo htmlentities($row->Bonus); ?></td>
                                                                <td><?php echo htmlentities($row->Deductions); ?></td>
                                                                <td><?php echo htmlentities($row->NetSalary); ?></td>
                                                                <td>
                                               <?php if(strtolower($row->PaymentStatus) == "pending"): ?>
    <span class="badge bg-warning text-dark">Pending</span>
<?php elseif(strtolower($row->PaymentStatus) == "paid"): ?>
    <span class="badge bg-success">Paid</span>
<?php endif; ?>

                                            </td>
                                                                <td><?php echo htmlentities($row->PaymentDate); ?></td>
                                                                <td>
                                                                        <a href="view-paid-salary.php?payid=<?php echo htmlentities($row->SalaryID); ?>"
                                                                            > <i  class="material-icons yellow_color">visibility</i></a>
                                                                    </td>
                                                            </tr>
                                                    <?php $cnt++;
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
      <!--sweetalert-->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
<?php } ?>
