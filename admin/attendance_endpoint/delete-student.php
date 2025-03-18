<?php
session_start();
include('../includes/dbconnection.php');


if (isset($_GET['student'])) {
    $student = $_GET['student'];

    try {

        $query = "DELETE FROM tbl_student WHERE tbl_student_id = '$student'";

        $stmt = $dbh->prepare($query);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
                <script>
                    alert('Student deleted successfully!');
                    window.location.href = 'http://localhost/ETMS-MAIN/admin/attendance_masterlist.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Failed to delete student!');
                    window.location.href = 'http://localhost/ETMS-MAIN/admin/attendance_masterlist.php';
                </script>
            ";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>