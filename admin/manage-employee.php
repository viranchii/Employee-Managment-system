<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    // Code for deletion
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblemployee WHERE ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_INT);

        if ($query->execute()) {
            $_SESSION['delete_status'] = "success";
            header("Location: manage-employee.php");
            exit();
        } else {
            $_SESSION['delete_status'] = "failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Management System || Manage Employee</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="js/semantic.min.css" />
    <link rel="stylesheet" href="css/jquery.fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css\materialPreloader.min.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == "success") { ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Data has been deleted successfully.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    <?php unset($_SESSION['delete_status']); ?> // Clear session variable after displaying alert
                });
            <?php } ?>
            <?php if (isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == "failed") { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'errro',
                    text: 'Something went worng',
                    confirmButtonText: 'OK'
                }).then(() => {
                    <?php unset($_SESSION['delete_status']); ?> // Clear session variable after displaying alert
                });
            <?php } ?>
        });
    </script>
    <script>
        function confirmDelete(empId) {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to delete this record?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "manage-employee.php?delid=" + empId;
                }
            });
        }
    </script>

</head>

<body class="inner_page tables_page">
    <div class="full_container">
        <div class="inner_container">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="content">
                <?php include_once('includes/header.php'); ?>
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Manage Employee</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Manage Employee</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Department Name</th>
                                                        <th>Employee Name</th>
                                                        <th>Profile Pic</th>
                                                        <th>Employee Email</th>
                                                        <th>Employee Gender</th>
                                                        <th>Employee Contact Number</th>
                                                        <th>Date of Joining</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT tbldepartment.ID as did, tbldepartment.DepartmentName, tblemployee.ID as eid, tblemployee.DepartmentID, tblemployee.EmpName, tblemployee.EmpEmail, tblemployee.Gender, tblemployee.EmpContactNumber, tblemployee.EmpDateofjoining,tblemployee.ProfilePic 
                                                            FROM tblemployee 
                                                            JOIN tbldepartment ON tbldepartment.ID=tblemployee.DepartmentID";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                    $cnt = 1;
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $row) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt); ?></td>
                                                                <td><?php echo htmlentities($row->DepartmentName); ?></td>
                                                                <td><?php echo htmlentities($row->EmpName); ?></td>
                                                                <td>
                                                                    <?php if ($row->ProfilePic != "") { ?>
                                                                        <img src="./images/<?php echo htmlentities($row->ProfilePic); ?>" width="60" height="60">
                                                                    <?php } else { ?>
                                                                        <img src="images/default-avatar.png" width="60" height="60" style="border-radius:50%;">
                                                                    <?php } ?>
                                                                </td>
                                                                <td><?php echo htmlentities($row->EmpEmail); ?></td>
                                                                <td><?php echo htmlentities($row->Gender); ?></td>
                                                                <td><?php echo htmlentities($row->EmpContactNumber); ?></td>
                                                                <td><?php echo htmlentities($row->EmpDateofjoining); ?></td>
                                                                <td>
                                                                    <a href="edit-employee.php?editid=<?php echo htmlentities($row->eid); ?> "><i
                                                                            class="material-icons green_color">mode_edit</i></a>
                                                                    <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row->eid; ?>)"><i class="material-icons red_color">delete_forever</i></a>
                                                                </td>
                                                            </tr>
                                                    <?php $cnt++;
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert for deletion confirmation -->
    <script>
        <?php if (isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == "success") { ?>
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Data has been deleted successfully.',
                confirmButtonText: 'OK'
            });
        <?php unset($_SESSION['delete_status']);
        } ?>
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/analyser.js"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/semantic.min.js"></script>
</body>

</html>