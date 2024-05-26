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
    <title>Admin Panel - Dashboard</title>
    <?php require('inc/links.php') ?>
</head>
<body class="bg-light">
    <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
        <h3 class="mb-0 h-font">HL HOTEL</h3>
        <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
    </div>

    <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu" style="position: fixed; z-index:10;">
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
                
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>DASHBOARD</h3>
                    <h6 class="badge bg-danger py-2 px-3 rounded">Shutdown Mode is Active!</h6>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>New Bookings</h6>
                                <h1 class="mt-2 mb-0">5</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-warning p-3">
                                <h6>Refund Bookings</h6>
                                <h1 class="mt-2 mb-0">1</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>User Queries</h6>
                                <h1 class="mt-2 mb-0">4</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-danger p-3">
                                <h6>Rating & Review</h6>
                                <h1 class="mt-2 mb-0">3</h1>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>Booking Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto">
                        <option value="1">Pass 30 days</option>
                        <option value="1">Pass 90 days</option>
                        <option value="1">Past 1 Year</option>
                        <option value="1">All time</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-primary p-3">
                                <h6>Totals Bookings</h6>
                                <h1 class="mt-2 mb-0">5</h1>
                                <h4 class="mt-2 mb-0" >5400$</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>Active Bookings</h6>
                                <h1 class="mt-2 mb-0">1</h1>
                                <h4 class="mt-2 mb-0" >450$</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Cancelled Booking</h6>
                                <h1 class="mt-2 mb-0">0</h1>
                                <h4 class="mt-2 mb-0" >0$</h4>
                            </div>
                        </a>
                    </div>
                
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>User, Queries,Review Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto">
                        <option value="1">Pass 30 days</option>
                        <option value="1">Pass 90 days</option>
                        <option value="1">Past 1 Year</option>
                        <option value="1">All time</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>New Registration</h6>
                                <h1 class="mt-2 mb-0">3</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-primary p-3">
                                <h6>Queries</h6>
                                <h1 class="mt-2 mb-0">1</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-primary p-3">
                                <h6>Reviews</h6>
                                <h1 class="mt-2 mb-0">5</h1>
                            </div>
                        </a>
                    </div>
                
                </div>

                <h5>Users</h5>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Total</h6>
                                <h1 class="mt-2 mb-0">5</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>Active</h6>
                                <h1 class="mt-2 mb-0">4</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-warning p-3">
                                <h6>Inactive</h6>
                                <h1 class="mt-2 mb-0">1</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-danger p-3">
                                <h6>Unverified</h6>
                                <h1 class="mt-2 mb-0">0</h1>
                            </div>
                        </a>
                    </div>
                
                </div>

            </div>
        </div>
    </div>


    <?php require('inc/script.php') ?> 
</body>
</html>