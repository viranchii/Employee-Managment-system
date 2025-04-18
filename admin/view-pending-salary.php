<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Management System || Salary Details</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="js/semantic.min.css" />
    <link rel="stylesheet" href="css/jquery.fancybox.css" />

    <style>
        .errorWrap, .succWrap {
            padding: 10px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .errorWrap { border-left: 4px solid #dd3d36; }
        .succWrap { border-left: 4px solid #5cb85c; }
    </style>
</head>

<body class="inner_page tables_page">
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
                                    <h2>Salary Details</h2>
                                </div>
                            </div>
                        </div>

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
                                            <?php
if (isset($_GET['payid']) && is_numeric($_GET['payid'])) {
    $payid = intval($_GET['payid']);

                                                $sql = "SELECT tblsalary.*, tblemployee.EmpName 
                                                        FROM tblsalary 
                                                        JOIN tblemployee ON tblemployee.EmpId = tblsalary.EmpID 
                                                        WHERE tblsalary.SalaryID = :payid"
;

                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':payid', $payid, PDO::PARAM_INT);

                                                if (!$query->execute()) {
                                                    error_log("Database error: " . implode(", ", $query->errorInfo()));
                                                    echo "<div class='errorWrap'>Something went wrong. Please try again later.</div>";
                                                } else {
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() == 0) {
                                                        echo "<div class='errorWrap'>No salary details found for this ID.</div>";
                                                    } else {
                                                        foreach ($results as $result) {
                                            ?>
                                                        <table class="table table-bordered" style="color:#000">
                                                            <tr>
                                                                <th colspan="6" style="color: orange; font-weight: bold; font-size: 20px; text-align: center;">
                                                                    Salary Details
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>Employee Name</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->EmpName); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Basic Salary</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->BasicSalary); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>OverTime Pay</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->OvertimePay); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bouns</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->Bonus); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Deductions</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->Deductions); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Salary</th>
                                                                <td><?php echo htmlspecialchars($result->NetSalary); ?></td>
                                                            </tr>
                                                            <tr>
                                                               
                                                            <tr>
                                                                <th>Payment Status</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->PaymentStatus); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Payment Date</th>
                                                                <td><?php echo htmlspecialchars($result->PaymentDate); ?>Not Paid Yet</td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2" style="text-align: center;" ><a href="edit-salary.php?editid=<?php echo htmlentities($result->SalaryID); ?>" class="btn btn-primary btn-sm">Edit</a></td>
                                                            </tr>
                                                        </table>
                                            <?php
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo "<div class='errorWrap'>Invalid request. Payroll ID is missing.</div>";
                                            }
                                            ?>
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
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/analyser.js"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/semantic.min.js"></script>
</body>

</html>
