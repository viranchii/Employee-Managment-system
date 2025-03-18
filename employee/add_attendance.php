<?php
session_start();
include('includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $qr_code = $_POST['qr_code'];

    // Check if employee exists
    $sql = "SELECT employee_id FROM employees WHERE emp_qr_code=:qr_code";
    $query = $dbh->prepare($sql);
    $query->bindParam(':qr_code', $qr_code, PDO::PARAM_STR);
    $query->execute();
    $employee = $query->fetch(PDO::FETCH_OBJ);

    if ($employee) {
        $employee_id = $employee->employee_id;

        // Insert attendance record
        $insert_sql = "INSERT INTO empattendance (employee_id, attendance_date, check_in_time) VALUES (:empid, CURDATE(), CURTIME())";
        $insert_query = $dbh->prepare($insert_sql);
        $insert_query->bindParam(':empid', $employee_id, PDO::PARAM_INT);
        $insert_query->execute();

        $_SESSION['msg'] = "Attendance recorded successfully!";
    } else {
        $_SESSION['msg'] = "Invalid QR Code!";
    }

    header("Location:qrScan.php");
    exit();
}
?>
