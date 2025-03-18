<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (!isset($_SESSION['empid']) || strlen($_SESSION['empid']) == 0) {
    
    header('location:logout.php');
} else {

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Employee Management System || Complaint Details</title>

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

        <script language="javascript" type="text/javascript">
            var popUpWin = 0;
            function popUpWindow(URLStr, left, top, width, height) {
                if (popUpWin) {
                    if (!popUpWin.closed) popUpWin.close();
                }
                popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
            }

        </script>

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
                                        <h2> Complaint Details</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">


                                <div class="col-md-12">
                                    <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                            <div class="heading1 margin_0">
                                                <h2>Complaint Details</h2>
                                            </div>
                                        </div>
                                        <div class="table_section padding_infor_info">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>

                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $vid = $_GET['viewid'];
                                                        $st = 'closed';

                                                        $sql = "select tblcomplaints.*,tblemployee.EmpName as name,tbldepartment.DepartmentName as depname from tblcomplaints join tblemployee on tblemployee.EmpId=tblcomplaints.employeeId join tbldepartment on tbldepartment.ID=tblcomplaints.department where tblcomplaints.complaintNumber=:vid";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        foreach ($results as $row) {
                                                            ?>
                                                            <tr>
                                                                <td><b>Complaint Number</b></td>
                                                                <td><?php echo htmlentities($row->complaintNumber); ?>
                                                                </td>
                                                                <td><b>Employee Name</b></td>
                                                                <td> <?php echo htmlentities($row->name); ?></td>
                                                                <td><b>Reg Date</b></td>
                                                                <td><?php echo htmlentities($row->regDate); ?>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td><b>Department </b></td>
                                                                <td><?php echo htmlentities($row->depname); ?></td>
                                                               
                                                                <td><b>Complaint Type</b></td>
                                                                <td><?php echo htmlentities($row->complaintType); ?></td>
                                                                <td><b>IssueType</b></td>
                                                                <td> <?php echo htmlentities($row->issueType); ?></td>
                                                                
                                                            </tr>
                                                            <tr>
                                                                <td><b>State </b></td>
                                                                <td><?php echo htmlentities($row->state); ?></td>
                                                                <td><b>Nature of Complaint</b></td>
                                                                <td colspan="3"> <?php echo htmlentities($row->noc); ?>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td><b>Complaint Details </b></td>

                                                                <td colspan="5">
                                                                    <?php echo htmlentities($row->complaintDetails); ?>
                                                                </td>

                                                            </tr>

                                                            </tr>
                                                            <tr>
                                                                <td><b>File(if any) </b></td>

                                                                <td colspan="5"> <?php $cfile = $row->complaintFile;
                                                                if ($cfile == "" || $cfile == "NULL") {
                                                                    echo "File NA";
                                                                } else { ?>
                                                                        <a href="../user/complaintdocs/<?php echo htmlentities($row->complaintFile); ?>"
                                                                            target="_blank" /> View File</a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td><b>Final Status</b></td>

                                                                <td colspan="5"> <?php $status = $row->status;
                                                                if ($status == ''): ?>
                                                                        <span class="badge badge-danger">Not Processed
                                                                            Yet</span>
                                                                    <?php elseif ($status == 'in process'): ?>
                                                                        <span class="badge badge-warning">In Process</span>
                                                                    <?php elseif ($status == 'closed'): ?>
                                                                        <span class="badge badge-success">Closed</span>
                                                                    <?php endif; ?>
                                                                </td>

                                                            </tr>

                                                            <hr>

                                                            <!---- Complaint History--->

                                                    <?php
                                                    $sql = "select complaintremark.remark as remark,complaintremark.status as sstatus,complaintremark.remarkDate as rdate from complaintremark join tblcomplaints on tblcomplaints.complaintNumber=complaintremark.complaintNumber where complaintremark.complaintNumber=:vid";
                                                    $query = $dbh->prepare($sql);
                                                    $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    $count = $query->rowCount();
                                                    if ($count):
                                                        ?>


                                                    <tr>
                                                        <th colspan="4">Remark</th>
                                                        <th>Status</th>
                                                        <th>Updation Date</th>
                                                    </tr>
                                                    <?php foreach ($results as $rw) {
                                                        ?>
                                                    <tr>

                                                        <td colspan="4"><?php echo htmlentities($rw->remark); ?>
                                                        </td>
                                                        <td><?php echo htmlentities($rw->sstatus); ?></td>
                                                        <td><?php echo htmlentities($rw->rdate); ?></td>
                                                    </tr><?php $cnt = $cnt + 1;
                                                    } ?>




                                                    <?php endif;
                                                        } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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