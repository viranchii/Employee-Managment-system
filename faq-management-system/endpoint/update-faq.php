<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['question'], $_POST['answer'])) {
        $faqID = $_POST['tbl_faq_id'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];


        try {
            $stmt = $dbh->prepare("UPDATE tbl_faq SET question = :question, answer = :answer WHERE tbl_faq_id = :tbl_faq_id");
            
            $stmt->bindParam(":tbl_faq_id", $faqID, PDO::PARAM_STR);
            $stmt->bindParam(":question", $question, PDO::PARAM_STR);
            $stmt->bindParam(":answer", $answer, PDO::PARAM_STR);

            $stmt->execute();

            header("Location:Location: http://localhost/EMS/EMS_MAIN/faq-management-system/");

            exit();
        } catch (PDOException $e) {
            echo "Error:" . $e->getMessage();
        }

    } else {
        echo "
            <script>
                alert('Please fill in all fields!');
                window.location.href = 'Location: http://localhost/EMS/EMS_MAIN/faq-management-system/';
            </script>
        ";
    }
}
?>
