<?php
$title = "Admin - UMCATC";
require("config.php");

// Insert into Post
if (isset($_POST['save_post'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $body = mysqli_real_escape_string($db, $_POST['body']);

    // Image Upload
    $image_folder = 'uploads/';
    $image_name = $_FILES['post_image']['name'];
    $path = $image_folder . basename($_FILES["post_image"]['name']);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $imagesize = $_FILES["post_image"]['size'];
    $imagetmp = $_FILES["post_image"]['tmp_name'];
    if ($ext === "") {
        $query = "INSERT INTO post(title, body) VALUES ('$title', '$body')";
        if ($sql = mysqli_query($db, $query)) {

            $_SESSION['status'] = "Post added successfully";

            echo ("<script>window.location.href='index.php?tab=news';</script>");
        } else {
            $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        }
    } elseif ($ext != "png" && $ext != "PNG" && $ext != "jpg" && $ext != 'JPG' && $ext != 'JPEG' && $ext != "jpeg") {
        echo 'File type not supported';
    } else {
        $upload = move_uploaded_file($imagetmp, $path);
        $query = "INSERT INTO post(title, body, img) VALUES ('$title', '$body', '$image_name')";
        if ($sql = mysqli_query($db, $query)) {
            $_SESSION['status'] = "Post added successfully";
            echo ("<script>window.location.href='index.php?tab=news';</script>");
        } else {
            $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        }
    }
}
// Update Post
if (isset($_POST['update_post'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $body = mysqli_real_escape_string($db, $_POST['body']);
    $id = $_POST['id'];
    if (mysqli_query($db, "UPDATE post SET title='$title', body='$body' WHERE id=$id")) {
        $_SESSION['status'] = "Post updated successfully";
        echo ("<script>window.location.href='index.php?tab=news';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

// Delete Post
if (isset($_GET['del_post'])) {
    $del_id = $_GET['del_post'];
    if (mysqli_query($db, "DELETE FROM post WHERE id=$del_id")) {
        $_SESSION['status'] = "Post deleted successfully";
        echo ("<script>window.location.href='index.php?tab=news';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

?>
<?php //require('header.php') 
?>


<div class=" inner-section">
    <div class="inner-section-heading mb-4">
        <h4>Posts</h4>
        <a href="#form_target"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
    </div>
    <table class="table table-bordered my-4" id="dataTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Body</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($post)) { ?>
                <tr>
                    <td><?php echo $row['title'] ?></td>
                    <td class="col-md-6"><?php echo $row['body'] ?></td>
                    <td class="col-md-4">
                        <img src="uploads/<?php echo $row['img'] ?>" class="w-50">
                    </td>
                    <td class="col-md-3">

                        <!-- <a href="index.php?tab=news&edit_post=<?php echo $row['id']; ?>#posts"><button class="btn btn-custom-secondary">Edit</button></a> -->
                        <a href="index.php?tab=news&edit_post=<?php echo $row['id']; ?>#form_target"><button class="btn btn-custom-secondary"><i class="fas fa-edit"></i></button></a>
                        <a href="index.php?tab=news&del_post=<?php echo $row['id']; ?>#posts"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                        <!-- <a href="index.php?tab=news&del_post=<?php echo $row['id']; ?>#posts"><button class="btn btn-danger">Delete</button></a> -->
                    </td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>
<!----------------------------------------------------- News & Post Form --------------------------------------------------------------------------------->
<form id="form_target" class="col-md-12 my-4 inner-section" method="POST" action="<?php if (isset($_GET["edit_post"])) {
                                                                                        echo "";
                                                                                    } else {
                                                                                        echo "";
                                                                                    } ?>" enctype="multipart/form-data">
    <?php if (isset($_GET["edit_post"])) { ?>
        <h4>Edit Post</h4>
    <?php } else { ?>
        <h4>Add New Post</h4>
    <?php } ?>
    <?php
    if (isset($_GET["edit_post"])) {
        $edit_id =  $_GET["edit_post"];
        $edit_state = true;
        $rec = mysqli_query($db, "SELECT * FROM post WHERE id=$edit_id");
        $record = mysqli_fetch_array($rec);
        $new_title = $record['title'];
        $new_body = $record['body'];
        $new_id = $record["id"];
    } ?>
    <div class="sent-notification"></div>
    <div class="form-group form-cont">
        <input type="hidden" name="id" value="<?php echo $new_id; ?>">
        <input name="title" type="text" class="form-control" placeholder="Title" value="<?php if (isset($_GET["edit_post"])) {
                                                                                            $edit_state == true;
                                                                                            echo $new_title;
                                                                                        } ?>">
    </div>
    <div class="form-group form-cont">
        <textarea id="mytextarea" name="body" class="form-control" placeholder="News"><?php if (isset($_GET["edit_post"])) {
                                                                                            $edit_state == true;
                                                                                            echo $new_body;
                                                                                        } ?></textarea>
    </div>
    <div class="form-group">
        <input name="post_image" type="file" id="gallery_images">
    </div>
    <button class="btn btn-custom text-white" type="submit" name="<?php if (isset($_GET["edit_post"])) {
                                                                        echo "update_post";
                                                                    } else {
                                                                        echo "save_post";
                                                                    } ?>"><?php if (isset($_GET["edit_post"])) {
                                                                                echo "Update News";
                                                                            } else {
                                                                                echo "Add to News";
                                                                            } ?></button>
    <?php if (isset($_GET["edit_post"])) { ?>
        <a href="index.php?tab=news" class="btn btn-custom-secondary">Cancel</a>
    <?php } ?>
</form>

<!----------------------------------------------------- End of News & Post Form --------------------------------------------------------------------------------->

<!--------------------------------------------- Display Table for News & Post ------------------------------------------------------->


<!--------------------------------------------- End of Display Table for News & Post ------------------------------------------------------->
<!-- </div> -->


<?php //require('footer.php') 
?>