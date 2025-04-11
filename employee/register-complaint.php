<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/dbconnection.php');

// Session check
if (!isset($_SESSION['empid']) || strlen($_SESSION['empid']) == 0) {
    header('location:logout.php');
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['submit'])) {
        $uid = $_SESSION['empid'];
        $category = $_POST['category'];
        $issuetype = $_POST['issuetype'];
        $complaintype = $_POST['complaintype'];
        $state = $_POST['state'];
        $noc = $_POST['noc'];
        $complaintdetials = $_POST['complaindetails'];

        $compfile = $_FILES["compfile"]["name"];
        $compfilenew = null;

        if (!empty($compfile)) {
            // Get extension and validate
            $extension = strtolower(pathinfo($compfile, PATHINFO_EXTENSION));
            $allowed_extensions = array("jpg", "jpeg", "png", "gif", "pdf", "doc", "docx");

            if (!in_array($extension, $allowed_extensions)) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Format!',
                            text: 'Only jpg, jpeg, png, gif, pdf, doc, and docx formats are allowed.',
                        });
                    });
                </script>";
                exit();
            } else {
                // Rename file
                $compfilenew = md5($compfile . time()) . '.' . $extension;

                // Move uploaded file
                move_uploaded_file($_FILES["compfile"]["tmp_name"], "complaintdocs/" . $compfilenew);
            }
        }

        // Insert complaint with bound parameters
        $stmt = $dbh->prepare("INSERT INTO tblcomplaints(employeeId, department, issuetype, complaintType, state, noc, complaintDetails, complaintFile) 
            VALUES (:uid, :category, :issuetype, :complaintype, :state, :noc, :complaintdetials, :compfilenew)");

        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':issuetype', $issuetype);
        $stmt->bindParam(':complaintype', $complaintype);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':noc', $noc);
        $stmt->bindParam(':complaintdetials', $complaintdetials);
        $stmt->bindParam(':compfilenew', $compfilenew);

        $stmt->execute();

        // Get last complaint number
        $sql = "SELECT complaintNumber FROM tblcomplaints ORDER BY complaintNumber DESC LIMIT 1";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        $complainno = $result->complaintNumber;

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Complaint Submitted!',
                    text: 'Your complaint has been successfully registered. Your complaint number is $complainno',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'complaint-history.php';
                    }
                });
            });
        </script>";
    }
}
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Employee Management System || Register Complaint</title>

        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <!-- site css -->
        <link rel="stylesheet" href="style.css" />
        <!-- responsive css -->
        <link rel="stylesheet" href="css/responsive.css" />
        <!-- color css -->
        <link rel="stylesheet" href="css/colors.css" />
        <!-- select bootstrap -->
        <link rel="stylesheet" href="css/bootstrap-select.css" />
        <!-- scrollbar css -->
        <link rel="stylesheet" href="css/perfect-scrollbar.css" />
        <!-- custom css -->
        <link rel="stylesheet" href="css/custom.css" />
        <!-- calendar file css -->
        <link rel="stylesheet" href="js/semantic.min.css" />
        <!-- fancy box js -->
        <link rel="stylesheet" href="css/jquery.fancybox.css" />

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body class="inner_page tables_page">
        <div class="full_container">
            <div class="inner_container">
                <!-- Sidebar  -->
                <?php include_once('includes/sidebar.php'); ?>
                <!-- right content -->
                <div id="content">
                    <!-- topbar -->
                    <?php include_once('includes/header.php'); ?>
                    <!-- end topbar -->
                    <!-- dashboard inner -->
                    <div class="midde_cont">
                        <div class="container-fluid">
                            <div class="row column_title">
                                <div class="col-md-12">
                                    <div class="page_title">
                                        <h2>Register Complaint</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h5>Register Complaints</h5>
                                        </div>
                                    </div>
                                    <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <div class="alert alert-primary" role="alert">
                                                    <form method="post" name="complaint" enctype="multipart/form-data">


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Department</label>
                                                            <select name="category" id="category" class="form-control"
                                                                onChange="getCat(this.value);" required="">
                                                                <option value="">Select Department</option>
                                                                <?php $sql = "select ID,DepartmentName from tbldepartment";
                                                                $query = $dbh->prepare($sql);

                                                                $query->execute();
                                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                foreach ($results as $row) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo htmlentities( $row->ID); ?>">
                                                                        <?php echo htmlentities( $row->DepartmentName); ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
            
                                                        <!-- Complaint Type -->
<div class="form-group">
    <label for="complaintype">Complaint Type</label>
    <select name="complaintype" id="complaintype" class="form-control" required>
        <option value="">Select Complaint Type</option>
        <option value="Technical Issues">Technical Issues</option>
        <option value="HR Related">HR Related</option>
        <option value="Payroll & Salary">Payroll & Salary</option>
        <option value="Workplace Concerns">Workplace Concerns</option>
        <option value="Facility Management">Facility Management</option>
        <option value="Security Issues">Security Issues</option>
    </select>
</div>

<div class="form-group">
    <label for="issuetype">Issue Type</label>
    <select name="issuetype" id="issuetype" class="form-control">
        <option value="">Select Issue type</option>
    </select>
</div>

<!-- JavaScript to Update Subcategories Dynamically -->
<script>
  document.getElementById("complaintype").addEventListener("change", function () {
    var complaintType = this.value;
    var issueTypeDropdown = document.getElementById("issuetype");

    // Clear existing options
    issueTypeDropdown.innerHTML = '<option value="">Select Issue Type</option>';

    // Define issue types based on Complaint Type
    var issueTypes = {
        "Technical Issues": ["Hardware Issues", "Software Issues", "Network Problems", "Email Access Issues"],
        "HR Related": ["Employee Misconduct", "Policy Violation", "Leave Approval Delay"],
        "Payroll & Salary": ["Salary Discrepancy", "Payroll Processing Issue", "Tax Deduction Issue"],
        "Workplace Concerns": ["Workplace Harassment", "Discrimination", "Unfair Treatment"],
        "Facility Management": ["Office Maintenance Issue", "Equipment Malfunction", "Air Conditioning Issue"],
        "Security Issues": ["Unauthorized Access", "Security Concern", "Data Breach"]
    };

    // Add new options based on selected complaint type
    if (issueTypes[complaintType]) {
        issueTypes[complaintType].forEach(function (item) {
            var option = document.createElement("option");
            option.value = item;
            option.textContent = item;
            issueTypeDropdown.appendChild(option);
        });
    }
});

</script>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">State</label>
                                                            <select name="state" required="required" class="form-control">
                                                                <option value="">Select State</option>
                                                                <?php $sql = "select stateName from state ";
                                                                $query = $dbh->prepare($sql);

                                                                $query->execute();
                                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                foreach ($results as $row) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo htmlentities($row->stateName); ?>">
                                                                        <?php echo htmlentities($row->stateName); ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </select>

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Nature of Complaint</label>
                                                            <input type="text" name="noc" required="required" value=""
                                                                required="" class="form-control">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Complaint Details (max 2000
                                                                words)</label>
                                                            <textarea name="complaindetails" required="required" cols="10"
                                                                rows="10" class="form-control" maxlength="2000"></textarea>

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Complaint Related Doc(optional)</label>
                                                            <input type="file" name="compfile" class="form-control"
                                                                value="">

                                                        </div>
                                                        <button type="submit" class="btn  btn-primary"
                                                            name="submit">Submit</button>
                                                    </form>
                                                    </div> <!-- alert alert-primary -->
                                                    </div> <!-- padding_infor_info -->
                                                </div> <!-- full -->
                                            </div> <!-- col-md-12 -->
                                        </div> <!-- row -->
                                    </div> <!-- full progress_bar_inner -->
                                </div> <!-- white_shd full margin_bottom_30 -->
                            </div> <!-- col-md-12 -->
                        </div> <!-- row -->
                    </div> <!-- container-fluid -->
                        <!-- footer -->
                        <!-- footer -->
                        <?php include_once('includes/footer.php'); ?>
                    </div>
                    <!-- end dashboard inner -->
                </div>
            </div>
            <!-- model popup -->

        </div>
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- wow animation -->
        <script src="js/animate.js"></script>
        <!-- select country -->
        <script src="js/bootstrap-select.js"></script>
        <!-- owl carousel -->
        <script src="js/owl.carousel.js"></script>
        <!-- chart js -->
        <script src="js/Chart.min.js"></script>
        <script src="js/Chart.bundle.min.js"></script>
        <script src="js/utils.js"></script>
        <script src="js/analyser.js"></script>
        <!-- nice scrollbar -->
        <script src="js/perfect-scrollbar.min.js"></script>
        <script>
            var ps = new PerfectScrollbar('#sidebar');
        </script>
        <!-- fancy box js -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/jquery.fancybox.min.js"></script>
        <!-- custom js -->
        <script src="js/custom.js"></script>
        <!-- calendar file css -->
        <script src="js/semantic.min.js"></script>
    </body>

    </html>