<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid'] == 0)) {
   header('location:picut.php');
} else {

   function generateRandomCode($length = 10)
   {
      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
      $randomString = '';

      for ($i = 0; $i < $length; $i++) {
         $randomIndex = rand(0, strlen($characters) - 1);
         $randomString .= $characters[$randomIndex];
      }

      return $randomString;
   }


   if (isset($_POST['submit'])) {

      $etmsaid = $_SESSION['etmsaid'];
      $deptname = $_POST['deptname'];
      $empid = $_POST['empid'];
      $empname = $_POST['empname'];
      $empemail = $_POST['empemail'];
      $gender = $_POST['gender'];
      $empcontno = $_POST['empcontno'];
      $designation = $_POST['designation'];
      $empdob = $_POST['empdob'];
      $empadd = $_POST['empadd'];
      $empdoj = $_POST['empdoj'];
      $desc = $_POST['desc'];
      $password = md5($_POST['password']);
      $pic = $_FILES["pic"]["name"];
      $extension = substr($pic, strlen($pic) - 4, strlen($pic));
      $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

 




      $sql = "SELECT ID FROM tblemployee WHERE EmpId=:empid || EmpContactNumber=:empcontno || EmpEmail=:empemail";
      $query = $dbh->prepare($sql);
      $query->bindParam(':empid', $empid, PDO::PARAM_STR);
      $query->bindParam(':empemail', $empemail, PDO::PARAM_STR);
      $query->bindParam(':empcontno', $empcontno, PDO::PARAM_STR);
      $query->execute();
      $results = $query->fetchAll(PDO::FETCH_OBJ);
      if ($query->rowCount() > 0) {
         $_SESSION['alert'] = "exists";
 
      } else {

         if (!in_array($extension, $allowed_extensions)) {
            $_SESSION['alert'] = "invalid_image";
          } else {

            $pic = ($pic);
            move_uploaded_file($_FILES["pic"]["tmp_name"], "images/" . $pic);

            $qrcode = generateRandomCode(10);

            $sql = "INSERT INTO tblemployee (DepartmentID, EmpId, EmpName, EmpEmail,Gender, EmpContactNumber, Designation, EmpDateofbirth, EmpAddress, EmpDateofjoining, Description, Password, ProfilePic, qrcode) VALUES (:deptname, :empid, :empname, :empemail,:gender, :empcontno, :designation, :empdob, :empadd, :empdoj, :desc, :password, :pic, :qrcode)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':deptname', $deptname, PDO::PARAM_STR);
            $query->bindParam(':empid', $empid, PDO::PARAM_STR);
            $query->bindParam(':empname', $empname, PDO::PARAM_STR);
            $query->bindParam(':empemail', $empemail, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
            $query->bindParam(':empcontno', $empcontno, PDO::PARAM_STR);
            $query->bindParam(':designation', $designation, PDO::PARAM_STR);
            $query->bindParam(':empdob', $empdob, PDO::PARAM_STR);
            $query->bindParam(':empadd', $empadd, PDO::PARAM_STR);
            $query->bindParam(':empdoj', $empdoj, PDO::PARAM_STR);
            $query->bindParam(':desc', $desc, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':pic', $pic, PDO::PARAM_STR);
            $query->bindParam(':qrcode', $qrcode, PDO::PARAM_STR);

            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
               $_SESSION['alert'] = "success";
            } else {
               $_SESSION['alert'] = "error";

            }


         }
         header("Location: add-employee.php");
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
      <script type="text/javascript">
         function checkempidAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
               url: "check_availability.php",
               data: 'empid=' + $("#empid").val(),
               type: "POST",
               success: function (data) {
                  $("#empid-status").html(data);
                  $("#loaderIcon").hide();
               },
               error: function () { }
            });
         }
         // FOr email
         function checkemailidAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
               url: "check_availability.php",
               data: 'empemail=' + $("#empemail").val(),
               type: "POST",
               success: function (data) {
                  $("#empemail-status").html(data);
                  $("#loaderIcon").hide();
               },
               error: function () { }
            });
         }

         // Function to check Employee Date of Birth (DOB) availability
function checkDOBAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data: 'empdob=' + $("#empdob").val(),
        type: "POST",
        success: function (data) {
            $("#empdob-status").html(data);
            $("#loaderIcon").hide();
        },
        error: function () { }
    });
}

// Function to check Employee Joining Date availability
function checkJoiningDateAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data: {
            'empjoiningdate': $("#empjoiningdate").val(),
            'empdob': $("#empdob").val() // Send DOB as well to validate joining date
        },
        type: "POST",
        success: function (data) {
            $("#empjoiningdate-status").html(data);
            $("#loaderIcon").hide();
        },
        error: function () { }
    });
}


         // For Mobile
         function checkmobileAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
               url: "check_availability.php",
               data: 'empcontno=' + $("#empcontno").val(),
               type: "POST",
               success: function (data) {
                  $("#empcontno-status").html(data);
                  $("#loaderIcon").hide();
               },
               error: function () { }
            });
         }
      </script>
   </head>

   <body class="inner_page general_elements">
   <?php
if (isset($_SESSION['alert'])) {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {";

    if ($_SESSION['alert'] == "success") {
        echo "Swal.fire({
            icon: 'success',
            title: 'Employee Added!',
            text: 'Employee details have been successfully added.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'manage-employee.php';
        });";
    } elseif ($_SESSION['alert'] == "exists") {
        echo "Swal.fire({
            icon: 'error',
            title: 'Duplicate Entry!',
            text: 'Employee ID, Email, or Contact number already exists.',
            confirmButtonText: 'OK'
        });";
    } elseif ($_SESSION['alert'] == "invalid_image") {
        echo "Swal.fire({
            icon: 'error',
            title: 'Invalid Image Format!',
            text: 'Only jpg, jpeg, png, and gif formats are allowed.',
            confirmButtonText: 'OK'
        });";
    } elseif ($_SESSION['alert'] == "error") {
        echo "Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Something went wrong. Please try again.',
            confirmButtonText: 'OK'
        });";
    }

    echo "});
    </script>";

    unset($_SESSION['alert']); // Clear session variable after displaying alert
}
?>
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
                              <h2>Add Employee</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row column8 graph">

                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Add Employee</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="full">
                                          <div class="padding_infor_info">
                                             <div class="alert alert-primary" role="alert">
                                                <form method="post" enctype="multipart/form-data">
                                                   <fieldset>

                                                      <div class="field">
                                                         <label class="label_field">Department Name</label>
                                                         <select type="text" name="deptname" value="" class="form-control"
                                                            required='true'>
                                                            <option value="">Select Department</option>
                                                            <?php

                                                            $sql2 = "SELECT * from   tbldepartment ";
                                                            $query2 = $dbh->prepare($sql2);
                                                            $query2->execute();
                                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                            foreach ($result2 as $row2) {
                                                               ?>

                                                               <option value="<?php echo htmlentities($row2->ID); ?>"><?php echo htmlentities(
                                                                     $row2->DepartmentName
                                                                  ); ?></option>
                                                            <?php } ?>
                                                         </select>
                                                      </div>


                                                      <br>

                                                      <div class="field">
                                                         <label class="label_field">Employee ID</label>
                                                         <input type="text" name="empid" id="empid" value=""
                                                            class="form-control" required='true'
                                                            onBlur="checkempidAvailability()">

                                                      </div>
                                                      <span id="empid-status"></span>

                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Employee Name</label>
                                                         <input type="text" name="empname" value="" class="form-control"
                                                            required='true'>
                                                      </div>


                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Employee Email</label>
                                                         <input type="email" name="empemail" id="empemail" value=""
                                                            class="form-control" required='true'
                                                            onBlur="checkemailidAvailability()">
                                                      </div>
                                                      <span id="empemail-status"></span>

                                                      <br>
                                                      <div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" class="form-control" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select>
</div>
                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Employee Contact Number</label>
                                                         <input type="text" name="empcontno" id="empcontno" value=""
                                                            class="form-control" required='true' maxlength="10"
                                                            pattern="[0-9]+" onBlur="checkmobileAvailability()">
                                                      </div>
                                                      <span id="empcontno-status"></span>
                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Employee Designation</label>
                                                         <input type="text" name="designation" value=""
                                                            class="form-control" required='true'>
                                                      </div>

                                                      <br>
                                                    

                                                      <div class="field">
    <label class="label_field">Date of Birth</label>
    <input type="date" name="empdob" id="empdob" class="form-control" required="true" onBlur="checkDOBAvailability()">
</div>
<span id="empdob-status"></span>


                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Empoyee Address</label>
                                                         <textarea type="text" name="empadd" value="" class="form-control"
                                                            required='true'></textarea>
                                                      </div>


                                                      <br>
                                                      <div class="field">
    <label class="label_field">Joining Date</label>
    <input type="date" name="empdoj" id="empdoj" class="form-control" required="true" onBlur="checkJoiningDateAvailability()">
</div>
<span id="empjoiningdate-status"></span>



                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Description(if any)</label>
                                                         <textarea type="text" name="desc" value=""
                                                            class="form-control"></textarea>
                                                      </div>

                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Password</label>
                                                         <input type="text" name="password" value="" class="form-control"
                                                            required='true'>
                                                      </div>
                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Employee Pic</label>
                                                         <input type="file" name="pic" value="" class="form-control"
                                                            required='true'>
                                                      </div>

                                                      <br>
                                                      <div class="field margin_0">
                                                         <label class="label_field hidden">hidden label</label>
                                                         <button class="main_bt" type="submit" name="submit"
                                                            id="submit">Add</button>
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
         <script src="https://code.jquery.com/jquery-3.1.1.min.js" />
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
   </body>

   </html>
   <?php
}
?>