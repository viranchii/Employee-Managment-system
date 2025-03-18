<?php
include('includes/dbconnection.php');
if (!empty($_POST["catid"])) {
    $id = intval($_POST['catid']);
    if (!is_numeric($id)) {

        echo htmlentities("invalid industryid");
        exit;
    } else {
        $stmt = "SELECT subcategory FROM subcategory WHERE categoryid ='$id'";
        $query = $dbh->prepare(query: $stmt);

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        ?>
        <option selected="selected">Select Subcategory </option><?php
        foreach ($results as $row) {
            ?>
            <option value="<?php echo htmlentities($row->subcategory); ?>"><?php echo htmlentities($row->subcategory); ?>
            </option>
            <?php
        }
    }

}
?>