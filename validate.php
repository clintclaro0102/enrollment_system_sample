<?php

include("connection.php");

if (!$conn) {
    die("Connection Failed");
} else {

 
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM admn WHERE user = '$user' AND pass = '$pass'";
    $sql2 = "SELECT * FROM student_acc WHERE user = '$user' AND pass = '$pass'";
    
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);

        if ($result && mysqli_num_rows($result) == 1) {
            session_start();
            $_SESSION['user'] = $user;
            header("Location: admin_main.php");
            exit();
        }
        else if($result2 && mysqli_num_rows($result2) == 1) {
            session_start();
            $_SESSION['user'] = $user;
            header("Location: student_main.php");
            exit();

        } else {
            echo '<script>';
            echo 'alert("Invalid Login!");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
            
        }
    
}

?>
