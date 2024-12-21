<?php
	session_start();
	require 'db.php';
    $pid = $_GET['pid'];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $name = $_POST['name'];
        $city = $_POST['city'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $pincode = $_POST['pincode'];
        $addr = $_POST['addr'];
        $bid = $_SESSION['id'];
        $payment_method = $_POST['payment_method']; // Get selected payment method
        $upi_id = isset($_POST['upi_id']) ? $_POST['upi_id'] : ''; // Capture UPI ID (if provided)

        // Insert transaction into the database including UPI ID (if online payment selected)
        $sql = "INSERT INTO transaction (bid, pid, name, city, mobile, email, pincode, addr, payment_method, upi_id)
                VALUES ('$bid', '$pid', '$name', '$city', '$mobile', '$email', '$pincode', '$addr', '$payment_method', '$upi_id')";
        
        $result = mysqli_query($conn, $sql);
        if($result)
        {
            $_SESSION['message'] = "Order Successfully placed! <br /> Thanks for shopping with us!!!";
            header('Location: Login/success.php');
        }
        else {
            // Correct way to handle error
            echo "Error: " . mysqli_error($conn); // Use $conn instead of $result
        }

    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>AgroCulture: Transaction</title>
	<meta lang="eng">
	<meta charset="UTF-8">
	<title>AgroCulture</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/skel.min.js"></script>
	<script src="js/skel-layers.min.js"></script>
	<script src="js/init.js"></script>
	<link rel="stylesheet" href="Blog/commentBox.css" />
</head>
<body>

    <?php
        require 'menu.php';
    ?>

    <section id="main" class="wrapper">
        <div class="container">
        <center>
                <h2>Transaction Details</h2>
        </center>
        <section id="two" class="wrapper style2 align-center">
        <div class="container">
            <center>
                <form method="post" action="buyNow.php?pid=<?= $pid; ?>" style="border: 1px solid black; padding: 15px;">
                    <center>
                    <div class="row uniform">
                        <div class="6u 12u$(xsmall)">
                            <input type="text" name="name" id="name" value="" placeholder="Name" required/>
                        </div>
                        <div class="6u 12u$(xsmall)">
                            <input type="text" name="city" id="city" value="" placeholder="City" required/>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="6u 12u$(xsmall)">
                            <input type="text" name="mobile" id="mobile" value="" placeholder="Mobile Number" required/>
                        </div>

                        <div class="6u 12u$(xsmall)">
                            <input type="email" name="email" id="email" value="" placeholder="Email" required/>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="4u 12u$(xsmall)">
                            <input type="text" name="pincode" id="pincode" value="" placeholder="Pincode" required/>
                        </div>
                        <div class="8u 12u$(xsmall)">
                            <input type="text" name="addr" id="addr" value="" placeholder="Address" style="width:80%" required/>
                        </div>
                    </div>
                    
                    <!-- Payment Method Section -->
                    <div class="row uniform">
                        <p><b>Select Payment Method:</b></p>
                        <div class="3u 12u$(small)">
                            <input type="radio" id="cash" name="payment_method" value="Cash" checked>
                            <label for="cash">Cash on Delivery</label>
                        </div>
                        <div class="3u 12u$(small)">
                            <input type="radio" id="online" name="payment_method" value="Online">
                            <label for="online">Online Payment</label>
                        </div>
                    </div>

                    <!-- QR Code or UPI Details -->
                    <div id="online-payment-details" style="display:none;">
                        <p><b>Scan the QR code or use UPI ID for payment:</b></p>
                        <!-- Initially hidden QR code -->
                        <div id="qr-code" style="display:none;">
                            <img src="js/images/qr.jpeg" alt="QR Code" style="width:200px; height:200px;">
                            <p><b>UPI ID:</b> agroculture@upi</p>
                        </div>
                        
                        <!-- UPI ID Input Field -->
                        <div>
                            <label for="upi_id">Enter Your UPI ID:</label>
                            <input type="text" name="upi_id" id="upi_id" placeholder="Enter UPI ID" />
                        </div>

                        <!-- Show QR Code Button -->
                        <button type="button" id="show-qr" onclick="showQRCode()">Show QR Code</button>
                    </div>

                    <br />
                    <p>
                        <input type="submit" value="Confirm Order" />
                    </p>
                </center>
            </form>
        </fieldset>
    </div>
</section>
</div>
</section>

<script>
// Show or hide online payment details based on the selected payment method
document.querySelectorAll('input[name="payment_method"]').forEach((radio) => {
    radio.addEventListener('change', function() {
        if (this.value == 'Online') {
            document.getElementById('online-payment-details').style.display = 'block';
        } else {
            document.getElementById('online-payment-details').style.display = 'none';
            document.getElementById('qr-code').style.display = 'none'; // Hide QR code if payment method is not online
        }
    });
});

// Function to show QR code when the button is clicked
function showQRCode() {
    document.getElementById('qr-code').style.display = 'block'; // Show the QR code
}
</script>

</body>
</html>
