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

// Define a folder to store QR codes
$qrDir = "qrcodes/";
if (!file_exists($qrDir)) {
    mkdir($qrDir, 0777, true);
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

// Fetch all salary records
$sql = "SELECT tblemployee.EmpName, tblsalary.*, tblbankdetails.BankName, 
        tblbankdetails.AccountNumber, tblbankdetails.IFSC 
        FROM tblsalary 
        INNER JOIN tblemployee ON tblsalary.EmpID = tblemployee.EmpId
        INNER JOIN tblbankdetails ON tblsalary.EmpID = tblbankdetails.EmpID";

$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Salary</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        .qr-container img {
            width: 150px;
            height: 150px;
        }
    </style>
</head>
<body>
<?php
if (isset($_SESSION['msg'])) {
    echo "<script>
        Swal.fire({
            title: 'Deleted!',
            text: '" . $_SESSION['msg'] . "',
            icon: 'success'
        });
    </script>";
    unset($_SESSION['msg']);
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

<div class="container mt-5">
    <h2>Manage Salaries</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Employee Name</th>
                <th>Net Salary</th>
                <th>Bank Name</th>
                <th>Account Number</th>
                <th>IFSC</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cnt = 1;
            foreach ($results as $row) {
                $empID = $row->EmpID;
                $qrText = "http://yourwebsite.com/scan.php?empid=" . $empID;
                $qrFile = $qrDir . "emp_" . $empID . ".png";

                // Generate QR Code if not already generated
                if (!file_exists($qrFile)) {
                    QRcode::png($qrText, $qrFile, QR_ECLEVEL_L, 4);
                }
            ?>
                <tr>
                    <td><?php echo htmlentities($cnt); ?></td>
                    <td><?php echo htmlentities($row->EmpName); ?></td>
                    <td>$<?php echo htmlentities($row->NetSalary); ?></td>
                    <td><?php echo htmlentities($row->BankName); ?></td>
                    <td><?php echo htmlentities($row->AccountNumber); ?></td>
                    <td><?php echo htmlentities($row->IFSC); ?></td>
                    <td class="qr-container"><img src="<?php echo $qrFile; ?>" alt="Scan to Pay"></td>
                    <td>
                        <button class="pay-button" onclick="window.location.href='scan.php?empid=<?php echo $empID; ?>'">Pay</button>
                        <button class="btn btn-danger" onclick="confirmDelete(<?php echo $row->SalaryID; ?>)">Delete</button>
                    </td>
                </tr>
            <?php
                $cnt++;
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
