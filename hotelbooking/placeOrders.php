<?php
session_start();
require 'admin/inc/db_config.php';

if (isset($_POST['placeOrderBtn'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phonenum = mysqli_real_escape_string($con, $_POST['phonenum']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $checkin = mysqli_real_escape_string($con, $_POST['checkin']);
    $checkout = mysqli_real_escape_string($con, $_POST['checkout']);

    if ($name == "" || $phonenum == "" || $address == "") {
        $_SESSION['message'] = "All fields are mandatory!";
        header('Location:../confirm_booking.php');
        exit(0);
    }

    $tracking_no = "user" . rand(1111, 9999) . substr($phonenum, 2);
    $query = "INSERT INTO orders (tracking_no,name,phonenum,address,checkin,checkout,status) 
    VALUES ('$tracking_no','$name','$phonenum','$address','$checkin','$checkout','AWAITING')";
    $con->query($query) ;
    
    /*$name = $_POST['name'];
    $phonenum = $_POST['phonenum'];
    $address = $_POST['address'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    // Thực hiện truy vấn để chèn dữ liệu vào bảng orders
    $sql = "INSERT INTO orders (tracking_no,name, phonenum, address, checkin, checkout)
VALUES ('$tracking_no','$name', '$phonenum', '$address', '$checkin', '$checkout')";

    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
    */

    $_SESSION['messsage'] = "Order placed sucessfully";
    header('Location: ./confirm_booking.php');
    die();
}
