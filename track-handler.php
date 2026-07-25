<?php 
session_start();
include 'db.php';

if (isset($_POST['submit'])) {
    $tnumber = trim($_POST['tnumber']);
    $stmt = mysqli_prepare($link, "SELECT * FROM tracking WHERE tracking_number = ?");
    mysqli_stmt_bind_param($stmt, "s", $tnumber);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['track'] = $tnumber;
        header("location: tracking-result.php");
        exit;
    } else {
        echo "<script>alert('Tracking Number Not Found'); history.back();</script>";
    }
    mysqli_stmt_close($stmt);
}

?>