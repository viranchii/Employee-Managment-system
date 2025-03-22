<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<nav id="sidebar">
   <div class="sidebar_blog_1">
      <div class="sidebar-header">
        
      </div>
      <div class="sidebar_user_info">
         <div class="icon_setting"></div>
         <div class="user_profle_side">
            <div class="user_img"><img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" /></div>
            <div class="user_info">
               <?php
               $aid = $_SESSION['etmsaid'];
               $sql = "SELECT AdminName,Email from  tbladmin where ID=:aid";
               $query = $dbh->prepare($sql);
               $query->bindParam(':aid', $aid, PDO::PARAM_STR);
               $query->execute();
               $results = $query->fetchAll(PDO::FETCH_OBJ);
               $cnt = 1;
               if ($query->rowCount() > 0) {
                  foreach ($results as $row) { ?>
                     <h6><?php echo $row->AdminName; ?></h6>
                     <p><span class="online_animation"></span> <?php echo $row->Email; ?></p><?php $cnt = $cnt + 1;
                  }
               } ?>
            </div>
         </div>
      </div>
   </div>
   <div class="sidebar_blog_2">
      <h4>General</h4>
      <ul class="list-unstyled components">

         <li><a href="dashboard.php"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a></li>
         <li class="active">
            <a href="#dashboard1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa fa-folder-open orange_color"></i>
            <span>Department</span></a>
            <ul class="collapse list-unstyled" id="dashboard1">
               <li>
                  <a href="add-dept.php">> <span>Add</span></a>
               </li>
               <li>
                  <a href="manage-dept.php">> <span>Manage</span></a>
               </li>
            </ul>
         </li>

       

         <li>
            <a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                  class="fa fa-users purple_color"></i> <span>Employee</span></a>
            <ul class="collapse list-unstyled" id="element">
               <li><a href="add-employee.php">> <span>Add Employee</span></a></li>
               <li><a href="manage-employee.php">> <span>Manage Employee</span></a></li>

            </ul>
         </li>


       
         <li><a href="attendance_home.php"><i class="fa-solid fa-clipboard-user green_color"></i></i> <span>Attendance</span></a></li>

         <li>
            <a href="#apps" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                  class="fa fa-object-group blue2_color"></i> <span>Task</span></a>
            <ul class="collapse list-unstyled" id="apps">
               <li><a href="add-task.php">> <span>Add Task</span></a></li>
               <li><a href="manage-task.php">> <span>Manage Task</span></a></li>

            </ul>
         </li>

         <li>
            <a href="#apps1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                  class="fa fa-briefcase blue1_color"></i> <span>Task Status</span></a>
            <ul class="collapse list-unstyled" id="apps1">

               <li><a href="new-tasks.php">> <span>New Tasks</span></a></li>
               <li><a href="inprogress-task.php">> <span>Inprogress Tasks</span></a></li>
               <li><a href="completed-task.php">> <span>Completed Tasks</span></a></li>
               <li><a href="empwise-task.php">> <span>Emp.wise Tasks</span></a></li>

            </ul>
         </li>
         <li>
            <a href="#teams" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa-solid fa-people-group" style="color: #63E6BE;"></i>  <span>Team Managment</span></a>
            <ul class="collapse list-unstyled" id="teams">
               <li><a href="add-team.php">> <span>Add Team</span></a></li>
               <li><a href="manage-team.php">> <span>Manage Team</span></a></li>

            </ul>
         </li>
         <li>
            <a href="#leaveT" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa-solid fa-right-from-bracket" style="color: #B197FC;"></i> <span>Leaves Type</span></a>
            <ul class="collapse list-unstyled" id="leaveT">

               <li><a href="addleavetype.php">> <span>Add Leaves Type</span></a></li>
               <li><a href="manageleavetype.php">> <span>Manage Leaves Type</span></a></li>
            </ul>
         </li>

         <li>
            <a href="#leave" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa-solid fa-person-walking-arrow-right" style="color: #B197FC;"></i><span>Leaves</span></a>
            <ul class="collapse list-unstyled" id="leave">

               <li><a href="all-leaves.php">> <span>All Leaves</span></a></li>
               <li><a href="pending-leavehistory.php">> <span>Panding Leaves</span></a></li>
               <li><a href="approvedleave-history.php">> <span>Approve Leaves</span></a></li>
               <li><a href="notapproved-leaves.php">> <span>Not Aprove Leaves</span></a></li>

            </ul>
         </li>

         <li>
            <a href="#complaints" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa-solid fa-circle-exclamation" style="color: #ea5353;"></i> <span>Complaints</span></a>
            <ul class="collapse list-unstyled" id="complaints">

               <li><a href="all-complaint.php">> <span>All Complaints</span></a></li>
               <li><a href="notprocess-complaint.php">> <span>Not Process Yet</span></a></li>
               <li><a href="inprocess-complaint.php">> <span>In Process</span></a></li>
               <li><a href="closed-complaint.php">> <span>Closed Complaints</span></a></li>

            </ul>
         </li>

         
         <li>
            <a href="#bank" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa-solid fa-building-columns" style="color: #37be40;"></i> <span>Bank Details</span></a>
            <ul class="collapse list-unstyled" id="bank">
               <li><a href="bank-details.php">> <span>Bank Details</span></a></li>
               

            </ul>
         </li>

         <li>
            <a href="#element1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa fa-dollar-sign red_color"></i> <span>Salary</span></a>
            <ul class="collapse list-unstyled" id="element1">
               <li><a href="salaryp.php">> <span>Add Salary</span></a></li>
               <li><a href="managesalary.php">> <span>Manage Salary</span></a></li>
               <li><a href="salary-history.php">> <span>Salary History</span></a></li>
               
            </ul>
         </li>

         <li>
            <a href="#element2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa-solid fa-money-check-dollar red_color"></i><span>Salary Status</span></a>
            <ul class="collapse list-unstyled" id="element2">
               <li><a href="pending-salary.php">> <span>pending Salary</span></a></li>
               <li><a href="paid-salary.php">> <span>Paid Salary</span></a></li>
               
            </ul>
         </li>


         <li class="active">
            <a href="#additional_page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                  class="fa fa-clone yellow_color"></i> <span> Pages</span></a>
            <ul class="collapse list-unstyled" id="additional_page">
               <li>
                  <a href="aboutus.php">> <span>About Us</span></a>
               </li>
               <li>
                  <a href="contactus.php">> <span>Contact Us</span></a>
               </li>

            </ul>
         </li>

         <li><a href="search-employee.php"><i class="fa fa-map purple_color2"></i> <span>Search Employee</span></a></li>
       
         <li><a href="betweendates-task-report.php"><i class="fa-solid fa-chart-simple green_color"></i><span>Task
                  Reports</span></a></li>

        
      </ul>
   </div>
</nav>
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