<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid'] == 0)) {
   header('location:logout.php');
} else {
   ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
   <meta charset="UTF-8">

      <title>Employee Management System || Dashboard</title>
      <style>
#chartContainer {
    display: flex;
    justify-content: space-between; /* Ensures charts align side by side */
    align-items: center;
    flex-wrap: wrap; /* Allows wrapping if screen size is small */
    gap: 20px; /* Adds spacing between charts */
}

#salaryChart, #genderChart {
    width: 48% !important; /* Ensures they fit side by side */
    max-width: 450px;
    height: 400px !important;
}

#employeeChartContainer {
    width: 100%;
    text-align: center; /* Center the employee chart */
}

#employeeChart {
    width: 80% !important;
    max-width: 800px;
    height: 400px !important;
}

</style>
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

      <!-- Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

     

   </head>


   <body class="dashboard dashboard_1">
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
                              <h2>Dashboard</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
                        <div class="col-md-6 col-lg-4">
                           <div class="full counter_section margin_bottom_30 yellow_bg">
                              <div class="couter_icon">
                                 <div>
                                 <i class="fa fa-folder-open "></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php
                                    $sql1 = "SELECT * from  tbldepartment";
                                    $query1 = $dbh->prepare($sql1);
                                    $query1->execute();
                                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                    $totdept = $query1->rowCount();
                                    ?>
                                    <a href="manage-dept.php">
                                       <p class="total_no"><?php echo htmlentities($totdept); ?></p>
                                       <p class="head_couter" style="color:#fff !important">Total Department</p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                           <div class="full counter_section margin_bottom_30 blue1_bg">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-users white_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php
                                    $sql2 = "SELECT * from  tblemployee";
                                    $query2 = $dbh->prepare($sql2);
                                    $query2->execute();
                                    $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                    $totemp = $query2->rowCount();
                                    ?>
                                    <a href="manage-employee.php">
                                       <p class="total_no"><?php echo htmlentities($totemp); ?></p>
                                       <p class="head_couter" style="color:#fff">Total Employees</p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                           <div class="full counter_section margin_bottom_30 yellow_bg">
                              <div class="couter_icon">
                                 <div>
                                 <i class="fa fa-object-group "></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php
                                    $sql1 = "SELECT * from  tbltask where Status is null || Status=''";
                                    $query1 = $dbh->prepare($sql1);
                                    $query1->execute();
                                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                    $newtask = $query1->rowCount();
                                    ?>
                                    <a href="new-tasks.php">
                                       <p class="total_no"><?php echo htmlentities($newtask); ?></p>
                                       <p class="head_couter" style="color:#fff !important">New Tasks</p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                           <div class="full counter_section margin_bottom_30 red_bg">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-file white_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php
                                    $sql3 = "SELECT * from  tbltask where Status='Inprogress'";
                                    $query3 = $dbh->prepare($sql3);
                                    $query3->execute();
                                    $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                                    $inprotask = $query3->rowCount();
                                    ?>
                                    <a href="inprogress-task.php">
                                       <p class="total_no"><?php echo htmlentities($inprotask); ?></p>
                                       <p class="head_couter" style="color:#fff">Inprogress Task</p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                           <div class="full counter_section margin_bottom_30 green_bg">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-file white_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php
                                    $sql4 = "SELECT * from  tbltask where Status='Completed'";
                                    $query4 = $dbh->prepare($sql4);
                                    $query4->execute();
                                    $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
                                    $comptask = $query4->rowCount();
                                    ?>
                                    <a href="completed-task.php">
                                       <p class="total_no"><?php echo htmlentities($comptask); ?></p>
                                       <p class="head_couter" style="color:#fff">Completed Task</p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>


                        <div class="col-md-6 col-lg-4">
                           <div class="full counter_section margin_bottom_30 blue1_bg">
                              <div class="couter_icon">
                                 <div>
                                 <i class="fa fa-file white_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php
                                    $sql5 = "SELECT * from  tbltask";
                                    $query5 = $dbh->prepare($sql5);
                                    $query5->execute();
                                    $results5 = $query5->fetchAll(PDO::FETCH_OBJ);
                                    $alltasks = $query5->rowCount();
                                    ?>
                                    <a href="manage-task.php">
                                       <p class="total_no"><?php echo htmlentities($alltasks); ?></p>
                                       <p class="head_couter" style="color:#000">All Tasks </p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                           <div class="full counter_section margin_bottom_30 yellow_bg">
                              <div class="couter_icon">
                                 <div>
                                 <i class="fa-solid fa-person-walking-arrow-right" ></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php
                                    $sql1 = "SELECT * from  tblleaves";
                                    $query1 = $dbh->prepare($sql1);
                                    $query1->execute();
                                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                    $totleave = $query1->rowCount();
                                    ?>
                                    <a href="all-leaves.php">
                                       <p class="total_no"><?php echo htmlentities($totleave); ?></p>
                                       <p class="head_couter" style="color:#fff !important">Total Leave</p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                           <div class="full counter_section margin_bottom_30 blue1_bg">
                              <div class="couter_icon">
                                 <div>
                                 <i class="fa-solid fa-circle-exclamation" ></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php
                                    $sql2 = "SELECT * from  tblcomplaints";
                                    $query2 = $dbh->prepare($sql2);
                                    $query2->execute();
                                    $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                    $totemp = $query2->rowCount();
                                    ?>
                                    <a href="all-complaint.php">
                                       <p class="total_no"><?php echo htmlentities($totemp); ?></p>
                                       <p class="head_couter" style="color:#fff">Total Complaints</p>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>

                       

                     </div>

                     



<?php
// Fetch all department names to ensure they appear on X-axis
$sql = "SELECT DepartmentName FROM tbldepartment";
$query = $dbh->prepare($sql);
$query->execute();
$allDepartments = $query->fetchAll(PDO::FETCH_COLUMN); // Get department names as an array

// Fetch salary details for departments with data
$sql = "SELECT d.DepartmentName, AVG(s.NetSalary) AS AvgSalary 
        FROM tblsalary s
        JOIN tblemployee e ON s.EmpID = e.EmpId
        JOIN tbldepartment d ON e.DepartmentID = d.ID
        GROUP BY d.DepartmentName;";
$query = $dbh->prepare($sql);
$query->execute();
$salaryResults = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialize salary data with zero values for all departments
$salaries = array_fill_keys($allDepartments, 0);
$colors = [];
$index = 0;

// Define color palettes
$colorPalette = [
   'rgba(180, 20, 50, 1)',  // Darker Red
   'rgba(20, 90, 180, 1)',  // Darker Blue
   'rgba(200, 140, 0, 1)',  // Darker Yellow
   'rgba(0, 120, 120, 1)',  // Darker Teal
   'rgba(100, 50, 200, 1)', // Darker Purple
   'rgba(180, 90, 10, 1)'   // Darker Orange
];

$borderPalette = [
   'rgba(140, 20, 40, 1)',  // Darker Border Red
   'rgba(15, 75, 160, 1)',  // Darker Border Blue
   'rgba(170, 120, 0, 1)',  // Darker Border Yellow
   'rgba(0, 100, 100, 1)',  // Darker Border Teal
   'rgba(80, 40, 160, 1)',  // Darker Border Purple
   'rgba(150, 70, 5, 1)'    // Darker Border Orange
];

// Assign salaries to departments
foreach ($salaryResults as $row) {
    $salaries[$row['DepartmentName']] = $row['AvgSalary'];
}

// Generate colors for each department
foreach ($allDepartments as $dept) {
    $colors[] = $colorPalette[$index % count($colorPalette)];
    $borders[] = $borderPalette[$index % count($borderPalette)];
    $index++;
}
?>
<div id="chartContainer">
    <canvas id="salaryChart"></canvas>
    <canvas id="genderChart"></canvas>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salaryChart').getContext('2d');
    var salaryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($allDepartments); ?>,
            datasets: [{
                label: 'Average Salary (₹)',
                data: <?php echo json_encode(array_values($salaries)); ?>,
                backgroundColor: <?php echo json_encode($colors); ?>,
                borderColor: <?php echo json_encode($borders); ?>,
                borderWidth: 1,
                barThickness: 40 // Controls bar width
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php // Ensure this file contains your DB connection

$genders = [];
$counts = [];

$sql = "SELECT Gender, COUNT(*) AS Total FROM tblemployee GROUP BY Gender";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    $genders[] = $row['Gender'];
    $counts[] = $row['Total'];
}
?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  var genders = <?php echo json_encode($genders); ?>; // Gender Labels
var counts = <?php echo json_encode($counts); ?>; // Gender Counts

// Define colors for genders
var colorMap = {
    'Female': 'rgba(255, 99, 132, 0.6)',  // Red (Female)
    'Male': 'rgba(54, 162, 235, 0.6)',   // Blue (Male)
    'Other': 'rgba(255, 206, 86, 0.6)'   // Yellow (Other)
};

var borderColorMap = {
    'Female': 'rgba(255, 99, 132, 1)',
    'Male': 'rgba(54, 162, 235, 1)',
    'Other': 'rgba(255, 206, 86, 1)'
};

// Assign colors dynamically based on gender order
var backgroundColors = genders.map(gender => colorMap[gender] || 'rgba(201, 203, 207, 0.6)');
var borderColors = genders.map(gender => borderColorMap[gender] || 'rgba(201, 203, 207, 1)');

var ctx = document.getElementById('genderChart').getContext('2d');
var genderChart = new Chart(ctx, {
    type: 'polarArea',
    data: {
        labels: genders,
        datasets: [{
            label: 'Employee Count',
            data: counts,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            r: { // Use 'r' for PolarArea chart
                ticks: {
                    beginAtZero: true,
                    stepSize: 1 // Ensures only whole numbers (1,2,3,4,...)
                }
            }
        }
    }
});

</script>


<?php

$sql = "SELECT e.EmpName, 
        (SELECT COUNT(*) FROM empattendance a WHERE a.employee_id = e.EmpId) AS attendance_count,
        (SELECT COUNT(*) FROM tblleaves l WHERE l.empid = e.EmpId) AS leave_count,
        (SELECT COUNT(*) FROM tblcomplaints c WHERE c.employeeId = e.EmpId) AS complaint_count,
        (SELECT COUNT(*) FROM tbltask t WHERE t.AssignTaskto = e.ID) AS task_count
        FROM tblemployee e";

$stmt = $dbh->query($sql);
$employees = [];
$attendance = [];
$leaves = [];
$complaints = [];
$tasks = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Use fetch(PDO::FETCH_ASSOC)
    $employees[] = $row['EmpName'];
    $attendance[] = $row['attendance_count'];
    $leaves[] = $row['leave_count'];
    $complaints[] = $row['complaint_count'];
    $tasks[] = $row['task_count'];
}


?>
<br>
<br>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div id="employeeChartContainer">
    <canvas id="employeeChart"></canvas>
</div>



<script>
    var ctx = document.getElementById('employeeChart').getContext('2d');
    var employeeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($employees); ?>,
            datasets: [
                {
                    label: 'Attendance',
                    data: <?php echo json_encode($attendance); ?>,
                    backgroundColor: 'rgba(0, 64, 64, 0.9)' // Dark Teal
                },
                {
                    label: 'Leaves',
                    data: <?php echo json_encode($leaves); ?>,
                    backgroundColor: 'rgba(170, 0, 50, 0.9)' // Dark Red
                },
                {
                    label: 'Complaints',
                    data: <?php echo json_encode($complaints); ?>,
                    backgroundColor: 'rgba(204, 142, 0, 0.9)' // Dark Yellow
                },
                {
                    label: 'Tasks Assigned',
                    data: <?php echo json_encode($tasks); ?>,
                    backgroundColor: 'rgba(0, 90, 170, 0.9)' // Dark Blue
                }
            ]
        },
        options: {
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                stepSize: 1, // Ensures whole numbers
                callback: function(value) { return Number.isInteger(value) ? value : null; } 
            }
        }
    }
}

    });
</script>




  

                  </div>
               </div>
        
               <!-- footer -->
               <?php include_once('includes/footer.php'); ?>
            </div>
            <!-- end dashboard inner -->
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

   </html>
<?php } ?>