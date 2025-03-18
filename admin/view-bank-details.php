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
  <!--sweetalert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                            <h2>Bank Details</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <?php
if (isset($_GET['payid']) && is_numeric($_GET['payid'])) {
    $payid = isset($_GET['payid']) ? intval($_GET['payid']) : 0;

    $sql = "SELECT tblbankdetails.*, tblemployee.EmpName 
    FROM tblbankdetails
    LEFT JOIN tblemployee ON tblemployee.EmpId = tblbankdetails.EmpID 
    WHERE tblbankdetails.EmpID = :payid";

                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':payid', $payid, PDO::PARAM_INT);

                                                if (!$query->execute()) {
                                                    error_log("Database error: " . implode(", ", $query->errorInfo()));
                                                    echo "<div class='errorWrap'>Something went wrong. Please try again later.</div>";
                                                } else {
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() == 0) {
                                                        echo "<div class='errorWrap'>No Bank details found for this ID.</div>";
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
                                                                <th>Employee ID</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->EmpID); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Employee Name</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->EmpName); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bank Name</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->BankName); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>AccountNumber</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->AccountNumber); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>IFSC code</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->IFSC); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Branch</th>
                                                                <td colspan="2"><?php echo htmlspecialchars($result->Branch); ?></td>
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
