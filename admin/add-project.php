<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
   header('location:logout.php');
} else {
   if (isset($_POST['submit'])) {
      $project_title = trim($_POST['project_title']);
      $description = trim($_POST['description']);
      $client_name = trim($_POST['client_name']);
      $return_date = $_POST['return_date'];
      $status = $_POST['status'];

      // Check if project already exists
      $sqlCheck = "SELECT COUNT(*) FROM tblproject WHERE project_title = :project_title";
      $queryCheck = $dbh->prepare($sqlCheck);
      $queryCheck->bindParam(':project_title', $project_title, PDO::PARAM_STR);
      $queryCheck->execute();
      $count = $queryCheck->fetchColumn();

      if ($count > 0) {
         $_SESSION['status'] = "Project already exists!";
         $_SESSION['status_code'] = "warning";
         $_SESSION['redirect'] = "manage-project.php";
         header("Location: add-project.php");
         exit();
      } else {
         // Insert new project
         $sql = "INSERT INTO tblproject (project_title, description, client_name, return_date, status) VALUES (:project_title, :description, :client_name, :return_date, :status)";
         $query = $dbh->prepare($sql);
         $query->bindParam(':project_title', $project_title, PDO::PARAM_STR);
         $query->bindParam(':description', $description, PDO::PARAM_STR);
         $query->bindParam(':client_name', $client_name, PDO::PARAM_STR);
         $query->bindParam(':return_date', $return_date, PDO::PARAM_STR);
         $query->bindParam(':status', $status, PDO::PARAM_STR);
         $query->execute();

         $LastInsertId = $dbh->lastInsertId();
         if ($LastInsertId > 0) {
            $_SESSION['status'] = "Project has been added.";
            $_SESSION['status_code'] = "success";
            $_SESSION['redirect'] = "manage-project.php";
            header("Location: add-project.php");
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
         <?php include_once('includes/sidebar.php'); ?>
         <!-- end sidebar -->
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
                           <h2>Add Project</h2>
                        </div>
                     </div>
                  </div>
                  <!-- row -->
                  <div class="row column8 graph">

                     <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                           <div class="full graph_head">
                              <div class="heading1 margin_0">
                                 <h2>Add Project</h2>
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
                                                      <label class="label_field">Project Title</label>
                                                      <input type="text" name="project_title" value="" class="form-control" required='true'>
                                                   </div>
                                                   <br>
                                                   <div class="field">
                                                      <label class="label_field">Project Description</label>
                                                      <input type="text" name="description" value="" class="form-control" required='true'>
                                                   </div>
                                                   <br>
                                                   <div class="field">
                                                      <label class="label_field">Client Name</label>
                                                      <input type="text" name="client_name" value="" class="form-control" required='true'>
                                                   </div>
                                                   <br>
                                                   <div class="field">
                                                      <label class="label_field">Return Date</label>
                                                      <input type="date" name="return_date" value="" class="form-control" required='true'>
                                                   </div>
                                                   <br>
                                                  
                                                  
                                                   <div class="field">
                                                   <label class="label_field">Status</label>
                                                      <select name="status" class="form-control" required>
                                                         <option value="">Select status</option>
                                                         <option value="Running">Running</option>
                                                         <option value="Upcoming">Upcoming</option>
                                                         <option value="Complete">Complete</option>
                                                      </select>
                                                   </div>
                                                   <br>


                                                   <div class="field margin_0">
                                                      <label class="label_field hidden">hidden label</label>
                                                      <button class="main_bt" type="submit" name="submit" id="submit">Add</button>
                                                   </div>
                                                </fieldset>
                                             </form>
                                          </div>

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