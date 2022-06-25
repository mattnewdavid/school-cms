<?php
$title = "Admin - UMCATC";
require("config.php");

//Galery Insert
if (isset($_POST['save_image'])) {
    $category = $_POST['category'];
    $extension = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG');
    foreach ($_FILES['gallery_file']['tmp_name'] as $key => $value) {
        $images =  $_FILES['gallery_file']['name'][$key];
        $image_folder = 'uploads/';
        $path = $image_folder . basename($_FILES["gallery_file"]['name'][$key]);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $imagesize = $_FILES["gallery_file"]['size'][$key];
        $imagetmp = $_FILES["gallery_file"]['tmp_name'][$key];
        if (!in_array($ext, $extension)) {
            echo 'File type not supported';
        } elseif (!file_exists($path)) {
            $upload =   move_uploaded_file($imagetmp, $path);
            $finalpath = $path;
        } else {
            $new_path = $path . time() . "." . $ext;
            $upload = move_uploaded_file($imagetmp, $new_path);
            $finalpath = $new_path;
        }
        $query = "INSERT INTO gallery (`img_path`, `category`) VALUES('$images', '$category')";
        if ($result = mysqli_query($db, $query)) {
            $_SESSION['status'] = "Image uploaded successfully";
            echo ("<script>window.location.href='index.php?tab=gallery';</script>");
        } else {
            $_SESSION = 'ERROR:' . mysqli_error($db);
        }
    }
}

if (isset($_GET['del_image'])) {
    $del_id = $_GET['del_image'];

    if (mysqli_query($db, "DELETE FROM gallery WHERE id=$del_id")) {
        $_SESSION['status'] = "Image deleted successfully";
        echo ("<script>window.location.href='index.php?tab=gallery';</script>");
    } else {
        $_SESSION = 'ERROR:' . mysqli_error($db);
    }
}

if (isset($_POST['save_carousel'])) {
    $extension = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG');
    foreach ($_FILES['carousel_file']['tmp_name'] as $key => $value) {
        $images =  $_FILES['carousel_file']['name'][$key];
        $image_folder = 'uploads/';
        $path = $image_folder . basename($_FILES["carousel_file"]['name'][$key]);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $imagesize = $_FILES["carousel_file"]['size'][$key];
        $imagetmp = $_FILES["carousel_file"]['tmp_name'][$key];
        if (!in_array($ext, $extension)) {
            echo 'File type not supported';
        } elseif (!file_exists($path)) {
            $upload =   move_uploaded_file($imagetmp, $path);
            $finalpath = $path;
        } else {
            $new_path = $path . time() . "." . $ext;
            $upload = move_uploaded_file($imagetmp, $new_path);
            $finalpath = $new_path;
        }
        $query = "INSERT INTO carousel (`img_path`) VALUES('$images')";
        if ($result = mysqli_query($db, $query)) {
            $_SESSION['status'] = "Image uploaded successfully";
            echo ("<script>window.location.href='index.php?tab=gallery';</script>");
        } else {
            $_SESSION['error'] = 'ERROR:' . mysqli_error($db);
        }
    }
}

?>

<div class="inner-section">
    <div class="inner-section-heading mb-4">
        <h4>Gallery</h4>
        <a href="#gallery_target"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
    </div>
    <div>

        <?php while ($row = mysqli_fetch_assoc($gallery_distinct)) {
        ?>
            <div class="my-4">
                <h5><?php $gallery_category = $row['category'];
                    echo $gallery_category; ?></h5>
                <div class="row">
                    <?php
                    $gallery_select = mysqli_query($db, "SELECT * FROM gallery WHERE category='$gallery_category'");
                    while ($select = mysqli_fetch_array($gallery_select)) {
                    ?>
                        <div class="col-md-3 p-0 position-relative">
                            <img src="uploads/<?php echo $select['img_path'] ?>" class="w-100">

                            <a href="index.php?tab=gallery&del_image=<?php echo $select['id']; ?>#"><button class="btn btn-danger position-absolute" style="top:0px ; right: 0px"><i class="fa fa-trash"></i></button></a>

                        </div>

                    <?php }; ?>
                </div>
            </div>
        <?php }; ?>
        <div class="my-4">
            <h5>Banner Carousel</h5>
            <div class="row">
                <?php
                $carousel_select = mysqli_query($db, "SELECT * FROM carousel");
                while ($select = mysqli_fetch_array($carousel_select)) {
                ?>
                    <div class="col-md-3 p-0 position-relative">
                        <img src="uploads/<?php echo $select['img_path'] ?>" class="w-100">

                        <a href="index.php?tab=gallery&del_image=<?php echo $select['id']; ?>#"><button class="btn btn-danger position-absolute" style="top:0px ; right: 0px"><i class="fa fa-trash"></i></button></a>

                    </div>

                <?php }; ?>
            </div>
        </div>
    </div>
</div>

<form id="gallery_target" class="col-md-12 my-4 inner-section" action="" method="POST" enctype="multipart/form-data">
    <div class="my-4">
        <small>Note: </small><br>

        <small>- You can upload multiple images</small><br>
        <small>- Images should not be more than 2MB </small><br>
    </div>
    <div class="form-group">
        <input name="category" placeholder="Category/Event Here" class="form-control">
    </div>
    <input name="gallery_file[]" type="file" id="gallery_images" required multiple>
    <button type="submit" name="save_image" class="btn btn-custom text-white">Add to Gallery</button>
</form>

<form id="carousel_target" class="col-md-12 my-4 inner-section" action="" method="POST" enctype="multipart/form-data">
    <h5>Banner Carousel</h5>
    <div class="my-4">
        <small>Note: </small><br>
        <small>- Banner Carousel should be 1350px by 600px</small><br>
        <small>- You can upload multiple images</small><br>
        <small>- Images should not be more than 2MB </small><br>
    </div>
    <input name="carousel_file[]" type="file" id="carousel_images" required multiple style="width: 50%; padding:20px; border: 2px dashed red;"><br>
    <button type="submit" name="save_carousel" class="btn btn-custom text-white">Add to Banner Carousel</button>
</form>



<?php // require('footer.php') 
?>