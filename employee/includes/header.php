<?php
   error_reporting(0);
   include('includes/dbconnection.php');

   // Check if session is active
   if (!isset($_SESSION['empid'])) {
       header('location:logout.php');
   }

   $eid = $_SESSION['empid'];
   $sql = "SELECT ProfilePic, EmpName, EmpId FROM tblemployee WHERE EmpId = :eid";
   $query = $dbh->prepare($sql);
   $query->bindParam(':eid', $eid, PDO::PARAM_STR);
   $query->execute();
   $results = $query->fetchAll(PDO::FETCH_OBJ);
   if ($query->rowCount() > 0) {
       foreach ($results as $row) {
           $profilePic = $row->ProfilePic;
           $empName = $row->EmpName;
           $empId = $row->EmpId;
       }
   }
?>

<div class="topbar">
   <nav class="navbar navbar-expand-lg navbar-light">
      <div class="full">
         <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
         <div class="logo_section">
            <a href="dashboard.php"><h3 style="color: white;padding-top: 20px;padding-left: 10px;">Employee Management System</h3></a>
         </div>
         <div class="right_topbar">
            <div class="icon_info">
               <ul>
                  <?php 
                   $eid1 = $_SESSION['empid'];
                   $sql2 = "SELECT 
                   e.EmpId As empid,
                   e.EmpName,
                   e.DepartmentID,
                   t.ID,
                   t.TaskTitle
                FROM 
                   tblemployee e
                JOIN 
                   tbltask t ON e.DepartmentID = t.DeptId
                WHERE 
                   e.EmpId = :eid1 AND t.Status IS NULL"; // Only that employee & new tasks
       
                     $query2 = $dbh->prepare($sql2);
                     $query2->bindParam(':eid1', $eid1, PDO::PARAM_STR); 
                     $query2->execute();
                     $newtask = $query2->rowCount();
                  ?>
                  <li><a href="new-task.php"><i class="fa-solid fa-bell"></i><span class="badge"><?php echo htmlentities($newtask); ?></span></a></li>
               </ul>
               <ul class="user_profile_dd">
                  <li>
                     <a class="dropdown-toggle" data-toggle="dropdown">
                        <?php 
                           // Debug: Check if the image exists at the expected location
                           $imagePath = "../admin/images/" . $profilePic;
                           //echo 'Image Path: ' . $imagePath . "<br>";  // Debugging the image path

                           // Check if ProfilePic exists, otherwise display a default image
                           if (empty($profilePic) || !file_exists($imagePath)) {
                               echo '<img class="img-responsive rounded-circle" src="images/layout_img/user_img.jpg" alt="#">';
                           } else {
                               echo '<img class="img-responsive rounded-circle" src="' . $imagePath . '" alt="#">';
                           }
                        ?>
                        <span class="name_user"><?php echo $empName; ?> (<?php echo $empId; ?>)</span>
                     </a>
                     <div class="dropdown-menu">
                        <a class="dropdown-item" href="profile.php">My Profile</a>
                        <a class="dropdown-item" href="change-password.php">Change Password</a>
                        <a class="dropdown-item" href="logout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </nav>
</div>
