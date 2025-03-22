<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['BankID'])) {
    $BankID = filter_input(INPUT_POST, 'BankID', FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT BankID FROM tblbankdetails WHERE BankID = :BankID";
    $query = $dbh->prepare($sql);
    $query->bindParam(':BankID', $BankID, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo $result['BankID'];
    } else {
        echo '';
    }
}
?>
