<?php
session_start();
require('config.php');
if (isset($_SESSION['loginuser'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CMS - Doltech</title>
        <link rel="icon" href="uploads/<?php echo $school_logo; ?>" type="image/png">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/lightbox.min.css">
        <link rel="stylesheet" href="js/aos.css">
        <link href="datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <script src="tinymce/js/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: '#mytextarea',
                height: 500,
                plugins: ["advlist autolink link image lists charmap print preview hr anchorpagebreak", "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor code"],
                toolba2: "| link unlink anchor | image media | forecolor backcolor | "
            });
            tinymce.init({
                selector: '#newslettertextarea',
                height: 500,
                plugins: ["advlist autolink link image lists charmap print preview hr anchorpagebreak", "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor code"],
                toolba2: "| link unlink anchor | image media | forecolor backcolor | "
            });
            tinymce.init({
                selector: '#departmenttextarea',
                height: 500,
                plugins: ["advlist autolink link image lists charmap print preview hr anchorpagebreak", "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor code"],
                toolba2: "| link unlink anchor | image media | forecolor backcolor | "
            });
            tinymce.init({
                selector: '#journaltextarea',
                height: 500,
                plugins: ["advlist autolink link image lists charmap print preview hr anchorpagebreak", "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor code"],
                toolba2: "| link unlink anchor | image media | forecolor backcolor | "
            });
        </script>

    </head>

    <body>
        <div class="top">
            <a href="#"><i class="fa fa-arrow-up"></i></a>
        </div>
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Launch</button> -->

        </button>
        <div id="myModal" class="modal fade" role="dialog" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Instructions</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Please Read the following Instructions Carefully</p>
                        <small>- Note that changes made here reflects immediately on the main website. Be very sure before you confirm any changes.</small><br>
                        <small>- Image Upload should not be more than 20MB</small><br>
                        <small>- Do well to contact <a href="#">Support</a> if you are not clear about anything.</small><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom text-white" data-dismiss="modal">I understand</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0">
            <div class="side col-md-2">
                <div class="side-heading">
                    <img src="uploads/<?php echo $school_logo; ?>" class="w-50">
                    <p class="text-white"><?php echo $school_name; ?></p>
                </div>

                <div class="nav nav-tabs">
                    <!-- <p>Menu</p> -->
                    <?php if (isset($_GET['tab'])) {
                        $tab = $_GET['tab'];
                    } ?>
                    <div class="side-section">
                        <a href="<?php echo $school_link; ?>" target="_blank">
                            <li>Visit Site</li>
                        </a>
                    </div>
                    <div class="side-section">
                        <a class="tab <?php if ($tab == "home") {
                                            echo "active";
                                        } elseif ($tab !== "1") {
                                            echo "";
                                        } else {
                                            echo "active";
                                        } ?>" href="index.php?tab=home">
                            <li><i class="fa fa-home"></i>Home</li>
                        </a>
                        <a class="tab <?php if ($tab == "news") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=news">
                            <li><i class="fa fa-edit"></i>Post</li>
                        </a>
                        <a class="tab <?php if ($tab == "newsletter") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=newsletter">
                            <li><i class="fa fa-newspaper"></i>News Letter</li>
                        </a>
                        <a class="tab <?php if ($tab == "calendar") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=calendar">
                            <li><i class="fa fa-calendar"></i>Calendar</li>
                        </a>
                        <a class="tab <?php if ($tab == "gallery") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=gallery">
                            <li><i class="fa fa-image"></i>Gallery</li>
                        </a>
                        <a class="tab <?php if ($tab == "staff") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=staff">
                            <li><i class="fa fa-user-circle"></i>Staff</li>
                        </a>
                        <a class="tab <?php if ($tab == "review") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=review">
                            <li><i class="fa fa-comments"></i>Review</li>
                        </a>
                        <a class="tab <?php if ($tab == "department") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=department">
                            <li><i class="fa fa-school"></i>Departments</li>
                        </a>
                        <a class="tab <?php if ($tab == "journal") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=journal">
                            <li><i class="fa fa-book"></i>Journals/Articles</li>
                        </a>
                        <a class="tab <?php if ($tab == "youtube") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=youtube">
                            <li><i class="fab fa-youtube" aria-hidden="true"></i>Youtube Embed</li>
                        </a>
                    </div>
                    <div class="side-section">
                        <a class="tab <?php if ($tab == "setting") {
                                            echo "active";
                                        }; ?>" href="index.php?tab=setting">
                            <li><i class="fa fa-cog"></i>Settings</li>
                        </a>
                        <a data-toggle="modal" href="#myModal">
                            <li><i class="fa fa-book"></i>Documentation</li>
                        </a>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="sec-sub col-md-10 p-0">
                <div class="head-sec p-3 px-4">
                    <div class="row">
                        <p class="mr-2">Contact Support: +2349014050998</p>
                        <p class="">| Note: Changes Here reflects directly on the website</p>
                    </div>
                    <div class="head-right">
                        <i class="fa fa-user-circle "></i>
                        <p><?php echo $_SESSION['loginuser'] ?></p>
                        <a href="logout.php"><button class="btn btn-danger btn-sm"><i class="fa fa-sign-out-alt mr-2" aria-hidden="true"></i>Log out</button></a>
                    </div>

                </div>
                <div class="sec-body">
                    <?php require('message.php');  ?>
                    <div class="tab-content container">
                        <?php if (isset($_GET['tab'])) {
                            $tab = $_GET['tab'];
                        } ?>
                        <div class="tab-pane <?php if ($tab == "home") {
                                                    echo "active";
                                                } ?>" id="home">
                            <?php include('home.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "news") {
                                                    echo "active";
                                                } ?>" id="news">
                            <?php include('news.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "newsletter") {
                                                    echo "active";
                                                } ?>" id="newsletter">
                            <?php include('newsletter.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "calendar") {
                                                    echo "active";
                                                } ?>" id="calendar">
                            <?php include('calendar.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "gallery") {
                                                    echo "active";
                                                } ?>" id="gallery">
                            <?php include('gallery.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "staff") {
                                                    echo "active";
                                                } ?>" id="staff">
                            <?php include('staff.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "review") {
                                                    echo "active";
                                                } ?>" id="review">
                            <?php include('review.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "department") {
                                                    echo "active";
                                                } ?>" id="department">
                            <?php include('department.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "youtube") {
                                                    echo "active";
                                                } ?>" id="youtube">
                            <?php include('youtube.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "setting") {
                                                    echo "active";
                                                } ?>" id="setting">
                            <?php include('setting.php'); ?>
                        </div>
                        <div class="tab-pane <?php if ($tab == "journal") {
                                                    echo "active";
                                                } ?>" id="journal">
                            <?php include('journal.php'); ?>
                        </div>
                    </div>
                </div>
                <div class="footer text-center p-3 bg-light">
                    <small>Powered by Doltech Solutions</small>
                </div>
            </div>
        </div>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
        <script src="js/lightbox-plus-jquery.min.js"></script>
        <script src="js/owlcarousel/owl.carousel.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/aos.js"></script>
        <script src="datatables/jquery.dataTables.min.js"></script>
        <script src="datatables/dataTables.bootstrap4.min.js"></script>
        <script src="js/datatables-demo.js"></script>
        <script>
            $(document).ready(function() {
                $("#myModal").modal('show');
            })
        </script>
        <script>
            $(window).scroll(function() {
                if ($(window).scrollTop() > 60) {
                    $(".top").show();
                } else {
                    $(".top").hide();
                }
            });
        </script>

    </body>

    </html>


<?php } else {
    header("location:  login.php");
}  ?>