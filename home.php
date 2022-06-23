<?php
require("config.php");
if (isset($_SESSION['loginuser'])) {
?>
    <div class="inner-section">
        <div class="my-3">
            <h2 style="text-transform: uppercase">You are welcome, <?php echo $_SESSION['loginuser'] ?></h2>
            <p>You can make changes to this website by clicking any of the button below!</p>
        </div>
        <div class="row tab-container">
            <a href="index.php?tab=news" class="tab-box col-md-3">
                <i class="fa fa-edit mr-3"></i>
                News & Posts
            </a>
            <a href="index.php?tab=newsletter" class="tab-box col-md-3">
                News Letter
            </a>
            <a href="index.php?tab=calendar" class="tab-box col-md-3">
                Calendar
            </a>
            <a href="index.php?tab=gallery" class="tab-box col-md-3">
                Gallery
            </a>
            <a href="index.php?tab=staff" class="tab-box col-md-3">
                Staff
            </a>
            <a href="index.php?tab=review" class="tab-box col-md-3">
                Reviews
            </a>
            <a href="index.php?tab=department" class="tab-box col-md-3">
                Departments
            </a>
        </div>
    </div>
<?php } else {
    header("location:  login.php");
} ?>