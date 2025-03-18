<?php
session_start();
include('includes/dbconnection.php');

// Check if user is logged in
if (strlen($_SESSION['empid']) == 0) {
    header('location:logout.php');
    exit();
}

// Check if 'id' is set in URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Prevent SQL Injection

    // Delete the leave request
    $sql = "DELETE FROM tblleaves WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($query->execute()) {
        $_SESSION['msg'] = "deleted"; // Store message in session
    } else {
        $_SESSION['msg'] = "error"; // Store error message
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Leave Request</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
document.addEventListener("DOMContentLoaded", function () {
    <?php if (isset($_SESSION['msg'])): ?>
        let msg = "<?php echo $_SESSION['msg']; ?>";
        <?php unset($_SESSION['msg']); // Clear session message ?>

        if (msg === "deleted") {
            Swal.fire({
                title: "Deleted!",
                text: "The record has been deleted successfully.",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            }).then(() => {
        window.location.href = "leavehistory.php"; // Redirect after clicking OK
    });
        } else if (msg === "error") {
            Swal.fire({
                title: "Error!",
                text: "Failed to delete the record. Please try again.",
                icon: "error",
                confirmButtonColor: "#d33",
                confirmButtonText: "OK"
            }).then(() => {
        window.location.href = "leavehistory.php"; // Redirect after clicking OK
    });
        }
    <?php endif; ?>
});
</script>

</body>
</html>