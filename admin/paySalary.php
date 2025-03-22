<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

$salaryID = intval($_GET['salaryid']);
$sql = "SELECT * FROM tblsalary WHERE SalaryID=:salaryID";
$query = $dbh->prepare($sql);
$query->bindParam(':salaryID', $salaryID, PDO::PARAM_INT);
$query->execute();
$salary = $query->fetch(PDO::FETCH_OBJ);

if (!$salary) {
    echo "<script>alert('Salary record not found!'); window.location='managesalary.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pay Salary - Google Pay</title>
    <script src="https://pay.google.com/gp/p/js/pay.js"></script>
</head>
<body>
    <h2>Pay Salary to Employee</h2>
    <p>Amount: ₹<?php echo htmlentities($salary->NetSalary); ?></p>

    <button id="payWithGoogle">Pay with Google Pay</button>

    <script>
        function onGooglePayLoaded() {
            const paymentsClient = new google.payments.api.PaymentsClient({ environment: "TEST" });

            const paymentDataRequest = {
                apiVersion: 2,
                apiVersionMinor: 0,
                allowedPaymentMethods: [{
                    type: "CARD",
                    parameters: {
                        allowedAuthMethods: ["PAN_ONLY", "CRYPTOGRAM_3DS"],
                        allowedCardNetworks: ["VISA", "MASTERCARD"]
                    },
                    tokenizationSpecification: {
                        type: "PAYMENT_GATEWAY",
                        parameters: {
                            gateway: "example",
                            gatewayMerchantId: "your-merchant-id"
                        }
                    }
                }],
                merchantInfo: {
                    merchantId: "your-merchant-id",
                    merchantName: "Your Company"
                },
                transactionInfo: {
                    totalPriceStatus: "FINAL",
                    totalPrice: "<?php echo htmlentities($salary->NetSalary); ?>",
                    currencyCode: "INR"
                }
            };

            const button = paymentsClient.createButton({
                onClick: function () {
                    paymentsClient.loadPaymentData(paymentDataRequest)
                        .then(paymentData => {
                            console.log("Payment Successful", paymentData);
                            window.location.href = "process-payment.php?salaryid=<?php echo $salaryID; ?>&txnref=" + paymentData.paymentMethodData.tokenizationData.token;
                        })
                        .catch(err => {
                            console.error("Payment Failed", err);
                            alert("Payment was unsuccessful!");
                        });
                }
            });

            document.getElementById("payWithGoogle").replaceWith(button);
        }

        window.onload = onGooglePayLoaded;
    </script>
</body>
</html>
