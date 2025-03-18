<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['empid']) == 0) {
    header('location:logout.php');
    exit();
} 
    if (isset($_GET['id'])) {
        $bankID = intval($_GET['id']); // Sanitize input
        $empid = $_SESSION['empid'];

        // Delete only if the record belongs to the logged-in employee
        $sql = "DELETE FROM tblbankdetails WHERE BankID=:bankid AND EmpID=:empid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bankid', $bankID, PDO::PARAM_INT);
        $query->bindParam(':empid', $empid, PDO::PARAM_INT);

        if ($query->execute()) {
            $_SESSION['msg'] = "deleted"; // Store message in session
        } else {
            $_SESSION['msg'] = "error"; // Store error message
        }
 // Redirect to manage-bankdetails.php to display the alert
 header("Location: manage-bankdetails.php");
 exit();
   

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            });
        } else if (msg === "error") {
            Swal.fire({
                title: "Error!",
                text: "Failed to delete the record. Please try again.",
                icon: "error",
                confirmButtonColor: "#d33",
                confirmButtonText: "OK"
            });
        }
    });
</script>
<?php endif; ?>

</head>
<body>

</body>
</html>