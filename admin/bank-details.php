

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
    <title>Employee Task Management System || Manage Salary</title>
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
                                                        <th>#</th>
                                                        <th>Employee ID</th>
                                                        <th>Employee Name</th>
                                                        <th>Bank Name</th>
                                                        <th>Account Number</th>
                                                        <th>IFSC Code</th>
                                                        <th>Branch</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php


// Fetch all employee bank details
$sql = "SELECT e.EmpId, e.EmpName, b.BankName, b.AccountNumber, b.IFSC, b.Branch 
        FROM tblemployee e
        JOIN tblbankdetails b ON e.EmpId = b.EmpID 
        ORDER BY e.EmpName ASC";

$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

                                                <?php 
                                                    if ($query->rowCount() > 0) {
                                                        $cnt = 1;
                                                        foreach ($results as $row) { ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt); ?></td>
                                                                <td><?php echo htmlentities($row->EmpId); ?></td>
                                                                <td><?php echo htmlentities($row->EmpName); ?></td>
                                                                <td><?php echo htmlentities($row->BankName); ?></td>
                                                                <td><?php echo htmlentities($row->AccountNumber); ?></td>
                                                                <td><?php echo htmlentities($row->IFSC); ?></td>
                                                                <td><?php echo htmlentities($row->Branch); ?></td>
                                                                <td>
                                                                        <a href="view-bank-details.php?payid=<?php echo htmlentities($row->EmpId); ?>">
                                                                        <i  class="material-icons yellow_color">visibility</i>   </a>
                                                                    </td>
                                                            </tr>
                                                            <?php 
                                                            $cnt++;
                                                        }
                                                    } else { ?>
                                                        <tr>
                                                            <td colspan="7" style="text-align: center;">No Bank Details Found</td>
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
      <!--sweetalert-->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
<?php } ?>