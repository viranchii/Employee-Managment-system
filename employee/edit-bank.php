<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_SESSION['empid']) || empty($_SESSION['empid'])) {
    header('location:logout.php');
    exit();
}

$empid = $_SESSION['empid'];
$bankId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$bankName = "";
$accountNumber = "";
$ifsc = "";
$branch = "";

// Fetch existing bank details if ID is provided
if ($bankId > 0) {
    $stmt = $dbh->prepare("SELECT * FROM tblbankdetails WHERE BankID = :bankId AND EmpID = :empid");
    $stmt->bindParam(':bankId', $bankId, PDO::PARAM_INT);
    $stmt->bindParam(':empid', $empid, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $bankData = $stmt->fetch(PDO::FETCH_ASSOC);
        $bankName = $bankData['BankName'];
        $accountNumber = $bankData['AccountNumber'];
        $ifsc = $bankData['IFSC'];
        $branch = $bankData['Branch'];
    } else {
        header("Location: manage-bank.php"); // Redirect if no record found
        exit();
    }
}

if (isset($_POST['submit'])) {
    $bankName = $_POST['bank_name'];
    $accountNumber = $_POST['account_number'];
    $ifsc = $_POST['ifsc'];
    $branch = $_POST['branch'];

    if ($bankId > 0) {
        // Update existing bank details
        $sql = "UPDATE tblbankdetails SET BankName=:bankName, AccountNumber=:accountNumber, IFSC=:ifsc, Branch=:branch WHERE BankID=:bankId AND EmpID=:empid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':bankId', $bankId, PDO::PARAM_INT);
    } else {
        // Insert new bank details
        $sql = "INSERT INTO tblbankdetails (EmpID, BankName, AccountNumber, IFSC, Branch) VALUES (:empid, :bankName, :accountNumber, :ifsc, :branch)";
        $query = $dbh->prepare($sql);
    }

    $query->bindParam(':empid', $empid, PDO::PARAM_INT);
    $query->bindParam(':bankName', $bankName, PDO::PARAM_STR);
    $query->bindParam(':accountNumber', $accountNumber, PDO::PARAM_STR);
    $query->bindParam(':ifsc', $ifsc, PDO::PARAM_STR);
    $query->bindParam(':branch', $branch, PDO::PARAM_STR);

    if ($query->execute()) {
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => $bankId > 0 ? "Bank details updated successfully!" : "Bank details added successfully!"
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => "Something went wrong! Please try again."
        ];
    }
    
    header("Location: edit-bank.php"); // Redirect to avoid form resubmission
    exit;
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>

        <title>Employee Management System || Add Bank Details</title>

        <link rel="stylesheet" href="css/bootstrap.min.css" />
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body class="inner_page tables_page">
    <?php if (isset($_SESSION['message'])): ?>
<script>
    Swal.fire({
        icon: '<?= $_SESSION['message']['type']; ?>',
        title: '<?= ucfirst($_SESSION['message']['type']); ?>!',
        text: '<?= $_SESSION['message']['text']; ?>',
        showConfirmButton: true, // Show OK button
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'manage-bankdetails.php'; // Redirect on OK button click
        }
    });
</script>
<?php unset($_SESSION['message']); ?>
<?php endif; ?>
        <div class="full_container">
            <div class="inner_container">
                <!-- Sidebar  -->
                <?php include_once('includes/sidebar.php'); ?>
                <!-- right content -->
                <div id="content">
                    <!-- topbar -->
                    <?php include_once('includes/header.php'); ?>
                    <!-- end topbar -->
                    <!-- dashboard inner -->
                    <div class="midde_cont">
                        <div class="container-fluid">
                            <div class="row column_title">
                                <div class="col-md-12">
                                    <div class="page_title">
                                        <h2>Add Bank Details</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                               
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Add Bank Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-10">

                                                    <br />
                                                    <form method="post" name="complaint" enctype="multipart/form-data">


                                                        <div class="form-group">
                                                        <label for="bank_name" class="form-label">Bank Name:</label>
                                                        <input type="text" class="form-control" name="bank_name" value="<?= htmlentities($bankName); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                        <label for="account_number" class="form-label">Account Number:</label>
                                                        <input type="text" class="form-control" name="account_number" value="<?= htmlentities($accountNumber); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                        <label for="ifsc" class="form-label">IFSC Code:</label>
                                                        <input type="text" class="form-control" name="ifsc" value="<?= htmlentities($ifsc); ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                        <label for="branch" class="form-label">Branch Name:</label>
                                                        <input type="text" class="form-control" name="branch" value="<?= htmlentities($branch); ?>" required>
                                                        </div>

                                                        <button type="submit" name="submit" class="btn btn-primary"><?= $bankId > 0 ? "Update" : "Add" ?> Bank Details</button>
                                                        <a href="bank-list.php" class="btn btn-secondary">Cancel</a>
                                                    </form>
                                                </div>

                                            </div>


                                        </div>
                                    </div>

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
    </body>

</html>
