<?php
session_start();
include('includes/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Attendance System</title>
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Data Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.15) 0%, rgba(0, 0, 0, 0.15) 100%), radial-gradient(at top center, rgba(255, 255, 255, 0.40) 0%, rgba(0, 0, 0, 0.40) 120%) #989898;
            background-blend-mode: multiply, multiply;
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

        .student-container {
            height: 90%;
            width: 90%;
            border-radius: 20px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .student-container>div {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            border-radius: 10px;
            padding: 30px;
            height: 100%;
        }

        .title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        table.dataTable thead>tr>th.sorting,
        table.dataTable thead>tr>th.sorting_asc,
        table.dataTable thead>tr>th.sorting_desc,
        table.dataTable thead>tr>th.sorting_asc_disabled,
        table.dataTable thead>tr>th.sorting_desc_disabled,
        table.dataTable thead>tr>td.sorting,
        table.dataTable thead>tr>td.sorting_asc,
        table.dataTable thead>tr>td.sorting_desc,
        table.dataTable thead>tr>td.sorting_asc_disabled,
        table.dataTable thead>tr>td.sorting_desc_disabled {
            text-align: center;
        }
    </style>
</head>

<body class="inner_page tables_page">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <?php include_once('includes/sidebar.php'); ?>
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

                                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                                        <a class="navbar-brand ml-4" href="#">QR Code Attendance System</a>
                                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>

                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                            <ul class="navbar-nav mr-auto">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="./attendance_home.php">Home <span
                                                            class="sr-only">(current)</span></a>
                                                </li>
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="./attendance_masterlist.php">List of
                                                        Students</a>
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

                                        <div class="student-container">
                                            <div class="student-list">
                                                <div class="title">
                                                    <h4>List of Students</h4>
                                                    <button class="btn btn-dark" data-toggle="modal"
                                                        data-target="#addStudentModal">Add Employee</button>
                                                </div>
                                                <hr>
                                                <div class="table-container table-responsive">
                                                    <table class="table text-center table-sm" id="studentTable">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Department</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $stmt = $dbh->prepare("SELECT * FROM tbl_student");
                                                            $stmt->execute();

                                                            $result = $stmt->fetchAll();

                                                            foreach ($result as $row) {
                                                                $studentID = $row["tbl_student_id"];
                                                                $studentName = $row["student_name"];
                                                                $studentCourse = $row["course_section"];
                                                                $qrCode = $row["generated_code"];
                                                                ?>

                                                                <tr>
                                                                    <th scope="row" id="studentID-<?= $studentID ?>">
                                                                        <?= $studentID ?>
                                                                    </th>
                                                                    <td id="studentName-<?= $studentID ?>">
                                                                        <?= $studentName ?>
                                                                    </td>
                                                                    <td id="studentCourse-<?= $studentID ?>">
                                                                        <?= $studentCourse ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="action-button">
                                                                            <button class="btn btn-success btn-sm"
                                                                                data-toggle="modal"
                                                                                data-target="#qrCodeModal<?= $studentID ?>"><img
                                                                                    src="https://cdn-icons-png.flaticon.com/512/1341/1341632.png"
                                                                                    alt="" width="16"></button>

                                                                            <!-- QR Modal -->
                                                                            <div class="modal fade"
                                                                                id="qrCodeModal<?= $studentID ?>"
                                                                                tabindex="-1" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title">
                                                                                                <?= $studentName ?>'s QR
                                                                                                Code
                                                                                            </h5>
                                                                                            <button type="button"
                                                                                                class="close"
                                                                                                data-dismiss="modal"
                                                                                                aria-label="Close">
                                                                                                <span
                                                                                                    aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body text-center">
                                                                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $qrCode ?>"
                                                                                                alt="" width="300">
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <button class="btn btn-secondary btn-sm"
                                                                                onclick="updateStudent(<?= $studentID ?>)">&#128393;</button>
                                                                            <button class="btn btn-danger btn-sm"
                                                                                onclick="deleteStudent(<?= $studentID ?>)">&#10006;</button>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Add Modal -->
                                    <div class="modal fade" id="addStudentModal" data-backdrop="static"
                                        data-keyboard="false" tabindex="-1" aria-labelledby="addStudent"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addStudent">Add Employee</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="./attendance_endpoint/add-student.php" method="POST">
                                                        <div class="form-group">
                                                            <label for="studentName">Full Name:</label>
                                                            <input type="text" class="form-control" id="studentName"
                                                                name="student_name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="studentCourse">Department:</label>
                                                            <input type="text" class="form-control" id="studentCourse"
                                                                name="course_section">
                                                        </div>
                                                        <button type="button"
                                                            class="btn btn-secondary form-control qr-generator"
                                                            onclick="generateQrCode()">Generate QR Code</button>

                                                        <div class="qr-con text-center" style="display: none;">
                                                            <input type="hidden" class="form-control" id="generatedCode"
                                                                name="generated_code">
                                                            <p>Take a pic with your qr code.</p>
                                                            <img class="mb-4" src="" id="qrImg" alt="">
                                                        </div>
                                                        <div class="modal-footer modal-close" style="display: none;">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-dark">Add List</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Update Modal -->
                                    <div class="modal fade" id="updateStudentModal" data-backdrop="static"
                                        data-keyboard="false" tabindex="-1" aria-labelledby="updateStudent"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateStudent">Update Student</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="./attendance_endpoint/update-student.php"
                                                        method="POST">
                                                        <input type="hidden" class="form-control" id="updateStudentId"
                                                            name="tbl_student_id">
                                                        <div class="form-group">
                                                            <label for="updateStudentName">Full Name:</label>
                                                            <input type="text" class="form-control"
                                                                id="updateStudentName" name="student_name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="updateStudentCourse">Course and Section:</label>
                                                            <input type="text" class="form-control"
                                                                id="updateStudentCourse" name="course_section">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-dark">Add</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bootstrap JS -->
                                    <script
                                        src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
                                    <script
                                        src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
                                    <script
                                        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

                                    <!-- Data Table -->
                                    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

                                    <script>
                                        $(document).ready(function () {
                                            $('#studentTable').DataTable();
                                        });

                                        function updateStudent(id) {
                                            $("#updateStudentModal").modal("show");

                                            let updateStudentId = $("#studentID-" + id).text();
                                            let updateStudentName = $("#studentName-" + id).text();
                                            let updateStudentCourse = $("#studentCourse-" + id).text();

                                            $("#updateStudentId").val(updateStudentId);
                                            $("#updateStudentName").val(updateStudentName);
                                            $("#updateStudentCourse").val(updateStudentCourse);
                                        }

                                        function deleteStudent(id) {
                                            if (confirm("Do you want to delete this student?")) {
                                                window.location = "./attendance_endpoint/delete-student.php?student=" + id;
                                            }
                                        }

                                        function generateRandomCode(length) {
                                            const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                                            let randomString = '';

                                            for (let i = 0; i < length; i++) {
                                                const randomIndex = Math.floor(Math.random() * characters.length);
                                                randomString += characters.charAt(randomIndex);
                                            }

                                            return randomString;
                                        }

                                        function generateQrCode() {
                                            const qrImg = document.getElementById('qrImg');

                                            let text = generateRandomCode(10);
                                            $("#generatedCode").val(text);

                                            if (text === "") {
                                                alert("Please enter text to generate a QR code.");
                                                return;
                                            } else {
                                                const apiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(text)}`;

                                                qrImg.src = apiUrl;
                                                document.getElementById('studentName').style.pointerEvents = 'none';
                                                document.getElementById('studentCourse').style.pointerEvents = 'none';
                                                document.querySelector('.modal-close').style.display = '';
                                                document.querySelector('.qr-con').style.display = '';
                                                document.querySelector('.qr-generator').style.display = 'none';
                                            }
                                        }
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer -->
                    <?php include_once('includes/footer.php'); ?>
                </div>
                <!-- end dashboard inner -->
            </div>
        </div>
        <!-- model popup -->

    </div>


    <!-- jQuery -->
    <!-- <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script> -->
    <!-- wow animation -->
    <!-- <script src="js/animate.js"></script> -->
    <!-- select country -->
    <!-- <script src="js/bootstrap-select.js"></script> -->
    <!-- owl carousel -->
    <!-- <script src="js/owl.carousel.js"></script>  -->
    <!-- chart js -->
    <!-- <script src="js/Chart.min.js"></script>
      <script src="js/Chart.bundle.min.js"></script>
      <script src="js/utils.js"></script>
      <script src="js/analyser.js"></script> -->
    <!-- nice scrollbar -->
    <!-- <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script> -->
    <!-- fancy box js -->
    <!-- <script src="js/jquery-3.3.1.min.js"></script>
      <script src="js/jquery.fancybox.min.js"></script> -->
    <!-- custom js -->
    <!-- <script src="js/custom.js"></script> -->
    <!-- calendar file css -->
    <!-- <script src="js/semantic.min.js"></script> -->


</body>

</html>