function paySalary(salaryID, empID, amount) {
    const paymentsClient = new google.payments.api.PaymentsClient({ environment: 'TEST' });

    const paymentDataRequest = {
        apiVersion: 2,
        apiVersionMinor: 0,
        allowedPaymentMethods: [{
            type: 'CARD',
            parameters: {
                allowedAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                allowedCardNetworks: ['VISA', 'MASTERCARD']
            },
            tokenizationSpecification: {
                type: 'PAYMENT_GATEWAY',
                parameters: {
                    gateway: 'stripe',  // Use actual payment gateway
                    gatewayMerchantId: 'your_merchant_id'
                }
            }
        }],
        merchantInfo: {
            merchantId: 'your_merchant_id',
            merchantName: 'Your Company Name'
        },
        transactionInfo: {
            totalPriceStatus: 'FINAL',
            totalPrice: amount.toString(),
            currencyCode: 'INR'
        }
    };

    paymentsClient.loadPaymentData(paymentDataRequest)
        .then(paymentData => {
            fetch('process-payment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    salaryID: salaryID,
                    empID: empID,
                    amount: amount,
                    transactionID: paymentData.paymentMethodData.tokenizationData.token
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Salary Paid Successfully', 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message || 'Payment Failed', 'error');
                }
            });
        })
        .catch(error => {
            console.error('Payment Error:', error);
            Swal.fire('Error', 'Payment Cancelled', 'error');
        });
}
