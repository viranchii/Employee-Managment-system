<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['add'])) {
        $leavetype = trim($_POST['leavetype']);
        $description = trim($_POST['description']);

        // Check if leave type already exists
        $sql = "SELECT COUNT(*) FROM tblleavetype WHERE LeaveType = :leavetype";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
        $query->execute();
        $count = $query->fetchColumn();

        if ($count > 0) {
            $_SESSION['error'] = "Leave type already exists!";
            $_SESSION['old_leavetype'] = $leavetype;
            $_SESSION['old_description'] = $description;
        } else {
            // Insert new leave type
            $sql = "INSERT INTO tblleavetype (LeaveType, Description) VALUES (:leavetype, :description)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->execute();

            if ($dbh->lastInsertId()) {
                $_SESSION['msg'] = "Leave type added successfully";
            } else {
                $_SESSION['error'] = "Something went wrong. Please try again";
            }
        }

        header("Location: addleavetype.php");
        exit();
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Employee Management System || View Not Approved Leaves</title>

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
  <!--sweetalert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>

    </head>

    <body class="inner_page tables_page">
    <?php if (!empty($_SESSION['error'])) { ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $_SESSION['error']; ?>'
        }).then(() => {
            window.location.href = 'addleavetype.php';
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php } elseif (!empty($_SESSION['msg'])) { ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $_SESSION['msg']; ?>'
        }).then(() => {
            window.location.href = 'manageleavetype.php';
        });
    </script>
    <?php unset($_SESSION['msg']); ?>
<?php } ?>


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
                              <h2>Add Leave Type</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row column8 graph">
                      
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Add LeaveType</h2>
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
                           <label for="leavetype">Leave Type</label>
                                                        <input id="leavetype" type="text" class="form-control" name="leavetype"
                                                            required placeholder="Enter leave type" value="<?php echo isset($_SESSION['old_leavetype']) ? htmlspecialchars($_SESSION['old_leavetype']) : ''; ?>">  </div>
                          

                           <br>
                           <div class="field margin_0">
                           <label for="description">Description</label>
                                                        <textarea id="description" name="description"
                                                            class="form-control"
                                                            placeholder="Enter leave description (optional)"
                                                            maxlength="500"><?php echo isset($_SESSION['old_description']) ? htmlspecialchars($_SESSION['old_description']) : ''; ?></textarea></div>
                        
                                                            <br>
             <div class="field margin_0">
                                                         <label class="label_field hidden">hidden label</label>
                                                         <button type="submit" name="add" class="main_bt"
                                                         class="waves-effect waves-light btn indigo m-b-xs">ADD</button>
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
        <!-- fancy box js -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/jquery.fancybox.min.js"></script>
        <!-- custom js -->
        <script src="js/custom.js"></script>
        <!-- calendar file css -->
        <script src="js/semantic.min.js"></script>
    </body>

    

    </html><?php } ?>







  