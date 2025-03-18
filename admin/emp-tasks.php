<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      
      <title>Employee Management System || View Completed Task</title>
   
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
                              <h2>View Emp Task</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row">
                     
                      
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2> <?php echo $_GET['name'];?>'s <?php echo $_GET['status'];?> Task</h2>
                                 </div>
                              </div>
                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th>S.No</th>
                                             <th>Task Title</th>
                                             <th>Department</th>
                                             <th>Assign To</th>
                                             <th>Assign Date</th>
                                             <th>End Date</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>

                                          <?php
                                          $empid=intval($_GET['id']);
                                          $status=$_GET['status'];
  if($status=='Completed'):                                       
$sql="SELECT tbltask.ID as tid,tbltask.TaskTitle,tbltask.Status,tbltask.DeptID,tbltask.AssignTaskto,tbltask.TaskEnddate,tbltask.TaskAssigndate,tbldepartment.DepartmentName,tbldepartment.ID as did,tblemployee.EmpName,tblemployee.EmpId from tbltask join tbldepartment on tbldepartment.ID=tbltask.DeptID join tblemployee on tblemployee.ID=tbltask.AssignTaskto where tbltask.Status='Completed' and tbltask.AssignTaskto='$empid' ";
elseif($status=='Inprogress'):
   $sql="SELECT tbltask.ID as tid,tbltask.TaskTitle,tbltask.Status,tbltask.DeptID,tbltask.AssignTaskto,tbltask.TaskEnddate,tbltask.TaskAssigndate,tbldepartment.DepartmentName,tbldepartment.ID as did,tblemployee.EmpName,tblemployee.EmpId from tbltask join tbldepartment on tbldepartment.ID=tbltask.DeptID join tblemployee on tblemployee.ID=tbltask.AssignTaskto where tbltask.Status='Inprogress' and tbltask.AssignTaskto='$empid' ";
else:

   $sql="SELECT tbltask.ID as tid,tbltask.TaskTitle,tbltask.Status,tbltask.DeptID,tbltask.AssignTaskto,tbltask.TaskEnddate,tbltask.TaskAssigndate,tbldepartment.DepartmentName,tbldepartment.ID as did,tblemployee.EmpName,tblemployee.EmpId from tbltask join tbldepartment on tbldepartment.ID=tbltask.DeptID join tblemployee on tblemployee.ID=tbltask.AssignTaskto where (tbltask.Status='' || tbltask.Status is null) and tbltask.AssignTaskto='$empid' ";
endif;
$query = $dbh -> prepare($sql);

$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?> 
                                                 <tr>
                                              
                                             <td><?php echo htmlentities($cnt);?></td>
                                             <td><?php  echo htmlentities($row->TaskTitle);?></td>
                                             <td><?php  echo htmlentities($row->DepartmentName);?></td>
                                             <td><?php  echo htmlentities($row->EmpName);?>(<?php  echo htmlentities($row->EmpId);?>)</td>
                                             <td><?php  echo htmlentities($row->TaskAssigndate);?></td>
                                             <td><?php  echo htmlentities($row->TaskEnddate);?></td>

                     <td class="font-w600"><?php  $status=$row->Status;
if($row->Status==""):   ?>
<span class="badge bg-danger">Not Updated yet</span>

<?php elseif($row->Status=="Inprogress"): ?>
<span class="badge bg-warning text-dark">In Progress / Process</span>
<?php elseif($row->Status=="Completed"): ?>
<span class="badge bg-success">Completed</span>
<?php endif;?>
</td>
                                             <td><a href="view-task.php?viewid=<?php echo htmlentities ($row->tid);?>" class="btn btn-primary btn-sm">View </a>
                                                </td>
                                          </tr><?php $cnt=$cnt+1;}} else{  ?>
<tr>
   <td colspan="7" style="color:red">No Task Found</td>
</tr>
<?php } ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
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