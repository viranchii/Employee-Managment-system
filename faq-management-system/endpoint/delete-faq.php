<?php
include ('../conn/conn.php');

if (isset($_GET['faq'])) {
    $faq = $_GET['faq'];

    try {

        $query = "DELETE FROM tbl_faq WHERE tbl_faq_id = '$faq'";

        $stmt = $dbh->prepare($query);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
                <script>
                    alert('FAQ deleted successfully!');
                    window.location.href = 'http://localhost/PHP/ETMS-MAIN/faq-management-system/';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Failed to delete faq!');
                    window.location.href = 'http://localhost/PHP/ETMS-MAIN/faq-management-system/';
                </script>
            ";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>