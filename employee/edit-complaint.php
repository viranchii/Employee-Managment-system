<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['empid']) == 0) {
    header('location:logout.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // Set timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['submit'])) {
        $uid = $_SESSION['empid'];
        $category = $_POST['category'];
        $issuetype = $_POST['issuetype'];
        $complaintype = $_POST['complaintype'];
        $state = $_POST['state'];
        $noc = $_POST['noc'];
        $complaintdetials = $_POST['complaindetails'];
        $complaintNumber = $_POST['complaintNumber']; // Get complaint number for updating

        $compfile = $_FILES["compfile"]["name"];
        $extension = substr($compfile, strlen($compfile) - 4, strlen($compfile));
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif", ".pdf", ".PDF", ".doc", "docx");

        if (!in_array($extension, $allowed_extensions) && !empty($compfile)) {
            echo '<script>
            Swal.fire({
                icon: "error",
                title: "Invalid File Format",
                text: "Only jpg/jpeg/png/gif/pdf/doc/docx allowed",
                confirmButtonColor: "#d33"
            });
        </script>';
     } else {
            if (!empty($compfile)) {
                $compfilenew = md5($compfile) . $extension;
                move_uploaded_file($_FILES["compfile"]["tmp_name"], "complaintdocs/" . $compfilenew);
                $query = "UPDATE tblcomplaints 
                          SET department=:category, 
                              issuetype=:issuetype, 
                              complaintType=:complaintype, 
                              state=:state, 
                              noc=:noc, 
                              complaintDetails=:complaintdetials, 
                              complaintFile=:compfile 
                          WHERE complaintNumber=:complaintNumber";
            } else {
                $query = "UPDATE tblcomplaints 
                          SET department=:category, 
                              issuetype=:issuetype, 
                              complaintType=:complaintype, 
                              state=:state, 
                              noc=:noc, 
                              complaintDetails=:complaintdetials 
                          WHERE complaintNumber=:complaintNumber";
            }

            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':issuetype', $issuetype, PDO::PARAM_STR);
            $stmt->bindParam(':complaintype', $complaintype, PDO::PARAM_STR);
            $stmt->bindParam(':state', $state, PDO::PARAM_STR);
            $stmt->bindParam(':noc', $noc, PDO::PARAM_STR);
            $stmt->bindParam(':complaintdetials', $complaintdetials, PDO::PARAM_STR);
            if (!empty($compfile)) {
                $stmt->bindParam(':compfile', $compfilenew, PDO::PARAM_STR);
            }
            $stmt->bindParam(':complaintNumber', $complaintNumber, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Updated Successfully!',
                    text: 'Your complaint has been successfully updated!',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.location.href='complaint-history.php';
                });
                </script>";
                
            } else {
                echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Update Failed!",
                    text: "Something went wrong. Please try again.",
                    confirmButtonColor: "#d33"
                });
            </script>';
            }
        }
    }

    // Fetch existing complaint details if editing
    if (isset($_GET['id'])) {
        $complaintNumber = $_GET['id'];
        $sql = "SELECT * FROM tblcomplaints WHERE complaintNumber=:complaintNumber";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':complaintNumber', $complaintNumber, PDO::PARAM_INT);
        $stmt->execute();
        $complaint = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Complaint</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert Library -->
</head>


<body class="inner_page tables_page">
<?php
    if (isset($_POST['submit']) && $stmt->execute())  {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Updated Successfully!',
            text: 'Your complaint has been successfully updated!',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            window.location.href='complaint-history.php';
        });
        </script>";
    }
    ?>
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
                                        <h2>Update Complaint</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h5>Update Complaints</h5>
                                        </div>
                                    </div>
                                    <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <div class="alert alert-primary" role="alert">
                                                   
                                                    <form method="post" name="complaint" enctype="multipart/form-data">
    <input type="hidden" name="complaintNumber" value="<?php echo isset($complaint['complaintNumber']) ? $complaint['complaintNumber'] : ''; ?>">

    <div class="form-group">
        <label>Department</label>
        <select name="category" class="form-control" required>
            <option value="">Select Department</option>
            <?php
            $sql = "SELECT ID, DepartmentName FROM tbldepartment";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            foreach ($results as $row) { ?>
                <option value="<?php echo htmlentities($row->ID); ?>" 
                    <?php echo (isset($complaint['department']) && $complaint['department'] == $row->ID) ? 'selected' : ''; ?>>
                    <?php echo htmlentities($row->DepartmentName); ?>
                </option>
            <?php } ?>
        </select>
    </div>


    <div class="form-group">
        <label>Complaint Type</label>
        <select name="complaintype" id="complaintype" class="form-control" required>
    <option value="">Select Complaint Type</option>
    <option value="Technical Issues" <?php if(isset($complaint['complaintType']) && $complaint['complaintType'] == "Technical Issues") echo "selected"; ?>>Technical Issues</option>
    <option value="HR Related" <?php if(isset($complaint['complaintType']) && $complaint['complaintType'] == "HR Related") echo "selected"; ?>>HR Related</option>
    <option value="Payroll & Salary" <?php if(isset($complaint['complaintType']) && $complaint['complaintType'] == "Payroll & Salary") echo "selected"; ?>>Payroll & Salary</option>
    <option value="Workplace Concerns" <?php if(isset($complaint['complaintType']) && $complaint['complaintType'] == "Workplace Concerns") echo "selected"; ?>>Workplace Concerns</option>
    <option value="Facility Management" <?php if(isset($complaint['complaintType']) && $complaint['complaintType'] == "Facility Management") echo "selected"; ?>>Facility Management</option>
    <option value="Security Issues" <?php if(isset($complaint['complaintType']) && $complaint['complaintType'] == "Security Issues") echo "selected"; ?>>Security Issues</option>
</select>

        </div>

    
    <div class="form-group">
        <label>Issue Type</label>
        <select name="issuetype" id="issuetype" class="form-control" required>
    <option value="">Select Issue Type</option>
</select>

    </div>
<!-- JavaScript to Update Subcategories Dynamically -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    var complaintTypeDropdown = document.getElementById("complaintype");
    var issueTypeDropdown = document.getElementById("issuetype");
    var existingIssueType = "<?php echo isset($complaint['issuetype']) ? $complaint['issuetype'] : ''; ?>";

    function populateIssueTypes(complaintType) {
        var issueOptions = {
            "Technical Issues": ["Network Issue", "Software Bug", "Hardware Failure"],
            "HR Related": ["Leave Policy", "Employee Conflict", "Salary Dispute"],
            "Payroll & Salary": ["Delayed Salary", "Wrong Deduction", "Tax Issues"],
            "Workplace Concerns": ["Harassment", "Work Conditions", "Shift Timing"],
            "Facility Management": ["Maintenance Issue", "Housekeeping", "Parking Issue"],
            "Security Issues": ["Data Breach", "Physical Security", "Unauthorized Access"]
        };

        issueTypeDropdown.innerHTML = '<option value="">Select Issue Type</option>';

        if (complaintType in issueOptions) {
            issueOptions[complaintType].forEach(function (issue) {
                var option = document.createElement("option");
                option.value = issue;
                option.textContent = issue;
                if (issue === existingIssueType) {
                    option.selected = true;
                }
                issueTypeDropdown.appendChild(option);
            });
        }
    }

    // Populate issue types when complaint type changes
    complaintTypeDropdown.addEventListener("change", function () {
        populateIssueTypes(this.value);
    });

    // Prepopulate issue types on page load
    if (complaintTypeDropdown.value) {
        populateIssueTypes(complaintTypeDropdown.value);
    }
});



</script>
    <div class="form-group">
        <label>State</label>
        <input type="text" name="state" class="form-control" required 
            value="<?php echo isset($complaint['state']) ? $complaint['state'] : ''; ?>">
    </div>

    <div class="form-group">
        <label>Nature of Complaint</label>
        <input type="text" name="noc" class="form-control" required 
            value="<?php echo isset($complaint['noc']) ? $complaint['noc'] : ''; ?>">
    </div>

    <div class="form-group">
        <label>Complaint Details</label>
        <textarea name="complaindetails" class="form-control" maxlength="2000" required><?php 
            echo isset($complaint['complaintDetails']) ? $complaint['complaintDetails'] : ''; 
        ?></textarea>
    </div>

    <div class="form-group">
        <label>Complaint Related Document (if any)</label>
        <input type="file" name="compfile" class="form-control">
        <?php if (!empty($complaint['complaintFile'])) { ?>
            <p>Existing File: <a href="complaintdocs/<?php echo $complaint['complaintFile']; ?>" target="_blank"><?php echo $complaint['complaintFile']; ?></a></p>
        <?php } ?>
    </div>

    <button type="submit" class="btn btn-primary" name="submit">Update Complaint</button>
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
<?php
}
?>