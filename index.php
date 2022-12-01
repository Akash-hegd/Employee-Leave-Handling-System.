<?php //database name is employeeleavedb.
session_start();
error_reporting(0);
include('includes/dbconn.php'); //The dbConn. php file is used to connect with the database
if (isset($_POST['signin'])) //in line number 86, in form tag name="signin". isset() method in PHP to test the form is submitted successfully or not.
{
    $uname = $_POST['username']; //in line number 105, in input tag name="username"
    $password = md5($_POST['password']); //in line number 101, in input tag name="password". md5 returns the hash as a 32 character hexadecimal number.
    $sql = "SELECT EmailId,Password,Status,id FROM tblemployees WHERE EmailId=:uname and Password=:password"; //in database we are fetching details from tblemployees table
    $query = $dbh->prepare($sql); //prepare() function is used to prepare an SQL statement for execution.
    $query->bindParam(':uname', $uname, PDO::PARAM_STR); //PDO::PARAM_STR is used for validating. when we use this our validation becomes strong
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ); //fetchall fetches all the rows and returns in the object format.

    if ($query->rowCount() > 0) //rowCount or  mysqli_num_rows() function returns the number of rows in a result set.
    {
        foreach ($results as $result) {
            $status = $result->Status;
            $_SESSION['eid'] = $result->id;
        }
        if ($status == 0) {
            $msg = "In-Active Account. Please contact your administrator!";
        } else {
            $_SESSION['emplogin'] = $_POST['username'];
            echo "<script type='text/javascript'> document.location = 'employees/leave.php'; </script>";
        }
    } else {
        echo "<script>alert('Sorry, Invalid Details.');</script>";
    }
}

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <style>
    </style>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Employee Leave Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>

</head>

<body style="background-image: url('https://t3.ftcdn.net/jpg/04/66/70/88/360_F_466708872_gXaVjuvD0C8ypM9pmZ0kObY8wpkIRt9g.jpg');">

    <p>
    <h2 class="abc">
        <center><?php
                $t = date('H');
                if ($t < 12) //24 hours time
                {
                    echo 'Good Morning';
                } else {
                    echo nl2br("Good Evening");
                }
                ?></center>
    </h2>

    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->

    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" name="signin">
                    <div class="login-form-head">
                        <h2>Group Number - 1</h2>
                        <h2>Employee Login</h2>
                        <p>Employee Leave Management System</p>
                        <?php if ($msg) { ?><div class="errorWrap"><strong>Error</strong> : <?php echo htmlentities($msg); ?> </div><?php } ?>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="username" name="username" autocomplete="off" required>
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="password" name="password" autocomplete="off" required>
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                            </div>
                            <div class="submit-btn-area">
                                <button id="form_submit" type="submit" name="signin">Login <i class="ti-arrow-right"></i></button>
                            </div>
                            <div class="form-footer text-center mt-5">
                                <p class="text-muted"><a href="admin/index.php">Go to Admin Panel</a></p>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>


</html>