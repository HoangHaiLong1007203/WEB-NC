<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php') ?>
    <title><?php echo $settings_r['site_title'] ?> - FACILITIES</title>
    <style>
        .pop:hover{
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0,3s;
        }
    </style>
</head>
<body class="bg-light">
    <?php require('inc/header.php') ?>

        <div class="my-5 px-4">
            <h2 class="fw-bold h-font text-center">FACILITIES</h2>
            <div class="h-line bg-dank"></div>
            <p class="text-center mt-3">
            Customers who are dissatisfied with the products and services you provide will be a great source of learning material for you.
            </p>
        </div>

        <div class="container">
            <div class="row">
                <?php
                    $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 10");
                    $path = FACILITIES_IMG_PATH;

                    while($row = mysqli_fetch_assoc($res)){
                        echo<<<data
                            <div class="col-lg-4 col-md-6 mb-5 px-4">
                                <div class="bg-white rounded shadow p-4 border-top border-4 border-dank pop">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="$path$row[icon]" width="40px">
                                        <h5 class="m-0 ms-3">$row[name]</h5>
                                    </div>
                                    <p>$row[description]</p>
                                </div>
                            </div>
                        data;
                    }
                
                ?>
        </div>
    </div>
    <div class="my-5 px-4">
            <h2 class="fw-bold h-font text-center">FEATURES</h2>
            <div class="h-line bg-dank"></div>
            <p class="text-center mt-3">
            Customers who are dissatisfied with the products and services you provide will be a great source of learning material for you.
            </p>
        </div>

        <div class="container">
            <div class="row">
                <?php
                    $res = mysqli_query($con, "SELECT * FROM `features` ORDER BY `id` DESC LIMIT 10");

                    while($row = mysqli_fetch_assoc($res)){
                        echo<<<data
                            <div class="col-lg-4 col-md-6 mb-5 px-4">
                                <div class="bg-white rounded shadow p-4 border-top border-4 border-dank pop">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="m-0 ms-3 text-uppercase">$row[name]</h5>
                                    </div>
                                </div>
                            </div>
                        data;
                    }
                
                ?>
        </div>
    </div>

    <?php require('inc/footer.php') ?>
   

</body>
</html>