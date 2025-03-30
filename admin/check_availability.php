<?php
require_once("includes/dbconnection.php");


//code check Empid
if(!empty($_POST["empid"])) {
$empid=$_POST["empid"];
$sql ="SELECT empid FROM tblemployee WHERE EmpId=:empid";
$query= $dbh -> prepare($sql);
$query-> bindParam(':empid', $empid, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
 
if($query -> rowCount() > 0)
echo "<span style='color:red'> Employee Id already assign to another employee.</span>";
else
 echo "<span style='color:green'> Employee Id avaialble for registration.</span>";
 
}

//code check Email

if (!empty($_POST["empemail"])) {
    $empemail = $_POST["empemail"];

    // Validate the email format
    if (!filter_var($empemail, FILTER_VALIDATE_EMAIL)) {
        echo "<span style='color:red'> Invalid Email format. Please enter a valid email address.</span>";
    } else {
        // Query to check if the email already exists
        $sql = "SELECT EmpEmail FROM tblemployee WHERE EmpEmail=:empemail";
        $query = $dbh->prepare($sql);
        $query->bindParam(':empemail', $empemail, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            echo "<span style='color:red'> Email id already registered with another employee.</span>";
        } else {
            echo "<span style='color:green'> Email Id available for registration.</span>";
        }
    }
}



//code check mobile
if (!empty($_POST["empcontno"])) {
    $empcontno = $_POST["empcontno"];

    // Check if the contact number contains only digits and is exactly 10 digits
    if (!preg_match('/^[0-9]{10}$/', $empcontno)) {
        echo "<span style='color:red'> Contact Number should be exactly 10 digits and must not contain any characters.</span>";
    } else {
        // Query to check if the contact number already exists
        $sql = "SELECT EmpContactNumber FROM tblemployee WHERE EmpContactNumber=:empcontno";
        $query = $dbh->prepare($sql);
        $query->bindParam(':empcontno', $empcontno, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        
        if ($query->rowCount() > 0) {
            echo "<span style='color:red'> Contact Number already registered with another employee.</span>";
        } else {
            echo "<span style='color:green'> Contact Number available for registration.</span>";
        }
    }
}

//date
if (!empty($_POST["empdob"])) {
    $empdob = $_POST["empdob"];
    $today = date("Y-m-d");
    $minAge = date("Y-m-d", strtotime("-18 years"));

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $empdob)) {
        echo "<span style='color:red'> Invalid Date format. Use YYYY-MM-DD.</span>";
    } elseif ($empdob > $today) {
        echo "<span style='color:red'> Date of Birth cannot be in the future.</span>";
    } elseif ($empdob > $minAge) {
        echo "<span style='color:red'> Employee must be at least 18 years old.</span>";
    } else {
        echo "<span style='color:green'> Date of Birth is valid.</span>";
    }
}

if (!empty($_POST["empjoiningdate"]) && !empty($_POST["empdob"])) {
    $empdob = $_POST["empdob"];
    $empjoiningdate = $_POST["empjoiningdate"];
    $today = date("Y-m-d");

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $empjoiningdate)) {
        echo "<span style='color:red'> Invalid Date format. Use YYYY-MM-DD.</span>";
    } elseif ($empjoiningdate > $today) {
        echo "<span style='color:red'> Joining Date cannot be in the future.</span>";
    } elseif ($empjoiningdate <= $empdob) {
        echo "<span style='color:red'> Joining Date must be after Date of Birth.</span>";
    } else {
        echo "<span style='color:green'> Joining Date is valid.</span>";
    }

}
// Password Validation
if (!empty($_POST["password"])) {
    $password = trim($_POST["password"]); // Trim whitespace

    // Check password strength
    if (strlen($password) < 8) {
        echo "<span style='color:red'> Password must be at least 8 characters long.</span>";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        echo "<span style='color:red'> Password must include at least one uppercase letter.</span>";
    } elseif (!preg_match("/[a-z]/", $password)) {
        echo "<span style='color:red'> Password must include at least one lowercase letter.</span>";
    } elseif (!preg_match("/[0-9]/", $password)) {
        echo "<span style='color:red'> Password must include at least one number.</span>";
    } elseif (!preg_match("/[\W]/", $password)) { // \W matches any non-word character
        echo "<span style='color:red'> Password must include at least one special character (e.g., @, #, $, etc.).</span>";
    } else {
        echo "<span style='color:green'> Password is strong.</span>";
    }
}

