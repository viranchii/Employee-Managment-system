<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid'] == 0)) {
    header('location:logout.php');
} else {

    $isread = 1;
    $did = intval($_GET['leaveid']);
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));
    $sql = "update tblleaves set IsRead=:isread where id=:did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread', $isread, PDO::PARAM_STR);
    $query->bindParam(':did', $did, PDO::PARAM_STR);
    $query->execute();

    // code for action taken on leave
    if (isset($_POST['update'])) {
        $did = intval($_GET['leaveid']);
        $description = $_POST['description'];
        $status = $_POST['status'];
        date_default_timezone_set('Asia/Kolkata');
        $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));
        $sql = "update tblleaves set AdminRemark=:description,Status=:status,AdminRemarkDate=:admremarkdate where id=:did";
        $query = $dbh->prepare($sql);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
        $query->bindParam(':did', $did, PDO::PARAM_STR);
        $query->execute();
        $msg = "Leave updated Successfully";
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Employee Management System || Leave Details</title>

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

        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            /* Improve modal appearance */
            .modal {
                max-width: 500px;
                /* Adjust width */
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            }

            /* Modal title */
            .modal-content h4 {
                font-size: 22px;
                font-weight: 600;
                text-align: center;
                margin-bottom: 20px;
            }

            /* Style dropdown */
            select.browser-default {
                width: 100%;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
                background-color: #f9f9f9;
                font-size: 16px;
                margin-bottom: 15px;
            }

            /* Style textarea */
            .materialize-textarea {
                min-height: 120px;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
                font-size: 16px;
                background-color: #fff;
            }

            /* Style Submit Button */
            .modal-footer .btn {
                width: 100%;
                background-color: #007bff;
                border-radius: 5px;
                font-size: 16px;
                font-weight: bold;
                text-transform: uppercase;
                padding: 10px 0;
                transition: 0.3s ease;
            }

            .modal-footer .btn:hover {
                background-color: #0056b3;
            }

            /* Center align the modal trigger button */
            a.modal-trigger {
                display: block;
                width: fit-content;
                margin: 10px auto;
                background-color: #28a745;
                color: white;
                font-size: 16px;
                font-weight: bold;
                padding: 10px 20px;
                border-radius: 5px;
            }

            a.modal-trigger:hover {
                background-color:rgb(13, 117, 36);
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
                                        <h2>Leave Details</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">


                                <div class="col-md-12">
                                    <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                            <div class="heading1 margin_0">
                                                <h2>Leave Details</h2>
                                            </div>
                                        </div>
                                        <div class="table_section padding_infor_info">
                                            <div class="table-responsive-sm">
                                                <?php
                                                $lid = intval($_GET['leaveid']);

                                                $sql = "SELECT tblleaves.id as lid, tblemployee.EmpName, tblemployee.EmpId, 
                                                        tblemployee.ID, tblemployee.EmpContactNumber, tblemployee.EmpEmail, 
                                                        -- tblemployee.Phonenumber,
                                                        tblleaves.LeaveType, tblleaves.ToDate, tblleaves.FromDate, 
                                                        tblleaves.Description, tblleaves.PostingDate, tblleaves.Status, 
                                                        tblleaves.AdminRemark, tblleaves.AdminRemarkDate 
                                                        FROM tblleaves 
                                                        JOIN tblemployee ON tblleaves.empid = tblemployee.EmpId 
                                                        WHERE tblleaves.id = :lid";

                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':lid', $lid, PDO::PARAM_INT);
                                                if (!$query->execute()) {
                                                    print_r($query->errorInfo());
                                                    exit;
                                                }

                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() == 0) {
                                                    echo "No leave request found with this ID.";
                                                } else {
                                                    foreach ($results as $result) {
                                                        ?>
                                                        <table class="table table-bordered" style="color:#000">
                                                            <tr>
                                                                <th colspan="6"
                                                                    style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">
                                                                    Leave Details </th>
                                                            <tr>
                                                                <td style="font-size:16px;"> <b>Employe Name :</b></td>
                                                                <td colspan="2">
                                                                    <?php echo htmlentities($result->EmpName); ?></a>
                                                                </td>
                                                                <td style="font-size:16px;"><b>Emp Id :</b></td>
                                                                <td colspan="3"><?php echo htmlentities($result->EmpId); ?></td>

                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:16px;"><b>Emp Email id :</b></td>
                                                                <td colspan="2"><?php echo htmlentities($result->EmpEmail); ?></td>
                                                                <td style="font-size:16px;"><b>Emp Contact No :</b></td>
                                                                <td colspan="3">
                                                                    <?php echo htmlentities($result->EmpContactNumber); ?>
                                                                </td>

                                                            </tr>



                                                            <tr>

                                                                <td style="font-size:16px;"><b>Leave Date :</b></td>
                                                                <td>From <?php echo htmlentities($result->FromDate); ?> to
                                                                    <?php echo htmlentities($result->ToDate); ?>
                                                                </td>
                                                                <td style="font-size:16px;"><b>Posting Date :</b></td>
                                                                <td colspan="3"><?php echo htmlentities($result->PostingDate); ?>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:16px;"><b>Leave Type :</b></td>
                                                                <td colspan="5"><?php echo htmlentities($result->LeaveType); ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:16px;"><b>Employe Leave Description : </b></td>
                                                                <td colspan="5"><?php echo htmlentities($result->Description); ?>
                                                                </td>

                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:16px;"><b>leave Status :</b></td>
                                                                <td colspan="5"><?php $stats = $result->Status;
                                                                if ($stats == 1) {
                                                                    ?>
                                                                        <span style="color: green">Approved</span>
                                                                    <?php }
                                                                if ($stats == 2) { ?>
                                                                        <span style="color: red">Not Approved</span>
                                                                    <?php }
                                                                if ($stats == 0) { ?>
                                                                        <span style="color: blue">waiting for approval</span>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:16px;"><b>Admin Remark: </b></td>
                                                                <td colspan="5"><?php
                                                                if ($result->AdminRemark == "") {
                                                                    echo "waiting for Approval";
                                                                } else {
                                                                    echo htmlentities($result->AdminRemark);
                                                                }
                                                                ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:16px;"><b>Admin Action taken date : </b></td>
                                                                <td colspan="5"><?php
                                                                if ($result->AdminRemarkDate == "") {
                                                                    echo "NA";
                                                                } else {
                                                                    echo htmlentities($result->AdminRemarkDate);
                                                                }
                                                                ?></td>
                                                            </tr>

                                                            <?php if ($stats == 0) { ?>
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <!-- Modal Trigger -->
                                                                        <a class="modal-trigger waves-effect waves-light btn"
                                                                            href="#modal1">Take Action</a>

                                                                        <!-- Modal Structure -->
                                                                        <div id="modal1" class="modal">
                                                                            <div class="modal-content">
                                                                                <h4>Leave Take Action</h4>

                                                                                <!-- Form -->
                                                                                <form name="adminaction" method="post">
                                                                                    <div class="input-field">
                                                                                        <select class="browser-default" name="status"
                                                                                            required>
                                                                                            <option value="" disabled selected>Choose
                                                                                                your option</option>
                                                                                            <option value="1">Approved</option>
                                                                                            <option value="2">Not Approved</option>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div class="input-field">
                                                                                        <textarea id="textarea1" name="description"
                                                                                            class="materialize-textarea"
                                                                                            placeholder="Description" maxlength="500"
                                                                                            required></textarea>
                                                                                    </div>

                                                                                    <div class="modal-footer">
                                                                                        <button type="submit"
                                                                                            class="waves-effect waves-light btn blue"
                                                                                            name="update">Submit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>

                                                        </table>
                                                        <?php $cnt = $cnt + 1;

                                                    }
                                                } ?>

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
        <!-- Include Materialize JS (Make sure jQuery is included first) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.modal').modal(); // Initialize Modal
            });
        </script>
    </body>

    </html><?php } ?>