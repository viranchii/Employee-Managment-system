<?php
session_start();
include('includes/dbconnection.php');

require('/fpdf/fpdf.php');




if (!isset($_GET['salary_id'])) {
    die("Invalid request!");
}

$salary_id = intval($_GET['salary_id']);
$empid = $_SESSION['empid'];

// Fetch salary details for the logged-in employee
$sql = "SELECT tblsalary.*, tblemployee.EmpName 
        FROM tblsalary  
        INNER JOIN tblemployee ON tblsalary.EmpID = tblemployee.EmpId
        WHERE tblsalary.SalaryID = :salary_id AND tblsalary.EmpID = :empid";

$query = $dbh->prepare($sql);
$query->bindParam(':salary_id', $salary_id, PDO::PARAM_INT);
$query->bindParam(':empid', $empid, PDO::PARAM_STR);
$query->execute();
$row = $query->fetch(PDO::FETCH_OBJ);

if (!$row) {
    die("No salary record found!");
}

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Salary Slip', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);

$pdf->Cell(50, 10, 'Employee Name:', 1);
$pdf->Cell(140, 10, $row->EmpName, 1, 1);

$pdf->Cell(50, 10, 'Basic Salary:', 1);
$pdf->Cell(140, 10, $row->BasicSalary, 1, 1);

$pdf->Cell(50, 10, 'Overtime Pay:', 1);
$pdf->Cell(140, 10, $row->OvertimePay, 1, 1);

$pdf->Cell(50, 10, 'Bonus:', 1);
$pdf->Cell(140, 10, $row->Bonus, 1, 1);

$pdf->Cell(50, 10, 'Deductions:', 1);
$pdf->Cell(140, 10, $row->Deductions, 1, 1);

$pdf->Cell(50, 10, 'Net Salary:', 1);
$pdf->Cell(140, 10, $row->NetSalary, 1, 1);

$pdf->Cell(50, 10, 'Payment Status:', 1);
$pdf->Cell(140, 10, ucfirst($row->PaymentStatus), 1, 1);

$pdf->Cell(50, 10, 'Payment Date:', 1);
$pdf->Cell(140, 10, $row->PaymentDate, 1, 1);

$pdf->Output('D', 'Salary_Slip.pdf'); // Forces download

?>
