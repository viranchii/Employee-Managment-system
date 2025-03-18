<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    ?>

    <script language="javascript" type="text/javascript">
        function f2() {
            window.close();
        }
        function f3() {
            window.print();
        }
    </script>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>User Profile</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
        <link href="anuj.css" rel="stylesheet" type="text/css">
    </head>

    <body>

        <div style="margin-left:50px;">
            <form name="updateticket" id="updateticket" method="post">
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                    <?php
                    $uid = $_GET['uid'];
                    $ret1 = "SELECT * FROM tblemployee WHERE ID = :uid";
                    $query = $dbh->prepare($ret1);
                    $query->bindParam(':uid', $uid, PDO::PARAM_INT);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) {
                            ?>

                            <tr>
                                <td colspan="2" style="text-align:center"><b><?php echo htmlentities($row->EmpName); ?>'s
                                        profile</b></td>
                            </tr>

                            <tr height="50">
                                <td><b>Joining Date:</b></td>
                                <td><?php echo htmlentities($row->EmpDateofjoining); ?></td>
                            </tr>
                            <tr height="50">
                                <td><b>User Email:</b></td>
                                <td><?php echo htmlentities($row->EmpEmail); ?></td>
                            </tr>
                            <tr height="50">
                                <td><b>User Contact No:</b></td>
                                <td><?php echo htmlentities($row->EmpContactNumber); ?></td>
                            </tr>
                            <tr height="50">
                                <td><b>Address:</b></td>
                                <td><?php echo htmlentities($row->EmpAddress); ?></td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input name="Submit2" type="submit" class="txtbox4" value="Close this window"
                                        onClick="return f2();" style="cursor: pointer;" />
                                </td>
                            </tr>

                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='2' style='text-align:center;color:red;'><b>No Record Found</b></td></tr>";
                    }
                    ?>
                </table>
            </form>
        </div>

    </body>

    </html>

<?php } ?>