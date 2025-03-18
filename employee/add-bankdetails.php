<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);
if (!isset($_SESSION['empid']) || empty($_SESSION['empid'])) {
    header('location:logout.php');
    exit();
}

$empid = isset($_SESSION['empid']) ? (int) $_SESSION['empid'] : 0;
$msg = "";  // Ensure variable is always defined
$error = "";  // Define error variable for display

if ($empid > 0) {
    $empCheckQuery = $dbh->prepare("SELECT EmpId FROM tblemployee WHERE EmpId = :empid LIMIT 1");
    $empCheckQuery->bindParam(':empid', $empid, PDO::PARAM_INT);
    $empCheckQuery->execute();
    
    if ($empCheckQuery->rowCount() == 0) {
        $error = "Invalid Employee ID!";
    }
} else {
    $error = "Session EmpID is not set!";
}

if (isset($_POST['submit'])) {
    $bankName = trim($_POST['bank_name']);
    $accountNumber = trim($_POST['account_number']);
    $ifsc = strtoupper(trim($_POST['ifsc'])); // Convert IFSC to uppercase
    $branch = trim($_POST['branch']);

    
 // Account Number Validation
 if (!preg_match('/^\d{10,18}$/', $accountNumber)) {
    $error = "Invalid Account Number! It should be 10-18 digits long and contain only numbers.";
}

// IFSC Code Validation
elseif (!preg_match('/^[A-Z]{4}[0-9]{7}$/', $ifsc)) {
    $error = "Invalid IFSC Code! It should be in the format ABCD1234567.";
}

   
        if (empty($error)) {
            try {
            // Check if account number already exists
            $checkQuery = $dbh->prepare("SELECT AccountNumber FROM tblbankdetails WHERE AccountNumber = :accountNumber");
            $checkQuery->bindParam(':accountNumber', $accountNumber, PDO::PARAM_STR);
            $checkQuery->execute();

            if ($checkQuery->rowCount() > 0) {
                $error = "Account number already exists!";
            } else {
                // Insert bank details
                $sql = "INSERT INTO tblbankdetails (EmpID, BankName, AccountNumber, IFSC, Branch) 
                        VALUES (:empid, :bankName, :accountNumber, :ifsc, :branch)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':empid', $empid, PDO::PARAM_INT);
                $query->bindParam(':bankName', $bankName, PDO::PARAM_STR);
                $query->bindParam(':accountNumber', $accountNumber, PDO::PARAM_STR);
                $query->bindParam(':ifsc', $ifsc, PDO::PARAM_STR);
                $query->bindParam(':branch', $branch, PDO::PARAM_STR);

                if ($query->execute()) {
                    $msg = "Bank details added successfully!";
                } else {
                    $error = "Error adding bank details!";
                }
            }
            }catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
        }
    } 
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Management System || Add Bank Details</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                                    <h2>Add Bank Details</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php
                            if (!empty($error)) {
                                echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: '" . addslashes($error) . "',
                                            icon: 'error',
                                            confirmButtonColor: '#d33',
                                            confirmButtonText: 'OK'
                                        });
                                    });
                                </script>";
                            }

                            if (!empty($msg)) {
                                echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: '" . addslashes($msg) . "',
                                            icon: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            window.location.href = 'manage-bankdetails.php'; // Redirect after success
                                        });
                                    });
                                </script>";
                            }
                            ?>

                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h5>Add Bank Details</h5>
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
                                                                    <label for="bank_name">Bank Name:</label>
                                                                    <input type="text" class="form-control" name="bank_name" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="account_number">Account Number:</label>
                                                                    <input type="text" class="form-control" name="account_number" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="ifsc">IFSC Code:</label>
                                                                    <input type="text" class="form-control" name="ifsc" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="branch">Branch Name:</label>
                                                                    <input type="text" class="form-control" name="branch" required>
                                                                </div>
                                                                <button type="submit" name="submit" class="btn btn-primary">Add Bank Details</button>
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
                    <?php include_once('includes/footer.php'); ?>
                </div> <!-- midde_cont -->
            </div> <!-- content -->
        </div> <!-- inner_container -->
    </div> <!-- full_container -->

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
