<?php
require('inc/esentials.php');
require('inc/db_config.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X_UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - New Bookings</title>
    <?php require('inc/links.php') ?>
</head>

<body class="bg-light">
    <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
        <h3 class="mb-0 h-font">HL HOTEL</h3>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
    </div>

    <div  id="dashboard-menu"class="col-lg-2 bg-dark border-top border-3 border-secondary" style="position: fixed;  z-index: 10;">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid flex-lg-column align-items-stretch">
                <h4 class="mt-2 text-light">ADMIN PAGE</h4>
                <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                        </li>
                        <li>
                            <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#bookingLinks">
                                <span>Bookings</span>
                                <span><i class="bi bi-caret-down-fill"></i></span>
                            </button>
                            <div class="collapse show px-3 small mb-1" id="bookingLinks">
                                <ul class="nav nav-pills flex-column rounder border border-secondary">
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="new_bookings.php">New Bookings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="refund_booking.php">Refund Bookings</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="user_queries.php">User queries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="rooms.php">Rooms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="features_facilities.php">Features & Facilities</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="carousel.php">Carousel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="settings.php">Setting</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container-fluid" id="main-content">
        <!-- <div id="rightcontent" style="position:absolute; width:75%; top:12%; left:19%;"> -->
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="alert alert-info">
                    <center>
                        <h2>New Bookings </h2>
                    </center>
                </div>


                <div class="alert alert-info">
                    <table class="table table-hover" style="background-color:;">
                        <thead>
                            <tr style="font-size:16px;">
                                <th>TRACKING_NO</th>
                                <th>NAME</th>
                                <th>PHONE NUMER</th>
                                <th>ADDRESS</th>
                                <th>CHECK IN</th>
                                <th>CHECK OUT</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = $con->query("SELECT * FROM orders") or die(mysqli_error());
                            while ($fetch = $query->fetch_array()) {
                                $tracking_no = $fetch['tracking_no'];
                                $name = $fetch['name'];
                                $phonenum = $fetch['phonenum'];
                                $address = $fetch['address'];
                                $checkin = $fetch['checkin'];
                                $checkout = $fetch['checkout'];
                                $status=$fetch['status'];
                            ?>
                                <tr>
                                    <td><?php echo $tracking_no; ?></td>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $phonenum; ?></td>
                                    <td><?php echo $address; ?></td>
                                    <td><?php echo $checkin; ?></td>
                                    <td><?php echo $checkout; ?></td>
                                    <td><?php echo $status;?></td>
                                    <?php 
                                    if($status== 'Confirmed'){

                                    }
                                    else if($status=='Cancelled'){

                                    }
                                    else{
                                        echo '<td> <button type="button" class="btn text-white btn-sm fw-bold custom-bg shadow-none" data-bs-toggle="modal" data-bs-target="#assign-room">
                                        <i class="bi bi-check2-square"><a style="text-decoration:none; color:white;" href="confirm.php?id='.$tracking_no.'"> Assign Room </a></i>  </button> <br>';
                                    echo '<button type="button" class="mt-2 btn btn-danger btn-sm fw-bold shadow-none">
                                    <i class="bi bi-trash"></i><a style="text-decoration:none;color:white;"  href="cancel.php?id='.$tracking_no.'">  Cancel Room</a> </button> </td>';
                                    
                                    }
                                    
                                    ?>


                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/script.php') ?>
    <script src="scripts/new_bookings.js"></script>

</html>