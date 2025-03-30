<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['empid']==0)) {
  header('location:logout.php');
  } else{



  ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Management System | Salary</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="css\materialPreloader.min.css" rel="stylesheet">
        <link href="css/jquery.dataTables.min.css" rel="stylesheet">

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
                                    <h2>Salary</h2>
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
                                                        <th>Download Slip</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 

$empid = $_SESSION['empid'];

// Prepare SQL query to fetch only the logged-in employee's salary details
$sql = "SELECT tblsalary.*, tblemployee.EmpName 
        FROM tblsalary  
        INNER JOIN tblemployee ON tblsalary.EmpID = tblemployee.EmpId
        WHERE tblsalary.EmpID = :empid ";

$query = $dbh->prepare($sql);
$query->bindParam(':empid', $empid, PDO::PARAM_STR);

// Execute and check for errors
if (!$query->execute()) {
    die("SQL Error: " . implode(" | ", $query->errorInfo()));
}

// Fetch results
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
?>
                                                    <?php if (!empty($results)) { 
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
                                                                    <?php if (strtolower($row->PaymentStatus) == "pending"): ?>
                                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                                    <?php elseif (strtolower($row->PaymentStatus) == "paid"): ?>
                                                                        <span class="badge bg-success">Paid</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-secondary">Unknown</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td><?php echo htmlentities($row->PaymentDate); ?></td>
                                                                <td>
    <?php if (strtolower($row->PaymentStatus) == "paid"): ?>
        <a href="download_salary_slip.php?salary_id=<?php echo $row->SalaryID; ?>" class="btn btn-outline-success btn-sm">
            <i class="material-icons green_color">download</i>
        </a>
    <?php else: ?>
        <a class="btn btn-outline-warning btn-sm"> <i class="material-icons yellow_color" >hourglass_top</i></a>
       
    <?php endif; ?>
</td>
                                                            </tr>
                                                    <?php $cnt++;
                                                        }
                                                    } else { ?>
                                                        <tr>
                                                            <td colspan="9" class="text-center">No salary details found.</td>
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
                    <!-- Footer -->
                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>