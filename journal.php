<?php
$title = "Admin - UMCATC";
require("config.php");

// Insert into Post
if (isset($_POST['save_journal'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['body']);
    $author = mysqli_real_escape_string($db, $_POST['author']);

    // Image Upload
    $image_folder = 'uploads/';
    $image_name = $_FILES['journal_file']['name'];
    $path = $image_folder . basename($_FILES["journal_file"]['name']);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $imagesize = $_FILES["journal_file"]['size'];
    $imagetmp = $_FILES["journal_file"]['tmp_name'];
    if ($ext === "") {
        $query = "INSERT INTO journal(title, description, author) VALUES ('$title', '$description', '$author')";
        if ($sql = mysqli_query($db, $query)) {

            $_SESSION['status'] = "Journal added successfully";

            echo ("<script>window.location.href='index.php?tab=journal';</script>");
        } else {
            $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        }
    } elseif ($ext != "pdf" && $ext != "PDF" && $ext != "jpg" && $ext != 'JPG' && $ext != 'JPEG' && $ext != "jpeg") {
        echo 'File type not supported';
    } else {
        $upload = move_uploaded_file($imagetmp, $path);
        $query = "INSERT INTO journal(title, description, author) VALUES ('$title', '$description', '$author')";
        if ($sql = mysqli_query($db, $query)) {
            $_SESSION['status'] = "Journal added successfully";
            echo ("<script>window.location.href='index.php?tab=journal';</script>");
        } else {
            $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
        }
    }
}
// Update Post
if (isset($_POST['update_journal'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['body']);
    $author = mysqli_real_escape_string($db, $_POST['author']);
    $id = $_POST['id'];
    if (mysqli_query($db, "UPDATE journal SET title='$title', description='$description', author='$author' WHERE id=$id")) {
        $_SESSION['status'] = "Journal updated successfully";
        echo ("<script>window.location.href='index.php?tab=journal';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

// Delete Post
if (isset($_GET['del_journal'])) {
    $del_id = $_GET['del_journal'];
    if (mysqli_query($db, "DELETE FROM journal WHERE id=$del_id")) {
        $_SESSION['status'] = "Journal deleted successfully";
        echo ("<script>window.location.href='index.php?tab=journal';</script>");
    } else {
        $_SESSION['error'] = 'ERROR: ' . mysqli_error($db);
    }
}

?>
<?php //require('header.php') 
?>


<div class=" inner-section">
    <div class="inner-section-heading mb-4">
        <h4>Journals/Articles</h4>
        <a href="#form_target"><button class="btn btn-custom btn-sm text-white">Add New <i class="fa fa-plus ml-3"></i></button></a>
    </div>
    <table class="table table-bordered my-4" id="journaldataTable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($journal)) { ?>
                <tr>
                    <td><?php echo $row['title'] ?></td>
                    <td class="col-md-6"><?php echo $row['description'] ?></td>
                    <td class="col-md-4"><?php echo $row['author'] ?></td>
                    <td class="col-md-3">

                        <!-- <a href="index.php?tab=news&edit_post=<?php echo $row['id']; ?>#posts"><button class="btn btn-custom-secondary">Edit</button></a> -->
                        <a href="index.php?tab=news&edit_post=<?php echo $row['id']; ?>#form_target"><button class="btn btn-custom-secondary"><i class="fas fa-edit"></i></button></a>
                        <a href="index.php?tab=news&del_journal=<?php echo $row['id']; ?>#posts"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
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
        <h4>Edit Journal</h4>
    <?php } else { ?>
        <h4>Add New Journal</h4>
    <?php } ?>
    <?php
    if (isset($_GET["edit_post"])) {
        $edit_id =  $_GET["edit_post"];
        $edit_state = true;
        $rec = mysqli_query($db, "SELECT * FROM journal WHERE id=$edit_id");
        $record = mysqli_fetch_array($rec);
        $new_title = $record['title'];
        $new_body = $record['description'];
        $new_author = $record['author'];
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
        <textarea id="journaltextarea" name="body" class="form-control" placeholder="Description"><?php if (isset($_GET["edit_post"])) {
                                                                                                    $edit_state == true;
                                                                                                    echo $new_body;
                                                                                                } ?></textarea>
    </div>
    <div class="form-group form-cont">
        <input name="author" type="text" class="form-control" placeholder="Author" value="<?php if (isset($_GET["edit_post"])) {
                                                                                                $edit_state == true;
                                                                                                echo $new_author;
                                                                                            } ?>">
    </div>
    <div class="form-group">
        <input name="journal_file" type="file" id="journal_file">
    </div>
    <button class="btn btn-custom text-white" type="submit" name="<?php if (isset($_GET["edit_post"])) {
                                                                        echo "update_journal";
                                                                    } else {
                                                                        echo "save_journal";
                                                                    } ?>"><?php if (isset($_GET["edit_post"])) {
                                                                                echo "Update Journal";
                                                                            } else {
                                                                                echo "Add to Journals";
                                                                            } ?></button>
    <?php if (isset($_GET["edit_post"])) { ?>
        <a href="index.php?tab=journal" class="btn btn-custom-secondary">Cancel</a>
    <?php } ?>
</form>

<!----------------------------------------------------- End of News & Post Form --------------------------------------------------------------------------------->

<!--------------------------------------------- Display Table for News & Post ------------------------------------------------------->


<!--------------------------------------------- End of Display Table for News & Post ------------------------------------------------------->
<!-- </div> -->


<?php //require('footer.php') 
?>