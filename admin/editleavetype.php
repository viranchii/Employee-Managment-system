<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['update'])) {
        $lid = intval($_GET['lid']);
        $leavetype = $_POST['leavetype'];
        $description = $_POST['description'];

        $sql = "UPDATE tblleavetype SET LeaveType=:leavetype, Description=:description WHERE id=:lid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':lid', $lid, PDO::PARAM_INT);
        $query->execute();

        if ($query->execute()) {
            $_SESSION['msg'] = "Leave Type Updated Successfully";
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
        }
        header("Location: editleavetype.php");
        exit();
    
    }

    $lid = intval($_GET['lid']);
    $sql = "SELECT * FROM tblleavetype WHERE id=:lid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':lid', $lid, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Leave Type</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php if (!empty($_SESSION['msg'])) { ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $_SESSION['msg']; ?>'
        })
        .then((result) => {
            window.location.href = "manageleavetype.php";
        
    });
    </script>
    <?php unset($_SESSION['msg']); ?>
<?php } elseif (!empty($_SESSION['error'])) { ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $_SESSION['error']; ?>'
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php } ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>


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
       
    </head>

    <body class="inner_page tables_page">
   

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
                <input type="text" class="form-control" name="leavetype" id="leavetype" value="<?php echo htmlentities($result->LeaveType); ?>" required>
            
                                                         </div>
                          

                           <br>
                           <div class="field margin_0">
                           <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" maxlength="500"><?php echo htmlentities($result->Description); ?></textarea>
           
                                                            <br>
             <div class="field margin_0">
                                                         <label class="label_field hidden">hidden label</label>
                                                         <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                         <a href="manageleavetype.php" class="btn btn-secondary">Cancel</a>   </div>
                        
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

    

    </html>

    <?php } ?>