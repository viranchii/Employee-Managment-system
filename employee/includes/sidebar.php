<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<nav id="sidebar">
   <div class="sidebar_blog_1">
      <div class="sidebar-header">
         <!--div class="logo_section">
            <a href="dashboard.php"><img class="logo_icon img-responsive" src="images/logo/logo_icon.png" alt="#" /></a>
         </div-->
      </div>
      <div class="sidebar_user_info">
         <div class="icon_setting"></div>
         <div class="user_profle_side">
            <div class="user_img"><img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" /></div>
            <div class="user_info">
               <?php
               $eid = $_SESSION['empid'];
               $sql = "SELECT EmpName,EmpEmail from  tblemployee where EmpId=:eid";
               $query = $dbh->prepare($sql);
               $query->bindParam(':eid', $eid, PDO::PARAM_STR);
               $query->execute();
               $results = $query->fetchAll(PDO::FETCH_OBJ);
               $cnt = 1;
               if ($query->rowCount() > 0) {
                  foreach ($results as $row) { ?>
                     <h6><?php echo $row->EmpName; ?></h6>
                     <p><span class="online_animation"></span> <?php echo $row->EmpEmail; ?></p><?php $cnt = $cnt + 1;
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
         <li><a href="qrScan.php"><i class="fa fa-adjust orange_color"></i> <span>Attendance</span></a></li>
         <li class="active">
            <a href="#dashboard2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa fa-file red_color"></i> <span>Task</span></a>
            <ul class="collapse list-unstyled" id="dashboard2">
               <li>
                  <a href="new-task.php">> <span>New Task</span></a>
               </li>
               <li>
                  <a href="inprogress-task.php">> <span>Inprogress Task</span></a>
               </li>
               <li>
                  <a href="completed-task.php">> <span>Completed Task</span></a>
               </li>
               <li>
                  <a href="all-task.php">> <span>All Task</span></a>
               </li>
            </ul>
         </li>
         <li class="active">
            <a href="#dashboard3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa-solid fa-circle-exclamation" style="color: #ea5353;"></i><span>Complaint</span></a>
            <ul class="collapse list-unstyled" id="dashboard3">
               <li>
                  <a href="register-complaint.php">> <span>New Complaint</span></a>
               </li>
               <li>
                  <a href="complaint-history.php">> <span>Complaint History</span></a>
               </li>
            </ul>
         </li>
         <li class="active">
            <a href="#dashboard4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa-solid fa-person-walking-arrow-right" style="color: #B197FC;"></i><span>Leaves</span></a>
            <ul class="collapse list-unstyled" id="dashboard4">
               <li>
                  <a href="apply-leave.php">> <span>Apply Leave</span></a>
               </li>
               <li>
                  <a href="leavehistory.php">> <span>Leave History</span></a>
               </li>
            </ul>
         </li>
         <li class="active">
            <a href="#dashboard5" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">  <i class="fa fa-dollar-sign red_color"></i>  <span>Salary</span></a>
            <ul class="collapse list-unstyled" id="dashboard5">
               <li>
                  <a href="pending-salary.php">> <span>Pending Salary</span></a>
               </li>
               <li>
                  <a href="paid-salary.php">> <span>Paid Salary</span></a>
               </li>
               <li><a href="salary-slip.php">> <span>Salary Slip</span></a></li>
            </ul>
         </li>

         <li class="active">
            <a href="#dashboard7" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fa-solid fa-people-group" style="color: #63E6BE;"></i> <span>Team Managment</span></a>
            <ul class="collapse list-unstyled" id="dashboard7">
               <li>
                  <a href="team-details.php">> <span>Team details</span></a>
               </li>
            </ul>
         </li>

         <li class="active">
            <a href="#dashboard6" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fa-solid fa-building-columns" style="color: #37be40;"></i><span>Bank Details</span></a>
            <ul class="collapse list-unstyled" id="dashboard6">
               <li>
                  <a href="add-bankdetails.php">> <span>Add BankDetails </span></a>
               </li>
               <li>
                  <a href="manage-bankdetails.php">> <span>Manage BankDetails</span></a>
               </li>
            </ul>
         </li>
      </ul>
   </div>
</nav>