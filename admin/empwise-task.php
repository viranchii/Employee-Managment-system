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
      
      <title>Employee Management System||Dashboard</title>
      
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
        <!--sweetalert-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   </head>
   <body class="dashboard dashboard_1">
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
                              <h2>Employee Wise Taks</h2>
                           </div>
                        </div>
                     </div>
                    
                   
                   
                  <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                  
                                       <div class="full">
                                   
                                          <div class="padding_infor_info">
                                          <h4>Employees Task Report</h4>
                                           <table class="table table-bordered">
                                              <thead>
                                                <tr>
                                             <th>#</th>
                                             <th>Emp. Name</th>
                                             <th>Assigned Tasks</th>
                                              <th>Completed Tasks </th>
                                             <th>In Process Tasks</th>
                                            <th>Not Proocessed Yet</th>
                                                </tr>
                                              </thead>
                                               <?php
                                              $adminid=$_SESSION['etmsaid'];

                                 if($adminid=='2' || $adminid=='3'):?>
                                 <?php
                                 $sql="SELECT tblemployee.EmpName as empname,AssignTaskto,tbltask.Status,
                                 count(tbltask.ID) as totalwisee,
                                 count(if((tbltask.Status='Inprogress'),0,null)) as totalprogress,
                                 count(if((tbltask.Status='Completed'),0,null)) as totalCompleted,
                                 count(if((tbltask.Status IS NULL),0,null)) as totalpending
                                 from tbltask
                                 join tblemployee on tblemployee.ID=tbltask.AssignTaskto
                                 where  TaskAssignBy=:adminid
                                 group by empname" ;
                                 $query= $dbh->prepare($sql);
                                 //$query->bindParam(':fdate',$fdate, PDO::PARAM_STR);
                                 //$query->bindParam(':tdate',$tdate, PDO::PARAM_STR);
                                 $query->bindParam(':adminid',$adminid, PDO::PARAM_STR);

                                 ?>
                                 <?php else: ?>
                                 <?php
                                 $sql="SELECT tblemployee.EmpName as empname,AssignTaskto,tbltask.Status,
                                 count(tbltask.ID) as totalwisee,
                                 count(if((tbltask.Status='Inprogress'),0,null)) as totalprogress,
                                 count(if((tbltask.Status='Completed'),0,null)) as totalCompleted,
                                 count(if((tbltask.Status IS NULL),0,null)) as totalpending
                                 from tbltask
                                 join tblemployee on tblemployee.ID=tbltask.AssignTaskto
                                 where date(tbltask.TaskAssigndate) 
                                 group by empname ";

                                 $query= $dbh->prepare($sql);
                                
                            
                                 ?>
                                 <?php endif; ?>
                                 <?php


                                 
                                 $query-> execute();
                                 $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                 $cnt=1;
                                 if($query -> rowCount() > 0)
                                 {
                                 foreach($results as $result)
                                 {
                                 ?>
                                              <tbody>
                                                <?php 
                                                $statusCompleted='Completed';
                                                $statusInprogress='Inprogress';
                                                $taskstatus='';
                                                ?>
            <tr>
            <td><?php echo($cnt);?></td>
            <td><strong><?php echo htmlentities($result->empname);?></strong></td>
           <td><strong><?php echo htmlentities($towisee=$result->totalwisee);?></strong></td>
           <td><strong><a href="emp-tasks.php?id=<?php echo htmlentities($result->AssignTaskto);?>&&status=<?php echo $statusCompleted;?>&&name=<?php echo htmlentities($result->empname);?>" target="_blank" style="color:blue;"><?php echo htmlentities($toCompleted=$result->totalCompleted);?></strong></td>
            <td><strong><a href="emp-tasks.php?id=<?php echo htmlentities($result->AssignTaskto);?>&&status=<?php echo $statusInprogress;?>&&name=<?php echo htmlentities($result->empname);?>" target="_blank" style="color:blue;"><?php echo htmlentities($toprogress=$result->totalprogress);?></a></strong></td>
            <td><strong><a href="emp-tasks.php?id=<?php echo htmlentities ($result->AssignTaskto);?>&&status=<?php echo $result->taskstatus;?>&&name=<?php echo htmlentities($result->empname);?>" target="_blank" style="color:blue;"><?php echo htmlentities($topending=$result->totalpending);?></a></strong></td>

            </tr>
              <?php  $cnt=$cnt+1;
               $towiseea+=$towisee; 
               $toCompleteda+=$toCompleted; 
               $toprogressa+=$toprogress; 
               $topendinga+=$topending;
           } } ?>
                               </tbody>
            <tr style="background-color: #000;color: #fff;">
            <td colspan="2">Total</td>
            <td><?php echo $towiseea; ?></td>
            <td><?php echo $toCompleteda; ?></td>
            <td><?php echo $toprogressa; ?></td>
            <td><?php echo $topendinga; ?></td>
            </tr>
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
      <script src="js/chart_custom_style1.js"></script>
   </body>
</html><?php } ?>