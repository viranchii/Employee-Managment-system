



<?php
session_start();
include("includes/dbconnection.php");

// Set correct timezone
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['qr_code'])) {
        $qrCode = $_POST['qr_code'];

        // Validate if the QR code exists for an employee
        $selectStmt = $dbh->prepare("SELECT EmpId FROM tblemployee WHERE qrcode = :qrcode");
        $selectStmt->bindParam(":qrcode", $qrCode, PDO::PARAM_STR);
        $selectStmt->execute();
        $result = $selectStmt->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            $employeeID = $result["EmpId"];
            $attendanceDate = date("Y-m-d");
            $currentTime = date("H:i:s");

            // Default values
            $remarks = "";
            $status = "Present"; // Default status for check-in

            // Check if the employee already has an attendance entry for today
            $checkStmt = $dbh->prepare("SELECT id, check_in_time, check_out_time FROM empattendance 
                                        WHERE employee_id = :employee_id AND attendance_date = :attendance_date");
            $checkStmt->bindParam(":employee_id", $employeeID, PDO::PARAM_INT);
            $checkStmt->bindParam(":attendance_date", $attendanceDate, PDO::PARAM_STR);
            $checkStmt->execute();
            $attendance = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($attendance) {
                // Employee has already checked in, so update check_out_time and status
                if ($attendance['check_out_time'] === null) {
                    $updateStmt = $dbh->prepare("UPDATE empattendance 
                                                 SET check_out_time = :check_out_time, status = 'Checked Out', remarks = 'Checked Out' 
                                                 WHERE id = :attendance_id");
                    $updateStmt->bindParam(":check_out_time", $currentTime, PDO::PARAM_STR);
                    $updateStmt->bindParam(":attendance_id", $attendance['id'], PDO::PARAM_INT);
                    $updateStmt->execute();

                    $_SESSION['msg'] = "Check-out recorded successfully!";
                    $_SESSION['type'] = "success";
                } else {
                    $_SESSION['msg'] = "Already checked out for today!";
                    $_SESSION['type'] = "info";
                }
            } else {
                // Determine if late (Example: 9:30 AM is the cutoff time)
                $cutoffTime = "09:30:00";
                if ($currentTime > $cutoffTime) {
                    $remarks = "Late Arrival";
                    $status = "Late"; // Update status if late
                } else {
                    $remarks = "On Time";
                }

                // Employee is checking in for the first time today
                $insertStmt = $dbh->prepare("INSERT INTO empattendance (employee_id, attendance_date, check_in_time, status, remarks) 
                                             VALUES (:employee_id, :attendance_date, :check_in_time, :status, :remarks)");
                $insertStmt->bindParam(":employee_id", $employeeID, PDO::PARAM_INT);
                $insertStmt->bindParam(":attendance_date", $attendanceDate, PDO::PARAM_STR);
                $insertStmt->bindParam(":check_in_time", $currentTime, PDO::PARAM_STR);
                $insertStmt->bindParam(":status", $status, PDO::PARAM_STR);
                $insertStmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
                $insertStmt->execute();

                $_SESSION['msg'] = "Check-in recorded successfully!";
            $_SESSION['type'] = "success";
        }
    } else {
        $_SESSION['msg'] = "Invalid QR Code!";
        $_SESSION['type'] = "error";
    }
    header("Location: qrScan.php");
exit();
    } 
}
?>
