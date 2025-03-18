<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $deptname = trim($_POST['deptname']); // Trim to remove unnecessary spaces

        // Check if department already exists
        $sqlCheck = "SELECT COUNT(*) FROM tbldepartment WHERE DepartmentName = :deptname";
        $queryCheck = $dbh->prepare($sqlCheck);
        $queryCheck->bindParam(':deptname', $deptname, PDO::PARAM_STR);
        $queryCheck->execute();
        $count = $queryCheck->fetchColumn();

        if ($count > 0) {
            // Department already exists
            $_SESSION['status'] = "Department already exists!";
            $_SESSION['status_code'] = "warning";
            $_SESSION['redirect'] = "manage-dept.php"; // Store the redirect URL in session
            header("Location: add-dept.php"); // Redirect to add-dept.php to trigger JavaScript
            exit();
        } else {
            // Insert new department
            $sql = "INSERT INTO tbldepartment (DepartmentName) VALUES (:deptname)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':deptname', $deptname, PDO::PARAM_STR);
            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                $_SESSION['status'] = "Department has been added.";
                $_SESSION['status_code'] = "success";
                $_SESSION['redirect'] = "manage-dept.php"; // Store the redirect URL in session
    header("Location: add-dept.php"); // Redirect to add-dept.php to trigger JavaScript
    exit();
            } else {
                $_SESSION['status'] = "Something Went Wrong. Please try again.";
                $_SESSION['status_code'] = "error";
            }
        }

      
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Employee Management System || Add Department</title>
    
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
      

      
     
   </head>
   <body class="inner_page general_elements">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
           <?php include_once('includes/sidebar.php');?>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <?php include_once('includes/header.php');?>
               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Add Department</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row column8 graph">
                      
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Add Department</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="full">
                                          <div class="padding_infor_info">
                                             <div class="alert alert-primary" role="alert">
                                                <form method="post">
                        <fieldset>
                            
                           <div class="field">
                              <label class="label_field">Department Name</label>
                              <input type="text" name="deptname" value="" class="form-control" required='true'>
                           </div>
                          

                           <br>
                           <div class="field margin_0">
                              <label class="label_field hidden">hidden label</label>
                              <button class="main_bt" type="submit" name="submit" id="submit">Add</button>
                           </div>
                        </fieldset>
                     </form></div>
                                            
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- funcation section -->
                     
                     </div>
                  </div>
                  <!-- footer -->
                 <?php include_once('includes/footer.php');?>
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
      <!-- custom js -->
      <script src="js/custom.js"></script>
      <!-- calendar file css -->    
      <script src="js/semantic.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/jquery.min.js"></script>

<script>
$(document).ready(function() {
    <?php if (isset($_SESSION['status'])) { ?>
        Swal.fire({
            icon: "<?php echo $_SESSION['status_code']; ?>",
            title: "<?php echo $_SESSION['status_code'] == 'success' ? 'Success!' : ($_SESSION['status_code'] == 'warning' ? 'Warning!' : 'Error!'); ?>",
            text: "<?php echo $_SESSION['status']; ?>",
            timer: 2000, // Auto-close after 2 seconds
            showConfirmButton: true
        }).then(() => {
            window.location.href = "<?php echo isset($_SESSION['redirect']) ? $_SESSION['redirect'] : 'add-dept.php'; ?>";
        });
    <?php 
        unset($_SESSION['status']); 
        unset($_SESSION['status_code']); 
        unset($_SESSION['redirect']);
    } ?>
});

</script>

     
   </body>
</html>