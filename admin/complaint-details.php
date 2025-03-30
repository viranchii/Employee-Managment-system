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

      <title>Employee Management System || View New Task</title>

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
                              <h2>Complaint Details</h2>
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
                                 <div class="table-responsive-sm">
                                    <?php
                                    $vid = $_GET['viewid'];
                                    $sql = "SELECT tblcomplaints.*,tblemployee.EmpName as name,tbldepartment.DepartmentName as depname from tblcomplaints join tblemployee on tblemployee.EmpId=tblcomplaints.employeeId join tbldepartment on tbldepartment.ID=tblcomplaints.department where tblcomplaints.complaintNumber=:vid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                       foreach ($results as $row) { ?>
                                          <table class="table table-bordered" style="color:#000">
                                             <tr>
                                                <th colspan="6"
                                                   style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">
                                                   Complaint Details </th>
                                             </tr>
                                             <tr>
                                                <th>Complaint Number</th>
                                                <td><?php echo $row->complaintNumber; ?></td>
                                                <th>Department</th>
                                                <td><?php echo $row->depname; ?>
                                                <th>Employee Name</th>
                                                <td><?php echo $row->name; ?>
                                                </td>
                                             </tr>

                                             <tr>
                                                <th>State </th>
                                                <td><?php echo $row->state; ?></td>
                                                <th>Complaint Type</th>
                                                <td><?php echo $row->complaintType; ?>
                                                <th>Issue Type</th>
                                                <td><?php echo $row->issuetype; ?>
                                                </td>
                                             </tr>
                                             <tr>
                                                <th>Nature of Complaint</th>
                                                <td colspan="5"><?php echo $row->noc; ?></td>
                                             </tr>
                                             <tr>
                                                <th>Complaint Details</th>
                                                <td colspan="5"><?php echo $row->complaintDetails; ?></td>
                                             </tr>

                                             <tr>
                                                <th>File(if any)</th>
                                                <td colspan="5"><?php $cfile = $row->complaintFile;
                                                if ($cfile == "" || $cfile == "NULL") {
                                                   echo "File NA";
                                                } else { ?>
                                                      <a href="../users/complaintdocs/<?php echo htmlentities($row->complaintFile); ?>"
                                                         target="_blank" /> View File</a>
                                                   <?php } ?>
                                                </td>
                                             </tr>
                                             <tr>
                                                <th>File</th>
                                                <td> <?php $status = $row->status;
                                                if ($status == ''): ?>
                                                      <span class="badge badge-danger">Not Processed Yet</span>
                                                   <?php elseif ($status == 'in process'): ?>
                                                      <span class="badge badge-warning">In Process</span>
                                                   <?php elseif ($status == 'closed'): ?>
                                                      <span class="badge badge-success">Closed</span>
                                                   <?php endif; ?>
                                                </td>
                                             <tr>
                                                <td>
                                                   <?php if ($row->status == "closed") {

                                                   } else { ?>
                                                      <a href="javascript:void(0);"
                                                         onClick="popUpWindow('update-complaint.php?cid=<?php echo htmlentities($row->complaintNumber); ?>');"
                                                         title="Update order">
                                                         <button type="button" class="btn btn-primary">Take Action</button>
                                                   </td>
                                                   </a><?php } ?></td>
                                                <td colspan="4">
                                                   <a href="javascript:void(0);"
                                                      onClick="popUpWindow('employee-profile.php?uid=<?php echo htmlentities($row->employeeId); ?>');"
                                                      title="Update order">
                                                     
                                                </td>

                                             </tr>
                                             <?php
                                             $vid = $_GET['viewid'];
                                             if ($status != "") {
                                                $ret = "select complaintremark.remark as remark,complaintremark.status as sstatus,complaintremark.remarkDate as rdate from complaintremark join tblcomplaints on tblcomplaints.complaintNumber=complaintremark.complaintNumber where complaintremark.complaintNumber=:vid";
                                                $query = $dbh->prepare($ret);
                                                $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                ?>
                                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                                   style="color: #000;border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                   <tr align="center">
                                                      <th colspan="7" style="color:#000">Remarks</th>
                                                   </tr>
                                                   <tr>
                                                      <th>S.No</th>
                                                      <th>Remark</th>
                                                      <th>Status</th>
                                                      <th>Updation Date</th>
                                                   </tr>
                                                   <?php
                                                   foreach ($results as $row) { ?>
                                                      <tr>
                                                         <td><?php echo $cnt; ?></td>
                                                         <td><?php echo $row->remark; ?></td>
                                                         <td><?php echo $row->sstatus; ?></td>
                                                         <td><?php echo $row->rdate; ?></td><?php $cnt = $cnt + 1;
                                                   } ?>

                                                </table>
                                             <?php }
                                             ?>
                                             </tr>



                                             <?php $cnt = $cnt + 1;
                                       }
                                    } ?>


                                    </table>



                                 </div>
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
      <!-- <script src="js/vendor-all.min.js"></script> -->
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