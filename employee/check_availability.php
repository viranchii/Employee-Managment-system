<?php
if (!empty($_POST["leave_from"])) {
    $leave_from = $_POST["leave_from"];
    $today = date("Y-m-d");

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $leave_from)) {
        echo "<span style='color:red'> Invalid Date format. Use YYYY-MM-DD.</span>";
    } elseif ($leave_from < $today) {
        echo "<span style='color:red'> Leave From date cannot be in the past.</span>";
    } else {
        echo "<span style='color:green'> Leave From date is valid.</span>";
    }
}

if (!empty($_POST["leave_from"]) && !empty($_POST["leave_to"])) {
    $leave_from = $_POST["leave_from"];
    $leave_to = $_POST["leave_to"];

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $leave_to)) {
        echo "<span style='color:red'> Invalid Date format. Use YYYY-MM-DD.</span>";
    } elseif ($leave_to < $leave_from) {
        echo "<span style='color:red'> Leave To date must be after or equal to Leave From date.</span>";
    } else {
        echo "<span style='color:green'> Leave To date is valid.</span>";
    }
}

?>