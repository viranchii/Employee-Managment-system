


<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['empid']==0)) {
  header('location:logout.php');
  } else{



  ?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Employee Management System || Bank Details</title>
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
    function confirmDelete(bankId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete-bank.php?id=" + bankId;
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
                                        <h2>Bank Details</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                            <div class="heading1 margin_0">
                                                <h2>Bank Details</h2>
                                            </div>
                                        </div>
                                        <div class="table_section padding_infor_info">
                                            <div class="table-responsive-sm">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Employee ID</th>
                                                            <th>Bank Name</th>
                                                            <th>Account Number</th>
                                                            <th>IFSC Code</th>
                                                            <th>Branch</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
    $empid = $_SESSION['empid']; // Get logged-in employee ID

    $sql = "SELECT * FROM tblbankdetails WHERE EmpID = :empid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empid', $empid, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    ?>
                                                        <?php if ($query->rowCount() > 0) { ?>
                                                            <?php foreach ($results as $row) { ?>
                                                                <tr>
                                                                    <td><?php echo htmlentities($row->EmpID); ?></td>
                                                                    <td><?php echo htmlentities($row->BankName); ?></td>
                                                                    <td><?php echo htmlentities($row->AccountNumber); ?></td>
                                                                    <td><?php echo htmlentities($row->IFSC); ?></td>
                                                                    <td><?php echo htmlentities($row->Branch); ?></td>
                                                                    <td>
                                                                        <a href="edit-bank.php?id=<?php echo $row->BankID; ?>" ><i  class="material-icons green_color">mode_edit</i></a>
                                                                        <a href="javascript:void(0);"  onclick="confirmDelete(<?php echo $row->BankID; ?>)"><i  class="material-icons red_color">delete_forever</i>
                                                                    </a>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <tr>
                                                                <td colspan="6">No bank details found</td>
                                                            </tr>
                                                        <?php } ?>
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
    </body>
    </html>

<?php } ?>