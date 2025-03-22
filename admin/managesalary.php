<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('phpqrcode/qrlib.php'); // Include QR Code library

// Ensure session is active
if (!isset($_SESSION['etmsaid']) || strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// Handle salary record deletion
if (isset($_GET['delid']) && is_numeric($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE FROM tblsalary WHERE SalaryID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    if ($query->execute()) {
        $_SESSION['msg'] = "Salary record has been deleted successfully.";
    } else {
        $_SESSION['msg'] = "Error deleting record.";
    }
    header("Location: managesalary.php");
    exit();
}

// Handle payment update
if (isset($_POST['payNow'])) {
    $salaryID = intval($_POST['salaryID']);
    $paymentDate = date("Y-m-d");

    $updateQuery = "UPDATE tblsalary SET PaymentStatus='Paid', PaymentDate=:paymentDate WHERE SalaryID=:salaryID";
    $stmt = $dbh->prepare($updateQuery);
    $stmt->bindParam(':salaryID', $salaryID, PDO::PARAM_INT);
    $stmt->bindParam(':paymentDate', $paymentDate, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Payment successful.";
    } else {
        $_SESSION['msg'] = "Payment failed.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Management System || Manage Salary</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />

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

    <script async src="https://pay.google.com/gp/p/js/pay.js"></script>

    <!--sweetalert-->
    <link rel="stylesheet" href="style.css" />

    <style>
        .pay-button {
            border: none;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .pay-button:hover {
            background: #0056b3;
        }

        .payment-form {
            position: fixed;
            top: -180%;
            /* Adjusted to make it appear near the top */
            left: 50%;
            transform: translate(-50%, 0);
            width: 50%;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            transition: top 0.5s ease-in-out;
            z-index: 1000;
            max-height: 80vh;
            /* Ensures it doesn’t exceed viewport */
            overflow-y: auto;
            /* Enables scrolling if content exceeds height */
            border-radius: 10px;
        }

        .close-btn {
            float: right;
            cursor: pointer;
            font-size: 18px;
            background: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
        }

        .confirmation-message {
            font-size: 16px;
            font-weight: bold;
            color: #d9534f;
            background-color: #f9f2f4;
            padding: 10px;
            border: 2px solid #d9534f;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 10px;
        }

        .confirm-button {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: linear-gradient(to right, #28a745, #218838);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
    <script>
        function showPaymentForm(bankName, accNumber, ifsc, salaryID) {
            document.getElementById("bankName").value = bankName;
            document.getElementById("accNumber").value = accNumber;
            document.getElementById("ifscCode").value = ifsc;
            document.getElementById("salaryID").value = salaryID;
            document.getElementById("paymentForm").style.top = "10%";
        }

        function closePaymentForm() {
            document.getElementById("paymentForm").style.top = "-180%";
        }
    </script>

</head>

<body class="inner_page tables_page">
    <?php
    if (isset($_SESSION['msg'])) {
        echo "<script>
        Swal.fire({
            title: 'Message',
            text: '" . $_SESSION['msg'] . "',
            icon: 'success'
        });
    </script>";
        unset($_SESSION['msg']); // Clear message after displaying
    }
    ?>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'managesalary.php?delid=' + id;
                }
            });
        }
    </script>


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
                                                    $sql = "SELECT tblemployee.EmpName, tblsalary.*, tblbankdetails.BankName, tblbankdetails.AccountNumber, tblbankdetails.IFSC 
                                                    FROM tblsalary 
                                                    INNER JOIN tblemployee ON tblsalary.EmpID = tblemployee.EmpId
                                                    INNER JOIN tblbankdetails ON tblsalary.EmpID = tblbankdetails.EmpID";

                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $row) {

                                                    ?>
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
                                                                    <?php else: ?>
                                                                        <span class="badge bg-success">Paid</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo (!empty($row->PaymentDate) ? htmlentities($row->PaymentDate) : '<span class="text-danger">Not Paid Yet</span>'); ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($row->PaymentStatus == "Paid") { ?>
                                                                        <button class="btn btn-success btn-sm" disabled>Already Paid</button>
                                                                    <?php } else { ?>
                                                                        <button class="btn btn-info btn-sm" onclick="showPaymentForm('<?php echo $row->BankName; ?>', '<?php echo $row->AccountNumber; ?>', '<?php echo $row->IFSC; ?>', '<?php echo $row->SalaryID; ?>')">Pay Now</button>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <!-- Show edit button only if PaymentStatus is Pending -->
                                                                    <?php if (strtolower($row->PaymentStatus) == "pending"): ?>
                                                                        <a href="edit-salary.php?editid=<?php echo htmlentities($row->SalaryID); ?>" >
                                                                        <i class="material-icons green_color">mode_edit</i>
                                                                        </a>
                                                                    <?php endif; ?>

                                                                    <!-- Delete button should always be visible -->
                                                                    <a href="javascript:void(0);" onclick="confirmDelete(<?php echo htmlentities($row->SalaryID); ?>);" >
                                                                    <i class="material-icons red_color">delete_forever</i>
                                                                    </a>
                                                                   
                                                                </td>


                                                            </tr>

                                                    <?php $cnt++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <div class="payment-form" id="paymentForm">
                                                <button class="close-btn" onclick="closePaymentForm()">X</button>
                                                <h2>Payment Details</h2><br><br>

                                                <form method="POST">
                                                    <div class="mb-3">
                                                        <label for="bankName" class="form-label">Bank Name</label>
                                                        <input type="text" class="form-control" id="bankName" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="accNumber" class="form-label">Account Number</label>
                                                        <input type="text" class="form-control" id="accNumber" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ifscCode" class="form-label">IFSC Code</label>
                                                        <input type="text" class="form-control" id="ifscCode" readonly>
                                                    </div>
                                                    <input type="hidden" id="salaryID" name="salaryID">
                                                    <div class="confirmation-message">
                                                        Are you sure you want to mark this salary as this Bank Details to paid?
                                                    </div>

                                                    <button type="submit" name="payNow" class="confirm-button">Confirm Payment</button>
                                            </div>
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