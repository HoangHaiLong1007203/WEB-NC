<?php
    require('inc/esentials.php');
    require('inc/db_config.php');
    adminLogin();

    if(isset($_GET['seen'])){
        $frm_data = filteration($_GET);
        if($frm_data['seen']=='all'){
            $q = "UPDATE `user_queries` SET `seen`=?";
            $values = [1];
            if(update($q,$values,'i')){
                alert('success', 'Đã đọc tất cả');
            }
            else{
                alert('error', 'Lỗi!');
            }
        }
        else{
            $q = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
            $values = [1, $frm_data['seen']];
            if(update($q,$values,'ii')){
                alert('success', 'Đã đọc');
            }
            else{
                alert('error', 'Lỗi!');
            }
        }
    }
    if(isset($_GET['del'])){
        $frm_data = filteration($_GET);
        if($frm_data['del']=='all'){
            $q = "DELETE FROM `user_queries`";
            if(mysqli_query($con, $q)){
                alert('success', 'Đã xoá tất cả');
            }
            else{
                alert('error', 'Lỗi!');
            }
        }
        else{
            $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(delete($q,$values,'i')){
                alert('success', 'Đã xoá thành công');
            }
            else{
                alert('error', 'Lỗi!');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X_UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Settings</title>
    <?php require('inc/links.php') ?>
</head>
<body class="bg-light">
    <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
        <h3 class="mb-0 h-font">HL HOTEL</h3>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
    </div>

    <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu" style="position: fixed; z-index: 10;">
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
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">USER QUERIES</h3>

                <!--nhóm quản lý-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                                <i class="bi bi-check-all"></i> Read all
                            </a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                                <i class="bi bi-trash"></i> Delete all
                            </a>
                        </div>
                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead >
                                    <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col" width = "10%">Name</th>
                                    <th scope="col" width = "30%">Email</th>
                                    <th scope="col" width = "30%">Message</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $q = "SELECT * FROM `user_queries` ORDER BY `sr_no` DESC";
                                        $data = mysqli_query($con,$q);
                                        $i = 1;

                                        while($row = mysqli_fetch_assoc($data)){
                                            $seen = '';
                                            if($row['seen']!=1){
                                                $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-primary mb-1'> Seen </a> <br>";
                                            }
                                            $seen.= "<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger'> Delete </a>";
                                            echo<<<query
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[message]</td>
                                                    <td>$row[date]</td>
                                                    <td>$seen</td>
                                                </tr>
                                            query;
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/script.php') ?> 
</html>