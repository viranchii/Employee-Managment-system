<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_GET['empid']) || !is_numeric($_GET['empid'])) {
    echo "Invalid request.";
    exit();
}

$empid = intval($_GET['empid']);

// Fetch salary details for the employee
$sql = "SELECT tblemployee.EmpName, tblsalary.NetSalary 
        FROM tblsalary 
        INNER JOIN tblemployee ON tblsalary.EmpID = tblemployee.EmpId 
        WHERE tblsalary.EmpID = :empid";

$query = $dbh->prepare($sql);
$query->bindParam(':empid', $empid, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "No salary details found!";
    exit();
}

$empName = $result['EmpName'];
$netSalary = $result['NetSalary'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Salary Payment</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Salary Details for <?php echo htmlentities($empName); ?></h2>
        <p><strong>Net Salary:</strong> $<?php echo htmlentities($netSalary); ?></p>
        
        <button class="pay-button" onclick="processPayment()">Pay Salary</button>
    </div>

    <script>
        function processPayment() {
            alert("Payment Process Started for <?php echo htmlentities($empName); ?>");
            // You can add an AJAX request here to update salary payment status in the database
        }
    </script>
</body>
</html>
