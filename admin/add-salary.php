<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $emp_id = filter_input(INPUT_POST, 'emp_id', FILTER_SANITIZE_NUMBER_INT);
        $basic_salary = filter_input(INPUT_POST, 'basic_salary', FILTER_VALIDATE_FLOAT);
        $overtime_hours = filter_input(INPUT_POST, 'overtime_hours', FILTER_VALIDATE_INT);
        $overtime_pay = filter_input(INPUT_POST, 'overtime_pay', FILTER_VALIDATE_FLOAT);
        $bonus = filter_input(INPUT_POST, 'bonus', FILTER_VALIDATE_FLOAT);
        $deductions = filter_input(INPUT_POST, 'deductions', FILTER_VALIDATE_FLOAT);
        $payment_status = 'Pending'; 
        $payment_date = "Not Paid Yet"; // Default for pending status
        
        if ($payment_status === 'Paid') {
            $payment_date = date('Y-m-d'); // Set the current date if paid
        }
    

        // Insert salary details into tblsalary
        if ($basic_salary === false || $overtime_pay === false || $bonus === false || $deductions === false) {
            $_SESSION['message'] = 'Invalid salary input! Please enter valid numbers.';
         } else {
            $sql = "INSERT INTO tblsalary (EmpID, BasicSalary, OvertimeHours, OvertimePay, Bonus, Deductions, PaymentStatus, PaymentDate) 
                    VALUES (:emp_id, :basic_salary, :overtime_hours, :overtime_pay, :bonus, :deductions, :payment_status, :payment_date)";
            
            $query = $dbh->prepare($sql);
            $query->bindParam(':emp_id', $emp_id, PDO::PARAM_INT);
            $query->bindParam(':basic_salary', $basic_salary, PDO::PARAM_STR);
            $query->bindParam(':overtime_hours', $overtime_hours, PDO::PARAM_INT);
            $query->bindParam(':overtime_pay', $overtime_pay, PDO::PARAM_STR);
            $query->bindParam(':bonus', $bonus, PDO::PARAM_STR);
            $query->bindParam(':deductions', $deductions, PDO::PARAM_STR);
            $query->bindParam(':payment_status', $payment_status, PDO::PARAM_STR);
            $query->bindValue(':payment_date', $payment_date, PDO::PARAM_NULL);
    
            if ($query->execute()) {
                $_SESSION['message'] = 'Salary details added successfully!';
            } else {
                $_SESSION['message'] = 'Error occurred while adding salary details!';
            }
            header('location: add-salary.php');
            exit();
        }
       
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Management System || Salary</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="js/semantic.min.css" />
    <link rel="stylesheet" href="css/jquery.fancybox.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialPreloader.min.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
      <!--sweetalert-->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>

<body class="inner_page tables_page">
<?php if (isset($_SESSION['message'])): ?>
    <script>
        Swal.fire({
            title: "<?php echo $_SESSION['message']; ?>",
            icon: 'success',
            showConfirmButton: true,
            timer: 2000
        }).then((result) => {
                window.location.href = "managesalary.php";
            
        });
    </script>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
    <div class="full_container">
        <div class="inner_container">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="content">
                <?php include_once('includes/header.php'); ?>
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Salary</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Salary</h2>
                                        </div>
                                    </div>

                                    <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <div class="alert alert-primary" role="alert">
                                                            <form method="post">
                                                            <input type="hidden" id="msg" value="<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>">

                                                                <fieldset>

                                                                    <!-- Employee Dropdown -->
                                                                    <div class="field">
                                                                        <label class="label_field">Select Employee</label>
                                                                        <select name="emp_id" class="form-control" required>
                                                                            <option value="">-- Select Employee --</option>
                                                                            <?php
                                                                            $sql = "SELECT EmpId, EmpName FROM tblemployee";
                                                                            $query = $dbh->prepare($sql);
                                                                            $query->execute();
                                                                            $employees = $query->fetchAll(PDO::FETCH_ASSOC);
                                                                            foreach ($employees as $row) {
                                                                                echo "<option value='" . $row['EmpId'] . "'>" . $row['EmpName'] . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <br>

                                                                    <div class="field">
                                                                        <label class="label_field">Basic Salary</label>
                                                                        <input type="number" step="0.01" name="basic_salary" class="form-control" required>
                                                                    </div>

                                                                    <br>

                                                                    <div class="field">
                                                                        <label class="label_field">Overtime Hours</label>
                                                                        <input type="number" name="overtime_hours" class="form-control">
                                                                    </div>

                                                                    <br>

                                                                    <div class="field">
                                                                        <label class="label_field">OverTime Pay</label>
                                                                        <input type="number" step="0.01" name="overtime_pay" class="form-control">
                                                                    </div>

                                                                    <br>

                                                                    <div class="field">
                                                                        <label class="label_field">Bonus</label>
                                                                        <input type="number" step="0.01" name="bonus" class="form-control">
                                                                    </div>

                                                                    <br>

                                                                    <div class="field">
                                                                        <label class="label_field">Deductions</label>
                                                                        <input type="number" step="0.01" name="deductions" class="form-control">
                                                                    </div>

                                                                    <div>

                                                                    </div>
                                                                    <br>

                                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php include_once('includes/footer.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/analyser.js"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/semantic.min.js"></script>
</body>

</html>
