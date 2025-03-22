<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid']==0)) {
  header('location:logout.php');
  exit();
  }

// Code for deletion
if (isset($_GET['delid'])) {
    $teamId = intval($_GET['delid']);

    try {
        $dbh->beginTransaction();

        // Step 1: Delete team members
        $sqlDeleteMembers = "DELETE FROM tblteammembers WHERE TeamId = :teamId";
        $queryDeleteMembers = $dbh->prepare($sqlDeleteMembers);
        $queryDeleteMembers->bindParam(':teamId', $teamId, PDO::PARAM_INT);
        $queryDeleteMembers->execute();

        // Step 2: Delete the team
        $sqlDeleteTeam = "DELETE FROM tblteam WHERE TeamId = :teamId";
        $queryDeleteTeam = $dbh->prepare($sqlDeleteTeam);
        $queryDeleteTeam->bindParam(':teamId', $teamId, PDO::PARAM_INT);
        $queryDeleteTeam->execute();

        $dbh->commit();

        $_SESSION['success_msg'] = "Team deleted successfully!";
        header("Location: manage-team.php");
        exit();
    } catch (Exception $e) {
        $dbh->rollBack();
        $_SESSION['error_msg'] = "Error deleting team: " . $e->getMessage();
        header("Location: manage-team.php");
        exit();
    }
}

  ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      
      <title>Employee Management System || Manage Task</title>
   
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
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="css\materialPreloader.min.css" rel="stylesheet">
        <link href="css/jquery.dataTables.min.css" rel="stylesheet">
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
                              <h2>Manage Team</h2>
                              <?php
        // Show success or error messages
        if (isset($_SESSION['success_msg'])) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{$_SESSION['success_msg']}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then(() => { window.location.href = 'manage-team.php'; });
            </script>";
            unset($_SESSION['success_msg']);
        }

        if (isset($_SESSION['error_msg'])) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{$_SESSION['error_msg']}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then(() => { window.location.href = 'manage-team.php'; });
            </script>";
            unset($_SESSION['error_msg']);
        }
        ?>

                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row">
                     
                      
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Manage team</h2>
                                 </div>
                              </div>
                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                            <th>#</th>
                                             <th>Task Title</th>
                                             <th>Start Date</th>
                                             <th>End Date</th>
                                             <th>Leader Name</th>
                                             <th>Members</th>
                                           
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
$sql = "SELECT 
t.TeamId, 
tk.TaskTitle, 
t.StartDate, 
t.EndDate, 
e_leader.EmpName AS LeaderName, 
GROUP_CONCAT(CONCAT(e_member.EmpName, ' (', e_member.Designation, ')') SEPARATOR '<br>') AS Members 
FROM tblteam t
JOIN tbltask tk ON t.TaskId = tk.ID
JOIN tblemployee e_leader ON t.LeaderId = e_leader.EmpId
LEFT JOIN tblteammembers tm ON t.TeamId = tm.TeamId
LEFT JOIN tblemployee e_member ON tm.MemberId = e_member.EmpId
GROUP BY t.TeamId, tk.TaskTitle, t.StartDate, t.EndDate, e_leader.EmpName";


$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?> 
                                          <tr>
                                              
                                          <td><?php echo htmlentities($cnt); ?></td>
        <td><?php echo htmlentities($row->TaskTitle); ?></td>
        <td><?php echo htmlentities($row->StartDate); ?></td>
        <td><?php echo htmlentities($row->EndDate); ?></td>
        <td><?php echo htmlentities($row->LeaderName); ?></td>
        <td><?php echo $row->Members ? htmlspecialchars_decode($row->Members) : 'No Members'; ?></td>

                                             <td>   <a href="edit-team.php?editid=<?php echo htmlentities($row->TeamId); ?>"><i
                                             class="material-icons green_color">mode_edit</i></a>
                                             <!--a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row->tid; ?>);"><i class="material-icons red_color">delete_forever</i></a-->
                                             <a href="javascript:void(0);" onclick="confirmDelete(<?php echo htmlentities($row->TeamId); ?>)"><i class="material-icons red_color">delete_forever</i></a>

                                          </tr><?php $cnt=$cnt+1;}} ?>
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
      <script>
        function confirmDelete(teamId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action will permanently delete the team!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "manage-team.php?delid=" + teamId;
                }
            });
        }
    </script>
   </body>
</html>