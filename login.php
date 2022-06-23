<?php
session_start();
require("config.php");

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    // $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
    // $hashedpassword=md5($password);
    $query = "SELECT * FROM user
    where username= '$name' AND password= '$password'";
    $sql = mysqli_query($db, $query);
    if ($row = mysqli_fetch_assoc($sql)) {
        $_SESSION['loginid'] = $row['id'];
        $_SESSION['loginuser'] = $row['username'];
    } else {
        $error = "Incorrect Login Details";
        header("Location: login.php?error=" . $error);
    }
    if ($_SESSION['loginuser']) {
        header("Location: index.php?tab=home");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="images/umcatc-lg.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/lightbox.min.css">
    <link rel="stylesheet" href="js/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-main">
        <div class="col-md-4 mx-auto content-box px-5">
            <div class="my-4">
                <h3 class="text-center">Log in</h3>
            </div>
            <form method="POST" class="w-100" action="login.php">
                <div class="form-group">
                    <input class="form-control w-100" type="text" name="name" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input class="form-control w-100" type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input class="" type="checkbox">
                    <label>Remember Password?</label>

                </div>
                <input type="submit" value="Submit" class="btn btn-custom w-100 p-3 text-white ">

            </form>
            <a href="#" class="text-center my-3">Forgot Password?</a>

            <small class="mt-3">Powered by Doltech Solutions</small>

        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/lightbox-plus-jquery.min.js"></script>
    <script src="js/owlcarousel/owl.carousel.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/aos.js"></script>
</body>

</html>