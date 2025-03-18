<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_SESSION['empid'])) {
    header('location:logout.php');
    exit();
}

if (isset($_GET['id'])) {
    $complaint_id = $_GET['id'];

    // Delete complaint
    $query = "DELETE FROM tblcomplaints WHERE complaintNumber = :cid";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':cid', $complaint_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $message = "Complaint deleted successfully!";
        $status = "success";
    } else {
        $message = "Error deleting complaint.";
        $status = "error";
    }
} else {
    $message = "Invalid request.";
    $status = "warning";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Complaint</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            title: "<?php echo $message; ?>",
            icon: "<?php echo $status; ?>",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "complaint-history.php";
        });
    </script>
</body>
</html>
