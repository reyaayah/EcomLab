<?php
session_start();
@include 'config.php';
@include 'setting.php';

$grand_total = isset($_GET['total']) ? $_GET['total'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eSewa Payment</title>
    <link rel="stylesheet" href="styleEsewa.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-sha256.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
</head>
<body>
<div class="container">
<section class="checkout-form">
   <h1 class="heading">Complete Your Payment</h1>
    <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
        <div class="flex">
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" value="<?php echo $grand_total; ?>" required>
            <label for="tax_amount">Tax Amount:</label>
            <input type="text" id="tax_amount" name="tax_amount" value="200">
            <label for="total_amount">Total Amount:</label>
            <input type="text" id="total_amount" name="total_amount" readonly>
            <input type="hidden" id="transaction_uuid" name="transaction_uuid" readonly>
            <label for="product_code">Product Code:</label>
            <input type="text" id="product_code" name="product_code" value="EPAYTEST" required>
            <label for="product_service_charge">Product Service Charge:</label>
            <input type="text" id="product_service_charge" name="product_service_charge" value="50" required>
            <label for="product_delivery_charge">Product Delivery Charge:</label>
            <input type="text" id="product_delivery_charge" name="product_delivery_charge" value="100" required>
            <input type="hidden" id="success_url" name="success_url" value="https://esewa.com.np" required>
            <input type="hidden" id="failure_url" name="failure_url" value="https://google.com" required>
            <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
            <input type="hidden" id="signature" name="signature" readonly required>
            <input class="submit-button" value="Pay With eSewa" type="submit">
        </div>
    </form>
</section>
</div>
<script>
    function calculateTotalAmount() {
        var amount = parseFloat(document.getElementById("amount").value) || 0;
        var taxAmount = parseFloat(document.getElementById("tax_amount").value) || 0;
        var serviceCharge = parseFloat(document.getElementById("product_service_charge").value) || 0;
        var deliveryCharge = parseFloat(document.getElementById("product_delivery_charge").value) || 0;

        var totalAmount = amount + taxAmount + serviceCharge + deliveryCharge;
        document.getElementById("total_amount").value = totalAmount.toFixed(2);
    }

    function generateSignature() {
        // Generate transaction UUID
        var currentTime = new Date();
        var formattedTime = currentTime.toISOString().slice(2, 10).replace(/-/g, '') + '-' + currentTime.getHours() + currentTime.getMinutes() + currentTime.getSeconds();
        document.getElementById("transaction_uuid").value = formattedTime;

        // Retrieve payment details
        var total_amount = document.getElementById("total_amount").value;
        var transaction_uuid = document.getElementById("transaction_uuid").value;
        var product_code = document.getElementById("product_code").value;
        var secret = "8gBm/:&EnhH.1/q"; // Replace with your actual secret key

        // Generate signature
        var dataToSign = `total_amount=${total_amount},transaction_uuid=${transaction_uuid},product_code=${product_code}`;
        var hash = CryptoJS.HmacSHA256(dataToSign, secret);
        var hashInBase64 = CryptoJS.enc.Base64.stringify(hash);
        document.getElementById("signature").value = hashInBase64;
    }

    // Calculate total amount and generate signature on page load
    calculateTotalAmount();
    generateSignature();
</script>
</body>
</html>