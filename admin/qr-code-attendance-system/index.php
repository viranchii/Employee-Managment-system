<?php
session_start();
include('../includes/dbconnection.php');



  ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      
      <title>Employee Task Management System || Manage Employee</title>
   
      <link rel="stylesheet" href="../css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="../style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="../css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="../css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="../css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="../css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="../css/custom.css" />
      <!-- calendar file css -->
      <link rel="stylesheet" href="../js/semantic.min.css" />
      <!-- fancy box js -->
      <link rel="stylesheet" href="../css/jquery.fancybox.css" />
      
      
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

    * {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898;
        background-blend-mode: multiply,multiply;
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .main {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 91.5vh;
    }

    .attendance-container {
        height: 90%;
        width: 90%;
        border-radius: 20px;
        padding: 40px;
        background-color: rgba(255, 255, 255, 0.8);
    }

    .attendance-container > div {
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        border-radius: 10px;
        padding: 30px;
    }

    .attendance-container > div:last-child {
        width: 64%;
        margin-left: auto;
    }
</style>

   </head>
   <body class="inner_page tables_page">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
          <?php include_once('../includes/sidebar.php');?>
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
              <?php include_once('../includes/header.php');?>
               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Manage Employee</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row">
                     
                      
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <!-- <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Search Employee</h2>
                                 </div>
                              </div> -->
                              
                            
  <!---->

  
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-4" href="#">QR Code Attendance System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./masterlist.php">List of Students</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-3">
                    <a class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main">
        
        <div class="attendance-container row">
            <div class="qr-container col-4">
                <div class="scanner-con">
                    <h5 class="text-center">Scan you QR Code here for your attedance</h5>
                    <video id="interactive" class="viewport" width="100%">
                </div>

                <div class="qr-detected-container" style="display: none;">
                    <form action="./endpoint/add-attendance.php" method="POST">
                        <h4 class="text-center">Student QR Detected!</h4>
                        <input type="hidden" id="detected-qr-code" name="qr_code">
                        <button type="submit" class="btn btn-dark form-control">Submit Attendance</button>
                    </form>
                </div>
            </div>

            <div class="attendance-list">
                <h4>List of Present Students</h4>
                <div class="table-container table-responsive">
                    <table class="table text-center table-sm" id="attendanceTable">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Course & Section</th>
                            <th scope="col">Time In</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 

                            $stmt = $dbh->prepare("SELECT * FROM tbl_attendance LEFT JOIN tbl_student ON tbl_student.tbl_student_id = tbl_attendance.tbl_student_id");
                                $stmt->execute();
                
                                $result = $stmt->fetchAll();
                
                                foreach ($result as $row) {
                                    $attendanceID = $row["tbl_attendance_id"];
                                    $studentName = $row["student_name"];
                                    $studentCourse = $row["course_section"];
                                    $timeIn = $row["time_in"];
                                ?>

                                <tr>
                                    <th scope="row"><?= $attendanceID ?></th>
                                    <td><?= $studentName ?></td>
                                    <td><?= $studentCourse ?></td>
                                    <td><?= $timeIn ?></td>
                                    <td>
                                        <div class="action-button">
                                            <button class="btn btn-danger delete-button" onclick="deleteAttendance(<?= $attendanceID ?>)">X</button>
                                        </div>
                                    </td>
                                </tr>

                           
                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>

    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- instascan Js -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>

        
        let scanner;

        function startScanner() {
            scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

            scanner.addListener('scan', function (content) {
                $("#detected-qr-code").val(content);
                console.log(content);
                scanner.stop();
                document.querySelector(".qr-detected-container").style.display = '';
                document.querySelector(".scanner-con").style.display = 'none';
            });

            Instascan.Camera.getCameras()
                .then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                        alert('No cameras found.');
                    }
                })
                .catch(function (err) {
                    console.error('Camera access error:', err);
                    alert('Camera access error: ' + err);
                });
        }

        document.addEventListener('DOMContentLoaded', startScanner);

        function deleteAttendance(id) {
            if (confirm("Do you want to remove this attendance?")) {
                window.location = "./endpoint/delete-attendance.php?attendance=" + id;
            }
        }
    </script>

    <!---->

                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- footer -->
                 <?php include_once('../includes/footer.php');?>
               </div>
               <!-- end dashboard inner -->
            </div>
         </div>
         <!-- model popup -->
       
      </div>
      <!-- jQuery -->
      <script src="../js/jquery.min.js"></script>
      <script src="../js/popper.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="../js/animate.js"></script>
      <!-- select country -->
      <script src="../js/bootstrap-select.js"></script>
      <!-- owl carousel -->
      <script src="../js/owl.carousel.js"></script> 
      <!-- chart js -->
      <script src="../js/Chart.min.js"></script>
      <script src="../js/Chart.bundle.min.js"></script>
      <script src="../js/utils.js"></script>
      <script src="../js/analyser.js"></script>
      <!-- nice scrollbar -->
      <script src="../js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- fancy box js -->
      <script src="../js/jquery-3.3.1.min.js"></script>
      <script src="../js/jquery.fancybox.min.js"></script>
      <!-- custom js -->
      <script src="../js/custom.js"></script>
      <!-- calendar file css -->    
      <script src="../js/semantic.min.js"></script>
   </body>
</html><?php } ?>