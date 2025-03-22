<?php
include('includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bankId'])) {
    $bankId = $_POST['bankId'];
    
    $sql = "SELECT * FROM tblbankdetails WHERE EmpId = :bankId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bankId', $bankId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['status' => 'success', 'data' => $result]);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
